document.addEventListener('DOMContentLoaded', function () {
    // Start
    console.log('');
    console.log('Project loaded');

    // Task rendering for items to be stored in localStorage
    const tasksKey = 'teamboard.tasks.v1';
    const projectsKey = 'teamBoardHub.projects.v1';

    // Load and display project information for team board
    function loadTeamInfo() {
        const projectNameEl = document.getElementById('projectName');

        try {
            const projectContext = getCurrentProjectContext();
            if (!projectContext.projectId) {
                if (projectNameEl) projectNameEl.textContent = 'No Project Assigned';
                return;
            }

            const projectsRaw = localStorage.getItem(projectsKey);
            if (!projectsRaw) {
                if (projectNameEl) projectNameEl.textContent = 'No Project Assigned';
                return;
            }

            const projects = JSON.parse(projectsRaw);
            const currentProject = projects.find(p => p.id === projectContext.projectId);

            if (currentProject) {
                if (projectNameEl) projectNameEl.textContent = currentProject.projectName;
            } else {
                if (projectNameEl) projectNameEl.textContent = 'No Project Assigned';
            }
        } catch (e) {
            console.error('Error loading project info:', e);
            if (projectNameEl) projectNameEl.textContent = 'Error Loading Project';
        }
    }


    // Popup show/hide
    const popup = document.getElementById('addTaskPopup');
    const cancelBtn = document.getElementById('cancelAddTask');
    const form = document.getElementById('add-task-form');

    function openPopup() {
        if (!popup) return; // no-op when popup isn't present on the page
        popup.classList.add('open');
        const first = popup.querySelector('input, textarea, button');
        if (first) first.focus();
    }
    function closePopup() {
        if (!popup) return; // no-op when popup isn't present on the page
        popup.classList.remove('open');
    }

    // open when the manager Add button is clicked
    const addBtn = document.getElementById('addTaskButton');
    if (addBtn) {
        addBtn.addEventListener('click', function (e) { e.preventDefault(); if (form) form.reset(); cleanupEditState(); openPopup(); });
    }
    // cancel button
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () { cleanupEditState(); closePopup(); });
    }
    // close on ESC
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { cleanupEditState(); closePopup(); } });

    // Use BroadcastChannel (when available) + storage event to notify other pages
    const bc = ('BroadcastChannel' in window) ? new BroadcastChannel('teamboard') : null;
    const board = document.querySelector('.board');
    const taskArea = document.querySelector('.task-area'); // prefer task-area container for shared tasks
    let editingId = null; // currently editing task id (null when adding)

    // --- user helpers ---------------------------------------------------------
    function getCurrentUser() {
        try {
            const raw = sessionStorage.getItem('teamboard.user') || localStorage.getItem('teamboard.user');
            if (!raw) return null;
            return JSON.parse(raw); // { username: 'alice', role: 'employee' }
        } catch (e) {
            return null;
        }
    }
    const currentUser = getCurrentUser();
    // Use logged-in username when available. When not logged in, generate a per-tab id
    let username = (currentUser && currentUser.username) ? currentUser.username : null;
    if (!username) {
        // try to reuse stable per-tab id stored in sessionStorage
        let tabId = sessionStorage.getItem('teamboard.tabId');
        if (!tabId) { tabId = 'tab-' + Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 6); sessionStorage.setItem('teamboard.tabId', tabId); }
        username = tabId; // for anonymous personal tasks
    }

    // personal tasks — stored under separate key and not broadcast to other tabs
    const personalTasksKey = `teamboard.personal.${username}`;
    let personalTasks = [];
    let editingPersonalId = null;
    let personalBoardContainer = null;
    let personalEmptyMsg = null;
    // -----------------------------------------------------------------------    

    function generateId() {
        return Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 8);
    }

    // Ensure all tasks have id so editing/deleting works on specified tasks
    function ensureTaskIds(arr) {
        return arr.map(t => ({ ...t, id: t.id || generateId() }));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Team Management Integration
    
    // Get current project context (from URL params, localStorage, or default)
    function getCurrentProjectContext() {
        const urlParams = new URLSearchParams(window.location.search);
        const projectId = urlParams.get('projectId');
        if (projectId) return { projectId, source: 'url' };

        const sessionProject = sessionStorage.getItem('currentProject');
        if (sessionProject) return { ...JSON.parse(sessionProject), source: 'session' };

        return { projectId: null, projectName: null, source: 'default' };
    }

    // Update the project's members list
    function updateProjectMembersFromTasks(projectId) {
        if (!projectId) return;
        try {
            const assignees = new Set();
            (tasks || []).forEach(t => {
                if (t.projectId && t.projectId === projectId && t.assignee && t.assignee.trim()) assignees.add(t.assignee.trim());
            });

            const raw = localStorage.getItem(projectsKey);
            if (!raw) return;
            const projects = JSON.parse(raw);
            const p = projects.find(x => x.id === projectId);
            if (!p) return;
            p.members = Array.from(assignees);
            localStorage.setItem(projectsKey, JSON.stringify(projects));
            console.log('Updated project members for', projectId, p.members);
        } catch (e) {
            console.error('Failed to update project members from tasks:', e);
        }
    }

    //Helper function: get project by ID
    function getProjectById(projectId) {
        try {
            const raw = localStorage.getItem(projectsKey);
            if (!raw) return null;
            const projects = JSON.parse(raw);
            return projects.find(p => p.id === projectId) || null;
        } catch (e) {
            return null;
        }
    }

    // Show dropdown of project members in team
    function showProjectMembers(projectId) {
        try {
            const context = projectId ? { projectId } : getCurrentProjectContext();
            const pid = projectId || (context && context.projectId) || null;

            // container for the members dropdown
            const containerId = 'projectMembersContainer';
            let container = document.getElementById(containerId);
            if (!container) {
                container = document.createElement('div');
                container.id = containerId;
                container.className = 'project-members';
                // place above task area 
                if (board && taskArea) board.insertBefore(container, taskArea);
                else if (board) board.appendChild(container);
            }


            // if no project context, hide container
            if (!pid) {
                container.classList.remove('open');
                return;
            }

            // populate options from project.members
            const project = getProjectById(pid);
            let members = (project && Array.isArray(project.members)) ? project.members.slice() : [];

            // remove duplicates and empty strings
            members = Array.from(new Set((members || []).map(m => (m || '').trim()).filter(Boolean)));

            // build the DOM: header + list
            container.innerHTML = '';
            const header = document.createElement('div');
            header.className = 'project-members-header';
            const h = document.createElement('strong');
            h.textContent = 'Team members:';
            header.appendChild(h);
            container.appendChild(header);

            const list = document.createElement('ul');
            list.className = 'project-members-list';
            if (members.length === 0) {
                const li = document.createElement('li');
                li.className = 'no-members';
                li.textContent = 'No team members';
                list.appendChild(li);
            } else {
                members.forEach(m => {
                    const li = document.createElement('li');
                    li.textContent = m;
                    list.appendChild(li);
                });
            }
            container.appendChild(list);
        } catch (e) {
            console.error('showProjectMembers error', e);
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Calendar integration

    // Calendar integration settings (placeholder endpoint until URL provided)
    const calendar = ''; // set to final endpoint URL when available
    const calendarAllStorageKey = 'teamboard.calendar.tasks'; // stores full tasks array for calendar

    // Convert date display (DD-MM-YYYY) to ISO (YYYY-MM-DD) to be sent to calendar
    function displayToIso(display) {
        if (!display) return '';
        const m = (display || '').trim().match(/^(\d{2})-(\d{2})-(\d{4})$/);
        if (!m) return '';
        return m[3] + '-' + m[2] + '-' + m[1];
    }

    // Build payload for single task for calendar
    function singleTaskPayload(task) {
        return {
            id: task.id,
            title: task.title || '',
            description: task.description || '',
            dueIso: task.dueIso || displayToIso(task.due || ''), // YYYY-MM-DD
            assignee: task.assignee || '',
            status: task.status || 'status-todo'
        };
    }

    // Build payload for all tasks and send as a single array to calendar
    function allTasksPayload(tasksArr) {
        const mapped = (tasksArr || []).map(t => singleTaskPayload(t));
        console.log('All tasks payload for calendar:', mapped);
        return {
            tasks: mapped //tasks now have properties from const mapped
        };
    }

    function sendAllTasksToCalendar() {
        try {
            const payload = allTasksPayload(tasks);
            console.log('Sending all tasks to calendar:', payload);
            const raw = JSON.stringify(payload);
            try { localStorage.setItem(calendarAllStorageKey, raw); } catch (e) { console.warn('Failed to write calendar tasks to localStorage', e); }
            try { if ('BroadcastChannel' in window) new BroadcastChannel('teamboard-calendar').postMessage({ type: 'tasks-updated', payload }); } catch (e) { }
            if (calendar) {  // currently empty string; set to final endpoint URL when available
                fetch(calendar, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: raw }).catch(err => console.warn('Calendar POST failed', err));
            }
        } catch (err) {
            console.error('sendAllTasksToCalendar error', err);
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // Show or hide the "no tasks" message based on current tasks in storage
    function EmptyMsgDisplay() {
        const emptyMsg = document.getElementById('EmptyMsg');
        const raw = localStorage.getItem(tasksKey);
        if (!raw || raw == '[]') {
            if (emptyMsg) emptyMsg.style.display = '';
            console.log('Empty message shown');
        } else {
            // Hide EmptyMsg if tasks are present
            if (emptyMsg) emptyMsg.style.display = 'none';
            console.log('Empty message hidden');
        }
    }

    // Show/hide for personal empty message
    function PersonalEmptyMsgDisplay() {
        if (!personalEmptyMsg) return;
        if (!personalTasks || personalTasks.length === 0) personalEmptyMsg.style.display = '';
        else personalEmptyMsg.style.display = 'none';
    }

    // Load tasks from localStorage
    function loadTasks() {
        const raw = localStorage.getItem(tasksKey);
        EmptyMsgDisplay();
        if (!raw || raw == '[]') {
            console.log('localStorage is empty or has no tasks')
            return null
        } else {
            console.log('Loaded tasks:', raw);
            return JSON.parse(raw);
        }
    }

    // Load personal tasks for the current user
    function loadPersonalTasks() {
        try {
            const raw = localStorage.getItem(personalTasksKey);
            if (!raw || raw == '[]') return [];
            return JSON.parse(raw);
        } catch (e) { console.warn('Failed to parse personal tasks', e); return []; }
    }

    // Save tasks to localStorage
    function saveTasks(arr) {
        const raw = JSON.stringify(arr, null, 2);
        console.log('Saving tasks:', raw);
        localStorage.setItem(tasksKey, raw);
        // broadcast to same-origin tabs
        try { if (bc) bc.postMessage({ type: 'tasks-updated', payload: raw }); } catch (e) { }

        EmptyMsgDisplay();
    }

    // Save personal tasks only to per-user key
    function savePersonalTasks(arr) {
        const raw = JSON.stringify(arr, null, 2);
        console.log('Saving personal tasks for', username, raw);
        try { localStorage.setItem(personalTasksKey, raw); } catch (e) { console.warn('Failed to write personal tasks', e); }
        PersonalEmptyMsgDisplay();
    }

    // Create a task element
    function createTaskElement(task) {
        const d = document.createElement('details');
        if (task.id) d.dataset.id = task.id;
        const s = document.createElement('summary');
        const title = document.createElement('span'); title.className = 'task-title'; title.textContent = task.title || 'Untitled';
        const meta = document.createElement('span'); meta.className = 'info';
        const risk = document.createElement('span');
        const riskValue = task.risk || '';
        risk.className = riskValue ? `info-pill risk-${riskValue}` : 'info-pill';
        risk.textContent = riskValue ? riskValue.charAt(0).toUpperCase() + riskValue.slice(1) : '';
        const badge = document.createElement('span'); badge.className = 'badge ' + (task.status || 'status-todo');
        const statusLabel = (function (s) {
            if (!s) return 'To Do';
            if (s === 'status-done') return 'Done';
            if (s === 'status-review') return 'Marked for Review';
            return 'To Do';
        })(task.status);
        badge.textContent = statusLabel;
        const emp = document.createElement('span'); emp.className = 'info-pill'; emp.textContent = (task.assignee || '').trim();
        const date = document.createElement('span'); date.className = 'info-pill';
        const dueRaw = (task.due || '').trim();
        let dueText = '';
        if (dueRaw) {
            const m = dueRaw.match(/^(\d{4})-(\d{2})-(\d{2})$/);
            dueText = m ? (m[3] + '-' + m[2] + '-' + m[1]) : dueRaw;
        }
        date.textContent = dueText;

        // Edit button (manager only) and Mark-as-done button (everyone)
        let editBtn = null;
        // create markDoneBtn so can toggle done state
        let markDoneBtn = document.createElement('button');
        markDoneBtn.type = 'button';
        markDoneBtn.className = 'mark-done-button';
        if (task.status === 'status-done') {
            markDoneBtn.textContent = 'Unmark as Done';
            markDoneBtn.classList.add('is-done');
        } else {
            markDoneBtn.textContent = 'Mark as Done';
        }
        markDoneBtn.style.display = 'none'; // shown when details is opened
        markDoneBtn.addEventListener('click', function (e) { e.stopPropagation(); toggleTaskDone(task.id); });

        // create markForReview button when a task is high risk (only for employee page)
        let markReviewBtn = null;
        if (!form) { // only on employee page where they dont have a form to edit tasks
            markReviewBtn = document.createElement('button');
            markReviewBtn.type = 'button';
            markReviewBtn.className = 'mark-review-button';
            markReviewBtn.textContent = 'Mark for Review';
            markReviewBtn.style.display = 'none'; // shown when details is opened (and only for high-risk tasks)
            markReviewBtn.addEventListener('click', function (e) {
                e.stopPropagation(); // prevent outer details toggle
                const t = tasks.find(x => x.id === task.id); // find the task in the tasks array
                if (!t) return; // if task not found, no-op
                // only allow marking for review when the risk level is high
                if ((t.risk || '').toLowerCase() !== 'high') return;
                t.status = 'status-review';
                saveTasks(tasks);
                try { sendAllTasksToCalendar(); } catch (err) { console.warn('Failed to send calendar tasks after review mark', err); }
                showAll();
            });
        }

        if (form) {
            editBtn = document.createElement('button');
            editBtn.type = 'button';
            editBtn.className = 'edit-task-button';
            editBtn.textContent = 'Edit';
            editBtn.style.display = 'none'; // shown when details is opened
            // e.stopPropagation avoids toggling details when clicking edit
            editBtn.addEventListener('click', function (e) { e.stopPropagation(); openEditTask(task.id); });
            // manager-only: Mark as Incomplete button (visible when task is in review)
            var markIncompleteBtn = document.createElement('button');
            markIncompleteBtn.type = 'button';
            markIncompleteBtn.className = 'mark-incomplete-button';
            markIncompleteBtn.textContent = 'Mark as Incomplete';
            markIncompleteBtn.style.display = 'none';
            markIncompleteBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                const t = tasks.find(x => x.id === task.id);
                if (!t) return;
                // set back to todo (original state)
                t.status = 'status-todo';
                saveTasks(tasks);
                try { sendAllTasksToCalendar(); } catch (err) { console.warn('Failed to send calendar snapshot after marking incomplete', err); }
                showAll();
            });
        }

        // place the info pills in the summary; buttons will be placed in the details body below
        meta.appendChild(badge);
        meta.appendChild(risk);
        meta.appendChild(emp);
        meta.appendChild(date);
        s.appendChild(title); s.appendChild(meta);
        const body = document.createElement('div'); body.className = 'details-body';
        const p = document.createElement('p'); p.textContent = task.description || '';

        // actions container (right aligned) below the description
        const actionsDiv = document.createElement('div');
        actionsDiv.className = 'details-actions';
        if (editBtn) actionsDiv.appendChild(editBtn);
        if (typeof markIncompleteBtn !== 'undefined' && markIncompleteBtn) actionsDiv.appendChild(markIncompleteBtn);
        // append mark-for-review button for high-risk tasks (employee pages)
        if (markReviewBtn) actionsDiv.appendChild(markReviewBtn);
        if (markDoneBtn) actionsDiv.appendChild(markDoneBtn);

        body.appendChild(p);
        body.appendChild(actionsDiv);
        d.appendChild(s); d.appendChild(body);

        // When the details toggles open, show the edit and mark-done buttons (if present)
        d.addEventListener('toggle', function () {
            if (!editBtn && !markDoneBtn && !markReviewBtn && typeof markIncompleteBtn === 'undefined') return;
            if (d.open) {
                if (editBtn) editBtn.style.display = '';
                // Manager view: show markDone always and show markIncomplete button when status is review
                if (form) {
                    if (markIncompleteBtn) markIncompleteBtn.style.display = (task.status === 'status-review') ? '' : 'none';
                    if (markDoneBtn) markDoneBtn.style.display = '';
                } else {
                    // Employee view: show mark-for-review for high-risk tasks
                    if (markReviewBtn) {
                        if ((task.risk || '').toLowerCase() === 'high' && task.status !== 'status-review') markReviewBtn.style.display = '';
                        else markReviewBtn.style.display = 'none';
                    }
                    // Employee should only be able to mark done for medium/low risk
                    if (markDoneBtn) {
                        const allowDone = ((task.risk || '').toLowerCase() !== 'high') && task.status !== 'status-review';
                        markDoneBtn.style.display = allowDone ? '' : 'none';
                    }
                }
            } else {
                if (editBtn) editBtn.style.display = 'none';
                if (typeof markIncompleteBtn !== 'undefined' && markIncompleteBtn) markIncompleteBtn.style.display = 'none';
                if (markReviewBtn) markReviewBtn.style.display = 'none';
                if (markDoneBtn) markDoneBtn.style.display = 'none';
            }
        });
        return d;
    }

    // --- Personal task element (per-user) -----------------------------------
    function createPersonalTaskElement(task) {
        const d = document.createElement('details');
        if (task.id) d.dataset.id = task.id;
        const s = document.createElement('summary');
        const title = document.createElement('span'); title.className = 'task-title'; title.textContent = task.title || 'Untitled';
        const meta = document.createElement('span'); meta.className = 'info';
        const badge = document.createElement('span'); badge.className = 'badge ' + (task.status || 'status-todo');
        badge.textContent = (task.status === 'status-done') ? 'Done' : ((task.status === 'status-review') ? 'Marked for Review' : 'To Do');
        const date = document.createElement('span'); date.className = 'info-pill';
        // show stored due value (DD-MM-YYYY or empty)
        date.textContent = task.due || '';

        meta.appendChild(badge); meta.appendChild(date);
        s.appendChild(title); s.appendChild(meta);
        const body = document.createElement('div'); body.className = 'details-body';
        const p = document.createElement('p'); p.textContent = task.description || '';

        // actions: edit, delete, mark-done
        const actionsDiv = document.createElement('div'); actionsDiv.className = 'details-actions';
        const editBtn = document.createElement('button'); editBtn.type = 'button'; editBtn.className = 'edit-task-button'; editBtn.textContent = 'Edit';
        const delBtn = document.createElement('button'); delBtn.type = 'button'; delBtn.className = 'delete-task-button'; delBtn.textContent = 'Delete';
        const markDoneBtn = document.createElement('button'); markDoneBtn.type = 'button'; markDoneBtn.className = 'mark-done-button'; markDoneBtn.textContent = (task.status === 'status-done') ? 'Unmark as Done' : 'Mark as Done';

        editBtn.addEventListener('click', function (e) { e.stopPropagation(); openPersonalEdit(task.id); });
        delBtn.addEventListener('click', function (e) { e.stopPropagation(); if (!confirm('Delete personal task?')) return; personalTasks = personalTasks.filter(t => t.id !== task.id); savePersonalTasks(personalTasks); showPersonalBoard(); });
        markDoneBtn.addEventListener('click', function (e) { e.stopPropagation(); const t = personalTasks.find(x => x.id === task.id); if (!t) return; t.status = (t.status === 'status-done') ? 'status-todo' : 'status-done'; savePersonalTasks(personalTasks); showPersonalBoard(); });

        actionsDiv.appendChild(editBtn); actionsDiv.appendChild(delBtn); actionsDiv.appendChild(markDoneBtn);
        body.appendChild(p); body.appendChild(actionsDiv);
        d.appendChild(s); d.appendChild(body);
        return d;
    }

    // Setup personal board DOM (second half of board)
    function setupPersonalBoard() {
        // create a container section under the main board
        personalBoardContainer = document.createElement('div');
        personalBoardContainer.className = 'personal-board';

        const header = document.createElement('div'); header.className = 'personal-board-header';
        const h = document.createElement('h2'); h.textContent = 'My Personal Tasks';
        const addBtn = document.createElement('button'); addBtn.type = 'button'; addBtn.className = 'add-personal-task-button'; addBtn.textContent = 'Add Personal Task';
        addBtn.addEventListener('click', function () { openPersonalAdd(); });
        header.appendChild(h); header.appendChild(addBtn);

        const list = document.createElement('div'); list.className = 'personal-list';
        personalEmptyMsg = document.createElement('p'); personalEmptyMsg.id = 'PersonalEmptyMsg'; personalEmptyMsg.textContent = 'You have no personal tasks. Add one by clicking "Add Personal Task".';
        list.appendChild(personalEmptyMsg);
        personalBoardContainer.appendChild(header); personalBoardContainer.appendChild(list);
        
        // append personal board after the main board content
        board.appendChild(document.createElement('hr'));
        board.appendChild(personalBoardContainer);
    }

    function showPersonalBoard() {
        if (!personalBoardContainer) setupPersonalBoard();
        const list = personalBoardContainer.querySelector('.personal-list');
        // remove existing personal details
        list.querySelectorAll('details').forEach(n => n.remove());
        if (!personalTasks || personalTasks.length === 0) { PersonalEmptyMsgDisplay(); return; }
        personalTasks.forEach(t => {
            const el = createPersonalTaskElement(t);
            list.appendChild(el);
        });
        PersonalEmptyMsgDisplay();
    }

    // Personal tasks popup (simple) -------------------------------------------------
    function ensurePersonalPopup() {
        if (document.getElementById('personalTaskPopup')) return;
        const ov = document.createElement('div'); ov.className = 'popup-overlay'; ov.id = 'personalTaskPopup';
        const p = document.createElement('div'); p.className = 'popup';
        const title = document.createElement('h3'); title.id = 'personalPopupTitle'; title.textContent = 'Add personal task';
        const formEl = document.createElement('form'); formEl.id = 'personal-task-form';
        formEl.innerHTML = `
            <label>Task title<input type="text" name="title" maxlength="60" required></label>
            <label>Description<textarea name="description" rows="3"></textarea></label>
            <label>Due date<input type="date" name="due"></label>
            <div class="popup-actions"><button type="submit" class="add-task-button">Save</button><button type="button" id="personalCancel">Cancel</button></div>`;
        p.appendChild(title); p.appendChild(formEl); ov.appendChild(p); document.body.appendChild(ov);
        
        // events
        formEl.addEventListener('submit', function (e) {
            e.preventDefault(); const fd = new FormData(formEl); const values = { title: (fd.get('title') || '').trim(), description: (fd.get('description') || '').trim(), due: (function (v) { if (!v) return ''; const m = v.match(/^(\d{4})-(\d{2})-(\d{2})$/); return m ? (m[3] + '-' + m[2] + '-' + m[1]) : v; })(fd.get('due') || ''), status: 'status-todo' };
            if (editingPersonalId) { const idx = personalTasks.findIndex(x => x.id === editingPersonalId); if (idx !== -1) { personalTasks[idx] = { ...personalTasks[idx], ...values }; } editingPersonalId = null; }
            else { personalTasks.push({ id: generateId(), ...values }); }
            savePersonalTasks(personalTasks); showPersonalBoard(); hidePersonalPopup();
        });
        formEl.querySelector('#personalCancel').addEventListener('click', function () { hidePersonalPopup(); });
    }

    function openPersonalAdd() { ensurePersonalPopup(); const ov = document.getElementById('personalTaskPopup'); ov.classList.add('open'); const formEl = ov.querySelector('form'); formEl.reset(); editingPersonalId = null; document.getElementById('personalPopupTitle').textContent = 'Add personal task'; const first = formEl.querySelector('input, textarea'); if (first) first.focus(); }
    function hidePersonalPopup() { const ov = document.getElementById('personalTaskPopup'); if (ov) ov.classList.remove('open'); }
    function openPersonalEdit(id) {
        ensurePersonalPopup(); const ov = document.getElementById('personalTaskPopup'); const formEl = ov.querySelector('form'); const t = personalTasks.find(x => x.id === id); if (!t) return; editingPersonalId = id; formEl.elements['title'].value = t.title || ''; formEl.elements['description'].value = t.description || ''; // convert DD-MM-YYYY to ISO for input
        formEl.elements['due'].value = (function (v) { if (!v) return ''; const m = v.match(/^(\d{2})-(\d{2})-(\d{4})$/); return m ? (m[3] + '-' + m[2] + '-' + m[1]) : v; })(t.due || ''); document.getElementById('personalPopupTitle').textContent = 'Edit personal task'; ov.classList.add('open');
    }
    // ------------------------------------------------------------------------

    // initialise tasks: load from localStorage
    let tasks = loadTasks();

    function normaliseLoadedTasks(arr) {
        // Ensure tasks use DD-MM-YYYY for stored/display dates.
        return arr.map(t => {
            const due = (t.due || '').trim();
            const m = due.match(/^(\d{4})-(\d{2})-(\d{2})$/);
            const dueOut = m ? (m[3] + '-' + m[2] + '-' + m[1]) : due;
            return { ...t, due: dueOut };
        });
    }

    if (tasks === null) {
        // collect raw displayed values
        const seed = Array.from(document.querySelectorAll('.task-area > details')).map(function (detail) {
            const title = detail.querySelector('.task-title')?.textContent?.trim() || '';
            const description = detail.querySelector('.details-body p')?.textContent?.trim() || '';

            // read info pills: risk, assignee, due date
            const infoPills = detail.querySelectorAll('.info .info-pill');
            const risk = infoPills[0]?.textContent?.trim() || '';
            const assignee = infoPills[1]?.textContent?.trim() || '';
            const due = infoPills[2]?.textContent?.trim() || '';
            const badge = detail.querySelector('.info .badge');

            // determine status from badge class
            let status = 'status-todo';
            if (badge) {
                if (badge.classList.contains('status-done')) status = 'status-done';
                else if (badge.classList.contains('status-review')) status = 'status-review';
            }
            return { title, description, assignee, due, status, risk };
        });
        if (seed.length > 0) {
            // normalise dates to ISO so storage is consistent
            let normalised = normaliseLoadedTasks(seed);
            normalised = ensureTaskIds(normalised);
            tasks = normalised;
            saveTasks(tasks);
        } else {
            // no seeds found on this page
            tasks = [];
        }
    } else {
        // clear existing details to prevent duplicates
        document.querySelectorAll('.task-area > details').forEach(function (n) { n.remove(); });
    }

    // if tasks loaded from storage, normalise to ensure ISO dates
    if (tasks) {
        tasks = normaliseLoadedTasks(tasks);
        tasks = ensureTaskIds(tasks);
    }

    // show tasks into the shared task area (above the line/personal board)
    function showAll() {
        // remove existing details to prevent duplicates
        (taskArea.querySelectorAll('details') || []).forEach(function (n) { n.remove(); });
        try {
            const context = getCurrentProjectContext();
            const currentProjectId = context && context.projectId ? context.projectId : null;
            
            // If tasks exist, filter by projectId when viewing a project page.
            const toRender = (tasks || []).filter(function (t) {
                // Only show tasks that belong to the current project when a projectId is present
                if (currentProjectId) return t.projectId && t.projectId === currentProjectId;
                // When no project context, show all non-project tasks (or all tasks)
                return true;
            });
            toRender.forEach(function (t) { taskArea.appendChild(createTaskElement(t)); });
        } catch (err) {
            console.error('showAll error', err);
        }
    }


    showAll();
    
    // Load team information for team leader dashboard
    loadTeamInfo();
    // Show project members dropdown for the current project (if any)
    try { showProjectMembers(getCurrentProjectContext().projectId); } catch (e) { }

    
    // "View Team List" button to toggle members panel
    (function linkTeamListButton() {
        const btn = document.getElementById('teamList');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const context = getCurrentProjectContext(); // get project ID from URL/session/default
            console.log('Current project context for team list button:', context);
            const pid = context && context.projectId ? context.projectId : null;
            console.log('Toggling team members for project:', pid);

            // ensure markup exists and is up-to-date
            try { showProjectMembers(pid); } catch (err) { }
            const container = document.getElementById('projectMembersContainer');
            if (!container) return;
            container.classList.toggle('open');
        });

        // close panel when clicking outside
        document.addEventListener('click', function (ev) {
            const container = document.getElementById('projectMembersContainer');
            if (!container || !container.classList.contains('open')) return;
            const isClickInside = container.contains(ev.target) || btn.contains(ev.target);
            if (!isClickInside) container.classList.remove('open');
        });
    })();

    // Load personal tasks for current user and show personal board
    personalTasks = loadPersonalTasks() || [];
    personalTasks = normaliseLoadedTasks(personalTasks);
    personalTasks = ensureTaskIds(personalTasks);
    showPersonalBoard();

    // handle submit: create a task, persist and append
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const projectContext = getCurrentProjectContext();
            const values = {
                title: form.title.value.trim(),
                description: form.description.value.trim(),
                // store DD-MM-YYYY (UK display) — convert the date input (ISO) to display format
                due: (function (v) { if (!v) return ''; const m = v.match(/^(\d{4})-(\d{2})-(\d{2})$/); return m ? (m[3] + '-' + m[2] + '-' + m[1]) : v; })(form.due.value || '') || '',
                assignee: form.assignee.value.trim(),
                risk: form.risk.value || '',
                status: 'status-todo',
                projectId: projectContext.projectId || null
            };
            if (editingId) {
                // update existing task
                console.log('Editing task id:', editingId);
                const idx = tasks.findIndex(x => x.id === editingId);
                if (idx !== -1) { // if task found
                    tasks[idx] = { ...tasks[idx], ...values }; // update tasks[idx] with values from values variable
                }
                // send updated task to calendar 
                if (idx !== -1) sendAllTasksToCalendar(); // if task found, send updated tasks
                editingId = null;
            } else {
                console.log('--------------------------')
                console.log('Adding new task', values);
                // create new task with id if not editing
                const newTask = { id: generateId(), ...values }; // create new task with id
                tasks.push(newTask);
                sendAllTasksToCalendar();
            }
            saveTasks(tasks);

            // Update and show project members for current project (if any)
            const pid = values.projectId || (projectContext && projectContext.projectId) || null;
            if (pid) {
                try { updateProjectMembersFromTasks(pid); } catch (e) { }
                try { showProjectMembers(pid); } catch (e) { }
            } else {
                // ensure dropdown hidden when not in project context
                try { showProjectMembers(null); } catch (e) { }
            }

            showAll();
            form.reset();
            // cleanup edit state and close
            cleanupEditState();
            closePopup();
        });
    }

    function cleanupEditState() {
        editingId = null;
        // restore popup header and remove delete button if present
        const titleEl = document.getElementById('addTaskTitle');
        if (titleEl) titleEl.textContent = 'Add a new task';
        const del = document.getElementById('deleteTaskButton');
        if (del) del.remove();
        if (form) form.removeAttribute('data-editing');
    }

    function openEditTask(id) {
        if (!form || !popup) return; // only available on manager page
        const task = tasks.find(t => t.id === id);
        if (!task) return;
        editingId = id;
        form.title.value = task.title || '';
        form.description.value = task.description || '';
        // convert stored DD-MM-YYYY back to ISO for the date input
        form.due.value = (function (v) { if (!v) return ''; const m = v.match(/^(\d{2})-(\d{2})-(\d{4})$/); return m ? (m[3] + '-' + m[2] + '-' + m[1]) : v; })(task.due) || '';
        form.assignee.value = task.assignee || '';
        // Set the risk level radio button
        if (task.risk) {
            const riskRadio = form.querySelector(`input[name="risk"][value="${task.risk}"]`);

            if (riskRadio) riskRadio.checked = true;
        }
        form.setAttribute('data-editing', id);
        const titleEl = document.getElementById('addTaskTitle');
        if (titleEl) titleEl.textContent = 'Edit task';

        // delete button in popup actions
        const actions = popup.querySelector('.popup-actions');
        if (actions) {
            let del = document.getElementById('deleteTaskButton');
            if (!del) {
                del = document.createElement('button');
                del.type = 'button';
                del.id = 'deleteTaskButton';
                del.className = 'delete-task-button';
                del.textContent = 'Delete';
                del.addEventListener('click', function () {
                    if (!confirm('Delete this task?')) return;

                    // recalculate projectId before removing task
                    const deletedTask = tasks.find(t => t.id === id);
                    const deletedPid = deletedTask ? deletedTask.projectId : null;
                    tasks = tasks.filter(t => t.id !== id);
                    saveTasks(tasks);
                    console.log('--------------------------')
                    console.log('Task deleted:', id);
                    // send tasks to calendar to sync
                    try { sendAllTasksToCalendar(); } catch (e) { console.warn('Failed to send calendar snapshot after delete', e); }
                    
                    // update project members and re-render dropdown for deleted project
                    if (deletedPid) {
                        try { updateProjectMembersFromTasks(deletedPid); } catch (e) { }
                        try { showProjectMembers(deletedPid); } catch (e) { }
                    } else {
                        try { showProjectMembers(getCurrentProjectContext().projectId); } catch (e) { }
                    }
                    showAll();
                    cleanupEditState();
                    closePopup();
                });
                // insert delete button before Cancel button
                const cancel = actions.querySelector('#cancelAddTask');
                if (cancel) actions.insertBefore(del, cancel);
                else actions.appendChild(del);
            }
        }
        openPopup();
    }

    function toggleTaskDone(id) {
        const task = tasks.find(t => t.id === id);
        if (!task) return;
        if (task.status === 'status-done') {
            task.status = 'status-todo';
        } else {
            task.status = 'status-done';
        }
        saveTasks(tasks);
        // send tasks to calendar to sync
        try { sendAllTasksToCalendar(); } catch (e) { console.warn('Failed to send calendar snapshot after toggle', e); }
        showAll();
    }

    // Listen for changes to localStorage from other tabs
    window.addEventListener('storage', function (e) {
        if (e.key !== tasksKey) return; // ignore other keys
        try {
            if (e.newValue === null) {
                // remote tab cleared the tasks
                tasks = [];
                showAll();

                // recalculate and show members for current project
                try { 
                    const context = getCurrentProjectContext(); 
                    const pid = context && context.projectId ? context.projectId : null; 
                    if (pid) { 
                        updateProjectMembersFromTasks(pid); 
                        showProjectMembers(pid);
                    } else { 
                        showProjectMembers(null); 
                    } 
                } catch (err) {}

                return;
            }
            const updated = JSON.parse(e.newValue);
            if (!Array.isArray(updated)) {
                console.warn('Received non-array tasks from storage; ignoring:', updated);
                return;
            }
            tasks = normaliseLoadedTasks(updated);
            showAll();
            EmptyMsgDisplay();
            // Recalculate project members for the current project and re-render dropdown
            try { const context = getCurrentProjectContext();
                const pid = context && context.projectId ? context.projectId : null; 
                if (pid) { updateProjectMembersFromTasks(pid); 
                    showProjectMembers(pid); 
                } else { 
                    showProjectMembers(null); 
                } 
            } catch (err) { }
        } catch (error) {
            console.error('Failed to update tasks from storage:', error);
        }
    });
});
