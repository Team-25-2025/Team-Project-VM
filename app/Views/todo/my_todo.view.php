
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My to do</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.view.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">

</head>
<body>

<?php view('partials/nav.php') ?>

<div class="main-content" id="mainContent">
<nav class="navbar bg-light px-4">
<div class="container-fluid">
<div class="navbar-brand">
<button class="sidebar-toggle-inline" id="sidebarToggleInline">
    <i class="fas fa-bars"></i>
</button>
<img src="\..\TeamProjectManage/public/images/logo.png" alt="my tasks logo" width="40" class="me-2">
</div>
</div>
</nav>

<div class="container-fluid p-4">
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">My Tasks</h1>
            </div>
            
            
            <div class="row g-3 align-items-center">
                
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search tasks...">
                    </div>
                </div>
                
                
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                        <select class="form-select" id="priorityFilter">
                            <option value="all">All Priorities</option>
                            <option value="critical">Critical</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                </div>
                
               
                <div class="col-md-5 text-end">
                    <div class="view-switcher d-inline-flex">
                        <button class="view-btn active" id="kanbanBtn">
                            <i class="fas fa-th me-2"></i>Kanban
                        </button>
                        <button class="view-btn" id="listBtn">
                            <i class="fas fa-list me-2"></i>List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div id="kanbanView">
        <div class="row g-3">
            
            <div class="col-lg-4 col-md-12">
                <div class="kanban-column">
                    <div class="kanban-header kanban-todo d-flex justify-content-between align-items-center">
                        <span>To Do</span>
                        <span class="count-badge" id="todoCount">0</span>
                    </div>
                    <div id="todoColumn"></div>
                </div>
            </div>
            
            
            <div class="col-lg-4 col-md-12">
                <div class="kanban-column">
                    <div class="kanban-header kanban-progress d-flex justify-content-between align-items-center">
                        <span>In Progress</span>
                        <span class="count-badge" id="progressCount">0</span>
                    </div>
                    <div id="progressColumn"></div>
                </div>
            </div>
            
           
            <div class="col-lg-4 col-md-12">
                <div class="kanban-column">
                    <div class="kanban-header kanban-done d-flex justify-content-between align-items-center">
                        <span>Done</span>
                        <span class="count-badge" id="doneCount">0</span>
                    </div>
                    <div id="doneColumn"></div>
                </div>
            </div>
        </div>
    </div>
    
   
    <div id="listView" style="display: none;">
        <div id="listContainer"></div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php requireModule(['nav']) ?>
<script>


const tasks = [
    {
        id: 1,
        title: 'Update project documentation',
        description: 'Review and update all technical documentation',
        status: 'todo',
        priority: 'high',
        dueDate: '2025-10-15',
        assignee: 'John Smith',
        project: 'Documentation'
    },
    {
        id: 2,
        title: 'Fix login bug',
        description: 'Resolve authentication issue reported by users',
        status: 'todo',
        priority: 'critical',
        dueDate: '2025-10-14',
        assignee: 'Sarah Johnson',
        project: 'Bug Fixes'
    },
    {
        id: 3,
        title: 'Design new dashboard layout',
        description: 'Create mockups for the analytics dashboard',
        status: 'progress',
        priority: 'medium',
        dueDate: '2025-10-20',
        assignee: 'Mike Chen',
        project: 'UI Design'
    },
    {
        id: 4,
        title: 'Code review for PR #234',
        description: 'Review team member\'s pull request',
        status: 'progress',
        priority: 'medium',
        dueDate: '2025-10-16',
        assignee: 'Emma Davis',
        project: 'Development'
    },
    {
        id: 5,
        title: 'Deploy to staging',
        description: 'Deploy latest changes to staging environment',
        status: 'done',
        priority: 'high',
        dueDate: '2025-10-12',
        assignee: 'John Smith',
        project: 'DevOps'
    },
    {
        id: 6,
        title: 'Client meeting preparation',
        description: 'Prepare presentation slides for quarterly review',
        status: 'done',
        priority: 'low',
        dueDate: '2025-10-13',
        assignee: 'Sarah Johnson',
        project: 'Management'
    }
];

let currentView = 'kanban';
let searchTerm = '';
let filterPriority = 'all';


function createTaskCard(task) {
    const priorityIcon = (task.priority === 'critical' || task.priority === 'high') ? 
        '<i class="fas fa-flag text-danger"></i>' : 
        (task.priority === 'medium') ? '<i class="fas fa-flag text-warning"></i>' : 
        '<i class="fas fa-flag text-success"></i>';
    
    return `
        <div class="task-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="mb-0 flex-grow-1">${task.title}</h6>
                ${priorityIcon}
            </div>
            <p class="text-muted small mb-3">${task.description}</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3 small text-muted">
                    <span><i class="far fa-calendar me-1"></i>${task.dueDate}</span>
                    <span><i class="far fa-user me-1"></i>${task.assignee}</span>
                </div>
                <span class="priority-badge priority-${task.priority}">${task.priority}</span>
            </div>
        </div>
    `;
}


function getFilteredTasks() {
    return tasks.filter(task => {
        const matchesSearch = task.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                            task.description.toLowerCase().includes(searchTerm.toLowerCase());
        const matchesPriority = filterPriority === 'all' || task.priority === filterPriority;
        return matchesSearch && matchesPriority;
    });
}


function renderKanban() {
    const filteredTasks = getFilteredTasks();
    
    const todoTasks = filteredTasks.filter(t => t.status === 'todo');
    const progressTasks = filteredTasks.filter(t => t.status === 'progress');
    const doneTasks = filteredTasks.filter(t => t.status === 'done');
    
    document.getElementById('todoColumn').innerHTML = todoTasks.length ? 
        todoTasks.map(createTaskCard).join('') : 
        '<div class="text-center text-muted py-5">No tasks</div>';
    
    document.getElementById('progressColumn').innerHTML = progressTasks.length ? 
        progressTasks.map(createTaskCard).join('') : 
        '<div class="text-center text-muted py-5">No tasks</div>';
    
    document.getElementById('doneColumn').innerHTML = doneTasks.length ? 
        doneTasks.map(createTaskCard).join('') : 
        '<div class="text-center text-muted py-5">No tasks</div>';
    
    document.getElementById('todoCount').textContent = todoTasks.length;
    document.getElementById('progressCount').textContent = progressTasks.length;
    document.getElementById('doneCount').textContent = doneTasks.length;
}


function renderList() {
    const filteredTasks = getFilteredTasks();
    
    const statuses = [
        { id: 'todo', label: 'To Do', class: 'status-todo' },
        { id: 'progress', label: 'In Progress', class: 'status-progress' },
        { id: 'done', label: 'Done', class: 'status-done' }
    ];
    
    let html = '';
    
    statuses.forEach(status => {
        const statusTasks = filteredTasks.filter(t => t.status === status.id);
        
        html += `
            <div class="mb-4">
                <div class="list-group-header">
                    <span class="status-indicator ${status.class}"></span>
                    <span>${status.label}</span>
                    <span class="count-badge">${statusTasks.length}</span>
                </div>
                ${statusTasks.length ? 
                    statusTasks.map(createTaskCard).join('') : 
                    '<div class="text-center text-muted py-4 bg-light rounded">No tasks in this category</div>'
                }
            </div>
        `;
    });
    
    document.getElementById('listContainer').innerHTML = html;
}


function switchView(view) {
    currentView = view;
    
    if (view === 'kanban') {
        document.getElementById('kanbanView').style.display = 'block';
        document.getElementById('listView').style.display = 'none';
        document.getElementById('kanbanBtn').classList.add('active');
        document.getElementById('listBtn').classList.remove('active');
        renderKanban();
    } else {
        document.getElementById('kanbanView').style.display = 'none';
        document.getElementById('listView').style.display = 'block';
        document.getElementById('kanbanBtn').classList.remove('active');
        document.getElementById('listBtn').classList.add('active');
        renderList();
    }
}


document.getElementById('kanbanBtn').addEventListener('click', () => switchView('kanban'));
document.getElementById('listBtn').addEventListener('click', () => switchView('list'));

document.getElementById('searchInput').addEventListener('input', (e) => {
    searchTerm = e.target.value;
    currentView === 'kanban' ? renderKanban() : renderList();
});

document.getElementById('priorityFilter').addEventListener('change', (e) => {
    filterPriority = e.target.value;
    currentView === 'kanban' ? renderKanban() : renderList();
});


renderKanban();
</script>
</body>
</html>