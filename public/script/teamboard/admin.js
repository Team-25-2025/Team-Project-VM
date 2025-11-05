document.addEventListener('DOMContentLoaded', function () {
    console.log('Manager Dashboard initialized');

    // Storage keys
    const projectsKey = 'teamBoardHub.projects.v1';
    
    // Use BroadcastChannel for cross-tab communication
    const bc = ('BroadcastChannel' in window) ? new BroadcastChannel('teamboard-manager') : null;

    // Popup elements
    const projectPopup = document.getElementById('addProjectPopup');
    const projectForm = document.getElementById('add-project-form');
    const cancelProjectBtn = document.getElementById('cancelAddProject');
    const addProjectBtn = document.getElementById('addProjectButton');

    // Popup controls
    function openProjectPopup() {
        if (!projectPopup) return;
        projectPopup.classList.add('open');
        const first = projectPopup.querySelector('input, textarea, button');
        if (first) first.focus();
    }

    function closeProjectPopup() {
        if (!projectPopup) return;
        projectPopup.classList.remove('open');
        // cleanup edit state
        try {
            if (projectForm) {
                projectForm.removeAttribute('data-editing');
                projectForm.reset();
            }
            const titleElement = document.getElementById('addProjectTitle');
            if (titleElement) titleElement.textContent = 'Create a new project';
            // remove any delete button added during edit
            const delBtn = projectPopup.querySelector('#deleteProjectButton');
            if (delBtn) delBtn.remove();
        } catch (e) {
            // low risk cleanup failure
        }
    }

    // Event listeners for popup
    if (addProjectBtn) {
        addProjectBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (projectForm) projectForm.reset();
            openProjectPopup();
        });
    }

    if (cancelProjectBtn) {
        cancelProjectBtn.addEventListener('click', function () {
            closeProjectPopup();
        });
    }

    // Close on ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeProjectPopup();
        }
    });

    // ID generator
    function generateId() {
        return Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 8);
    }

    function EmptyMsgDisplayProjects() {
        const raw = localStorage.getItem(projectsKey);
        const emptyMsg = document.getElementById('EmptyMsg-Projects');
        if (!raw || raw == '[]') {
            if (emptyMsg) emptyMsg.style.display = '';
        } else {
            if (emptyMsg) emptyMsg.style.display = 'none';
        }
    }


    // Load data from localStorage
    function loadProjects() {
        try {
            const raw = localStorage.getItem(projectsKey);
            if (!raw || raw == '[]') return [];
            return JSON.parse(raw);
        } catch (e) {
            console.warn('Failed to load projects', e);
            return [];
        }
    }


    // Save data to localStorage
    function saveProjects(arr) {
        const raw = JSON.stringify(arr, null, 2);
        console.log('Saving projects:', raw);
        localStorage.setItem(projectsKey, raw);
        try { if (bc) bc.postMessage({ type: 'projects-updated', payload: raw }); } catch (e) { }
        EmptyMsgDisplayProjects();
    }


    // Initialize data
    let projects = loadProjects();

    // Create project element for display
    function createProjectElement(project) {
        const div = document.createElement('div');
        div.className = 'project-card';
        div.dataset.id = project.id;

        const header = document.createElement('div');
        header.className = 'project-header';
        
        const title = document.createElement('h3');
        title.textContent = project.projectName;
        
        header.appendChild(title);

        const details = document.createElement('div');
        details.className = 'project-details';
        
        const description = document.createElement('p');
        description.textContent = project.projectDescription;
        
        const meta = document.createElement('div');
        meta.className = 'project-meta';
        meta.innerHTML = `
            <div><strong>Team Leader:</strong> ${project.teamLeader || 'N/A'}</div>
            <div><strong>Start Date:</strong> ${project.startDate || 'N/A'}</div>
            <div><strong>Target End:</strong> ${project.endDate || 'N/A'}</div>
        `;

        const actions = document.createElement('div');
        actions.className = 'project-actions';
        
        const viewBtn = document.createElement('button');
        viewBtn.textContent = 'View Team Tasks';
        viewBtn.className = 'view-team-button';
        viewBtn.addEventListener('click', function() {
            viewProjectTasks(project.id);
        });
        
        const editBtn = document.createElement('button');
        editBtn.textContent = 'Edit Project';
        editBtn.className = 'edit-project-button';
        editBtn.addEventListener('click', function() {
            editProject(project.id);
        });

        actions.appendChild(viewBtn);
        actions.appendChild(editBtn);

        details.appendChild(description);
        details.appendChild(meta);
        details.appendChild(actions);

        div.appendChild(header);
        div.appendChild(details);

        return div;
    }


    // Render functions
    function renderProjects() {
        const projectsArea = document.querySelector('.projects-area');
        if (!projectsArea) return;

        // Remove existing project cards
        projectsArea.querySelectorAll('.project-card').forEach(card => card.remove());

        if (!projects || projects.length === 0) {
            EmptyMsgDisplayProjects();
            return;
        }

        projects.forEach(project => {
            const element = createProjectElement(project);
            projectsArea.appendChild(element);
        });

        EmptyMsgDisplayProjects();
    }

    // Project form submission
    if (projectForm) {
        projectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(projectForm);
            const editingId = projectForm.getAttribute('data-editing');

            if (editingId) {
                // Update existing project
                const project = projects.find(p => p.id === editingId);
                if (project) {
                    project.projectName = (formData.get('projectName') || '').trim();
                    project.projectDescription = (formData.get('projectDescription') || '').trim();
                    project.teamLeader = (formData.get('teamLeader') || '').trim();
                    project.startDate = formData.get('startDate');
                    project.endDate = formData.get('endDate');
                    saveProjects(projects);
                    console.log('Project updated:', project);
                    renderProjects();
                }
            } else {
                // Create new project (existing behavior)
                const projectData = {
                    id: generateId(),
                    projectName: (formData.get('projectName') || '').trim(),
                    projectDescription: (formData.get('projectDescription') || '').trim(),
                    teamLeader: (formData.get('teamLeader') || '').trim(),
                    startDate: formData.get('startDate'),
                    endDate: formData.get('endDate'),
                    createdDate: new Date().toISOString().split('T')[0]
                };
                projects.push(projectData);
                saveProjects(projects);
                console.log('Project created:', projectData);
                renderProjects();
            }

            // Close popup and reset form
            closeProjectPopup();
        });
    }

    // Helper functions for team management
    function viewProjectTasks(projectId) {
        const project = projects.find(p => p.id === projectId);
        console.log('Project ID:', projectId);
        if (!project) return;

        console.log('Viewing tasks for project:', project.projectName);
        // Set project context in session storage and redirect to team board page
        sessionStorage.setItem('currentProject', JSON.stringify({
            projectId: project.id,
            projectName: project.projectName,
            teamLeader: project.teamLeader || ''
        }));

        // Open team board with corresponding project context
        window.open(`Team-Board_Manager.html?projectId=${project.id}`, '_blank');
    }

    // edit functionality
    function editProject(projectId) {
        const project = projects.find(p => p.id === projectId);
        if (!project) return;

        console.log('Editing project:', project.projectName);
        // fill the popup form with existing values
        if (!projectForm) return;
        projectForm.setAttribute('data-editing', projectId);
        projectForm.projectName.value = project.projectName || '';
        projectForm.projectDescription.value = project.projectDescription || '';
        projectForm.teamLeader.value = project.teamLeader || '';
        projectForm.startDate.value = project.startDate || '';
        projectForm.endDate.value = project.endDate || '';

        // change title
        const titleElement = document.getElementById('addProjectTitle');
        if (titleElement) titleElement.textContent = 'Edit project';

        // add a delete button to popup actions
        const actions = projectPopup.querySelector('.popup-actions');
        if (actions && !projectPopup.querySelector('#deleteProjectButton')) {
            const del = document.createElement('button');
            del.type = 'button';
            del.id = 'deleteProjectButton';
            del.className = 'delete-project-button';
            del.textContent = 'Delete';
            del.addEventListener('click', function () {
                if (!confirm('Delete this project? This cannot be undone.')) return;
                // remove project
                const index = projects.findIndex(p => p.id === projectId);
                if (index >= 0) {
                    projects.splice(index, 1);
                    saveProjects(projects);
                    renderProjects();
                }
                closeProjectPopup();
            });
            // put delete before the cancel button
            const cancelBtnLocal = actions.querySelector('#cancelAddProject');
            if (cancelBtnLocal) actions.insertBefore(del, cancelBtnLocal);
            else actions.appendChild(del);
        }

        openProjectPopup();
    }

    // Initial render
    renderProjects();
});