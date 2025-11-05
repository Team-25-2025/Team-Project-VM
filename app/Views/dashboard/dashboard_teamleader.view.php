<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Team Leader Dashboard - Make-It-All</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.view.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin: 8px 0;
    }
    
    .stat-label {
        color: #666;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 12px;
    }
    
    .stat-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .stat-danger { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .stat-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .stat-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }
    
    .chart-container {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }
    
    .workload-bar {
        height: 30px;
        background: #e0e0e0;
        border-radius: 6px;
        position: relative;
        overflow: hidden;
        margin-bottom: 8px;
    }
    
    .workload-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transition: width 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 10px;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .workload-fill.overloaded {
        background: linear-gradient(90deg, #f5576c 0%, #f093fb 100%);
    }
    
    .team-member-row {
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .team-member-row:last-child {
        border-bottom: none;
    }
    
    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 12px;
    }
    
    .task-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .task-row {
        border-bottom: 1px solid #f0f0f0;
        padding: 16px;
        transition: 
        background 0.2s;
    }
    
    .task-row:hover {
        background: #f8f9fa;
    }
    
    .action-btn {
        padding: 4px 8px;
        border: none;
        background: transparent;
        color: #666;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s;
        font-size: 0.9rem;
    }
    
    .action-btn:hover {
        background: #f0f0f0;
        color: #333;
    }
    
    .badge-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-todo { background: #e3f2fd; color: #1976d2; }
    .badge-progress { background: #fff3e0; color: #f57c00; }
    .badge-done { background: #e8f5e9; color: #388e3c; }
    .badge-review { background: #f3e5f5; color: #7b1fa2; }
    
    .create-task-modal .modal-content {
        border-radius: 16px;
        border: none;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px 16px 0 0;
    }
    
    .approval-badge {
        background: #fff3cd;
        color: #856404;
        padding: 2px 8px;
        border-radius: 8px;
        font-size: 0.7rem;
        margin-left: 8px;
    }
    
    .alert-card {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>
</head>
<body>


<?php view('partials/nav.php') ?>

<div class="main-content" id="mainContent">
    <nav class="navbar bg-light px-4">
        <div class="container-fluid">
            <div class="navbar-brand d-flex align-items-center">
                <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
                    <i class="fas fa-bars"></i>
                </button>
                <img src="\..\TeamProjectManage/public/images/logo.png" alt="Make-It-All logo" width="40" class="me-2" onerror="this.style.display='none'">
                <div>
                    <h5 class="mb-0">Team Leader Dashboard</h5>
                    <small class="text-muted">Welcome back, Sarah Johnson</small>
                </div>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    <i class="fas fa-plus me-2"></i>Create Task
                </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-4">
        
        
        <div class="alert-card">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.5rem; color: #856404;"></i>
                <div>
                    <strong>3 tasks pending your review</strong>
                    <p class="mb-0 small">High-risk tasks marked complete by team members require your approval</p>
                </div>
                <button class="btn btn-warning ms-auto">Review Now</button>
            </div>
        </div>

       
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon stat-primary">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-label">Active Tasks</div>
                    <div class="stat-number">24</div>
                    <small class="text-muted">Across 3 projects</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon stat-danger">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="stat-label">Overdue</div>
                    <div class="stat-number text-danger">3</div>
                    <small class="text-muted">Requires attention</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon stat-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-label">Completion Rate</div>
                    <div class="stat-number text-success">68%</div>
                    <small class="text-muted">This month</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon stat-warning">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-label">Team Members</div>
                    <div class="stat-number">8</div>
                    <small class="text-muted">Active this week</small>
                </div>
            </div>
        </div>

        
        <div class="chart-container">
            <div class="section-header">
                <h5 class="section-title">Project Progress Overview</h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary active">This Week</button>
                    <button class="btn btn-outline-secondary">This Month</button>
                    <button class="btn btn-outline-secondary">All Time</button>
                </div>
            </div>
            <canvas id="projectProgressChart" height="80"></canvas>
        </div>

       
        <div class="chart-container">
            <div class="section-header">
                <h5 class="section-title">Team Workload Distribution</h5>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-balance-scale me-1"></i>Balance Workload
                </button>
            </div>
            
            <div id="workloadContainer">
                
            </div>
        </div>

        
        <div class="task-table">
            <div class="section-header p-3 border-bottom">
                <h5 class="section-title">Team Tasks</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="filterProject" style="width: 150px;">
                        <option value="all">All Projects</option>
                        <option value="proj1">Documentation</option>
                        <option value="proj2">Bug Fixes</option>
                        <option value="proj3">UI Design</option>
                    </select>
                    <select class="form-select form-select-sm" id="filterStatus" style="width: 150px;">
                        <option value="all">All Status</option>
                        <option value="todo">To Do</option>
                        <option value="progress">In Progress</option>
                        <option value="review">Pending Review</option>
                        <option value="done">Done</option>
                    </select>
                    <input type="text" class="form-control form-control-sm" placeholder="Search tasks..." style="width: 200px;">
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Task</th>
                            <th>Assigned To</th>
                            <th>Project</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="taskTableBody">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal fade create-task-modal" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Create New Task
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createTaskForm">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Task Title *</label>
                            <input type="text" class="form-control" required placeholder="Enter task title">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Priority *</label>
                            <select class="form-select" required>
                                <option value="">Select Priority</option>
                                <option value="critical">Critical</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Describe the task..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Assign To *</label>
                            <select class="form-select" required>
                                <option value="">Select Team Member</option>
                                <option value="john">John Smith</option>
                                <option value="emma">Emma Davis</option>
                                <option value="mike">Mike Chen</option>
                                <option value="sarah">Sarah Wilson</option>
                                <option value="david">David Lee</option>
                                <option value="lisa">Lisa Anderson</option>
                                <option value="james">James Brown</option>
                                <option value="maria">Maria Garcia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Project *</label>
                            <select class="form-select" required>
                                <option value="">Select Project</option>
                                <option value="proj1">Documentation</option>
                                <option value="proj2">Bug Fixes</option>
                                <option value="proj3">UI Design</option>
                                <option value="proj4">Development</option>
                                <option value="proj5">DevOps</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Due Date *</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Initial Status</label>
                            <select class="form-select">
                                <option value="todo" selected>To Do</option>
                                <option value="progress">In Progress</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="requiresApproval">
                                <label class="form-check-label" for="requiresApproval">
                                    <strong>Requires manager approval</strong>
                                    <small class="d-block text-muted">Check this for high-risk tasks that need sign-off before completion</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createTask()">
                    <i class="fas fa-check me-2"></i>Create Task
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Task
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Editing task: <strong id="editTaskTitle"></strong>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php requireModule(['nav']) ?>
<script>

const teamMembers = [
    { name: 'John Smith', tasks: 5, maxTasks: 8 },
    { name: 'Emma Davis', tasks: 7, maxTasks: 8 },
    { name: 'Mike Chen', tasks: 3, maxTasks: 8 },
    { name: 'Sarah Wilson', tasks: 6, maxTasks: 8 },
    { name: 'David Lee', tasks: 4, maxTasks: 8 },
    { name: 'Lisa Anderson', tasks: 8, maxTasks: 8 },
    { name: 'James Brown', tasks: 2, maxTasks: 8 },
    { name: 'Maria Garcia', tasks: 5, maxTasks: 8 }
];


const tasks = [
    {
        id: 1,
        title: 'Update API documentation',
        assignee: 'John Smith',
        project: 'Documentation',
        priority: 'high',
        status: 'progress',
        dueDate: '2025-10-30',
        requiresApproval: false
    },
    {
        id: 2,
        title: 'Fix authentication bug',
        assignee: 'Emma Davis',
        project: 'Bug Fixes',
        priority: 'critical',
        status: 'review',
        dueDate: '2025-10-28',
        requiresApproval: true
    },
    {
        id: 3,
        title: 'Design dashboard mockup',
        assignee: 'Mike Chen',
        project: 'UI Design',
        priority: 'medium',
        status: 'progress',
        dueDate: '2025-11-05',
        requiresApproval: false
    },
    {
        id: 4,
        title: 'Database optimization',
        assignee: 'David Lee',
        project: 'Development',
        priority: 'high',
        status: 'todo',
        dueDate: '2025-10-27',
        requiresApproval: true
    },
    {
        id: 5,
        title: 'Setup CI/CD pipeline',
        assignee: 'Lisa Anderson',
        project: 'DevOps',
        priority: 'medium',
        status: 'progress',
        dueDate: '2025-11-02',
        requiresApproval: false
    },
    {
        id: 6,
        title: 'Write unit tests',
        assignee: 'James Brown',
        project: 'Development',
        priority: 'low',
        status: 'todo',
        dueDate: '2025-11-10',
        requiresApproval: false
    },
    {
        id: 7,
        title: 'Security audit review',
        assignee: 'Sarah Wilson',
        project: 'Bug Fixes',
        priority: 'critical',
        status: 'review',
        dueDate: '2025-10-26',
        requiresApproval: true
    },
    {
        id: 8,
        title: 'Update user guide',
        assignee: 'Maria Garcia',
        project: 'Documentation',
        priority: 'medium',
        status: 'done',
        dueDate: '2025-10-25',
        requiresApproval: false
    }
];


function renderWorkload() {
    const container = document.getElementById('workloadContainer');
    container.innerHTML = '';
    
    teamMembers.forEach(member => {
        const percentage = (member.tasks / member.maxTasks) * 100;
        const isOverloaded = percentage > 80;
        
        const memberRow = document.createElement('div');
        memberRow.className = 'team-member-row';
        memberRow.innerHTML = `
            <div class="d-flex align-items-center mb-2">
                <div class="member-avatar">${member.name.split(' ').map(n => n[0]).join('')}</div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong>${member.name}</strong>
                        <span class="text-muted small">${member.tasks} / ${member.maxTasks} tasks</span>
                    </div>
                    <div class="workload-bar">
                        <div class="workload-fill ${isOverloaded ? 'overloaded' : ''}" style="width: ${percentage}%">
                            ${Math.round(percentage)}%
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-primary ms-3" onclick="viewMemberTasks('${member.name}')">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        `;
        container.appendChild(memberRow);
    });
}


function renderTasks() {
    const tbody = document.getElementById('taskTableBody');
    tbody.innerHTML = '';
    
    tasks.forEach(task => {
        const isOverdue = new Date(task.dueDate) < new Date() && task.status !== 'done';
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <div class="d-flex align-items-center">
                    <strong>${task.title}</strong>
                    ${task.requiresApproval ? '<span class="approval-badge">Approval Required</span>' : ''}
                </div>
            </td>
            <td>${task.assignee}</td>
            <td><span class="badge bg-secondary">${task.project}</span></td>
            <td><span class="priority-badge priority-${task.priority}">${task.priority}</span></td>
            <td><span class="badge-status badge-${task.status}">${formatStatus(task.status)}</span></td>
            <td class="${isOverdue ? 'text-danger fw-bold' : ''}">${formatDate(task.dueDate)}</td>
            <td>
                <button class="action-btn" onclick="editTask(${task.id})" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                ${task.status === 'review' ? `
                    <button class="action-btn text-success" onclick="approveTask(${task.id})" title="Approve">
                        <i class="fas fa-check"></i>
                    </button>
                ` : ''}
                ${task.status === 'done' ? `
                    <button class="action-btn text-warning" onclick="reopenTask(${task.id})" title="Re-open">
                        <i class="fas fa-undo"></i>
                    </button>
                ` : ''}
                <button class="action-btn text-danger" onclick="deleteTask(${task.id})" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}


function formatStatus(status) {
    const statusMap = {
        'todo': 'To Do',
        'progress': 'In Progress',
        'review': 'Pending Review',
        'done': 'Done'
    };
    return statusMap[status] || status;
}


function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}


function createTask() {
    alert('Task creation functionality - would save to database');
    bootstrap.Modal.getInstance(document.getElementById('createTaskModal')).hide();
}

function editTask(taskId) {
    const task = tasks.find(t => t.id === taskId);
    document.getElementById('editTaskTitle').textContent = task.title;
    new bootstrap.Modal(document.getElementById('editTaskModal')).show();
}

function approveTask(taskId) {
    if (confirm('Approve this task as complete?')) {
        alert('Task approved - would update database');
        
        const task = tasks.find(t => t.id === taskId);
        if (task) task.status = 'done';
        renderTasks();
    }
}

function reopenTask(taskId) {
    if (confirm('Re-open this completed task?')) {
        alert('Task re-opened - would update database');
        const task = tasks.find(t => t.id === taskId);
        if (task) task.status = 'progress';
        renderTasks();
    }
}

function deleteTask(taskId) {
    if (confirm('Are you sure you want to delete this task?')) {
        alert('Task deleted - would remove from database');
        const index = tasks.findIndex(t => t.id === taskId);
        if (index > -1) tasks.splice(index, 1);
        renderTasks();
    }
}

function viewMemberTasks(memberName) {
    alert(`View all tasks for ${memberName} - would filter task table`);
}


const ctx = document.getElementById('projectProgressChart').getContext('2d');
const projectProgressChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Documentation', 'Bug Fixes', 'UI Design', 'Development', 'DevOps'],
        datasets: [
            {
                label: 'Completed',
                data: [12, 8, 15, 20, 10],
                backgroundColor: 'rgba(76, 175, 80, 0.8)',
            },
            {
                label: 'In Progress',
                data: [5, 7, 3, 8, 4],
                backgroundColor: 'rgba(255, 152, 0, 0.8)',
            },
            {
                label: 'To Do',
                data: [3, 2, 5, 4, 2],
                backgroundColor: 'rgba(33, 150, 243, 0.8)',
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: false
            }
        },
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true,
                beginAtZero: true,
                ticks: {
                    stepSize: 5
                }
            }
        }
    }
});


renderWorkload();
renderTasks();


document.getElementById('filterProject').addEventListener('change', function() {
    alert('Filter by project: ' + this.value);
    
});

document.getElementById('filterStatus').addEventListener('change', function() {
    alert('Filter by status: ' + this.value);
    
});
</script>

</body>
</html>