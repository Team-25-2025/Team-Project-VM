<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Notifications - Make-It-All</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.view.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
<style>
    .notification-item {
        background: white;
        border-radius: 8px;
        border-left: 4px solid;
        padding: 16px;
        margin-bottom: 12px;
        transition: all 0.2s;
        display: flex;
        align-items: start;
        gap: 16px;
    }
    
    .notification-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(4px);
    }
    
    .notification-item.unread {
        background: #f8f9ff;
    }
    
    .notification-item.overdue {
        border-left-color: #dc3545;
    }
    
    .notification-item.deadline-soon {
        border-left-color: #ff9800;
    }
    
    .notification-item.new-task {
        border-left-color: #2196f3;
    }
    
    .notification-item.general {
        border-left-color: #4caf50;
    }
    
    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .notification-icon.overdue {
        background: #fee;
        color: #dc3545;
    }
    
    .notification-icon.deadline-soon {
        background: #fff3e0;
        color: #ff9800;
    }
    
    .notification-icon.new-task {
        background: #e3f2fd;
        color: #2196f3;
    }
    
    .notification-icon.general {
        background: #e8f5e9;
        color: #4caf50;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-title {
        font-weight: 600;
        margin-bottom: 4px;
        color: #333;
    }
    
    .notification-message {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    
    .notification-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.85rem;
        color: #999;
    }
    
    .notification-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }
    
    .notification-dot {
        width: 8px;
        height: 8px;
        background: #2196f3;
        border-radius: 50%;
        margin-right: 8px;
    }
    
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    
    .filter-tab {
        padding: 8px 16px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .filter-tab:hover {
        border-color: #2196f3;
        color: #2196f3;
    }
    
    .filter-tab.active {
        background: #2196f3;
        border-color: #2196f3;
        color: white;
    }
    
    .notification-badge {
        background: #dc3545;
        color: white;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 8px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.3;
    }
</style>
</head>
<body>

<?php view('partials/nav.php') ?>

<div class="main-content" id="mainContent">
    <nav class="navbar bg-light px-4">
        <div class="container-fluid">
            <div class="navbar-brand">
                <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
                    <i class="fas fa-bars"></i>
                </button>
                <img src="\..\TeamProjectManage/public/images/logo.png" alt="Make-It-All logo" width="40" class="me-2">
            </div>
        </div>
    </nav>

    <div class="container-fluid p-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="mb-0">
                            Notifications
                            <span class="notification-badge" id="unreadCount">5</span>
                        </h1>
                    </div>
                    <button class="btn btn-outline-primary" id="markAllRead">
                        <i class="fas fa-check-double me-2"></i>Mark All as Read
                    </button>
                </div>
                
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">
                        <i class="fas fa-inbox me-2"></i>All
                    </button>
                    <button class="filter-tab" data-filter="overdue">
                        <i class="fas fa-exclamation-circle me-2"></i>Overdue
                    </button>
                    <button class="filter-tab" data-filter="deadline-soon">
                        <i class="fas fa-clock me-2"></i>Deadline Soon
                    </button>
                    <button class="filter-tab" data-filter="new-task">
                        <i class="fas fa-plus-circle me-2"></i>New Tasks
                    </button>
                    <button class="filter-tab" data-filter="unread">
                        <i class="fas fa-envelope me-2"></i>Unread
                    </button>
                </div>
            </div>
        </div>
        
        <div id="notificationsContainer">
            <!-- Notifications will be rendered here -->
        </div>
        
        <div id="emptyState" class="empty-state" style="display: none;">
            <i class="fas fa-bell-slash"></i>
            <h4>No Notifications</h4>
            <p>You're all caught up! Check back later for updates.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php requireModule(['nav']) ?>
<script>

// Sample notification data
const notifications = [
    {
        id: 1,
        type: 'overdue',
        title: 'Task Overdue',
        message: 'Fix login bug was due on Oct 14, 2025. Please complete it as soon as possible.',
        taskTitle: 'Fix login bug',
        project: 'Bug Fixes',
        time: '2 hours ago',
        read: false
    },
    {
        id: 2,
        type: 'deadline-soon',
        title: 'Deadline Approaching',
        message: 'Update project documentation is due tomorrow (Oct 15, 2025).',
        taskTitle: 'Update project documentation',
        project: 'Documentation',
        time: '4 hours ago',
        read: false
    },
    {
        id: 3,
        type: 'new-task',
        title: 'New Task Assigned',
        message: 'Sarah Johnson assigned you a new task: Implement user authentication.',
        taskTitle: 'Implement user authentication',
        project: 'Development',
        assignedBy: 'Sarah Johnson',
        time: '5 hours ago',
        read: false
    },
    {
        id: 4,
        type: 'deadline-soon',
        title: 'Deadline Approaching',
        message: 'Code review for PR #234 is due in 2 days (Oct 16, 2025).',
        taskTitle: 'Code review for PR #234',
        project: 'Development',
        time: '8 hours ago',
        read: false
    },
    {
        id: 5,
        type: 'new-task',
        title: 'New Task Assigned',
        message: 'Mike Chen assigned you a new task: Create mobile wireframes.',
        taskTitle: 'Create mobile wireframes',
        project: 'UI Design',
        assignedBy: 'Mike Chen',
        time: '1 day ago',
        read: false
    },
    {
        id: 6,
        type: 'general',
        title: 'Task Completed',
        message: 'Your task "Deploy to staging" has been marked as complete.',
        taskTitle: 'Deploy to staging',
        project: 'DevOps',
        time: '2 days ago',
        read: true
    },
    {
        id: 7,
        type: 'deadline-soon',
        title: 'Deadline Approaching',
        message: 'Design new dashboard layout is due in 5 days (Oct 20, 2025).',
        taskTitle: 'Design new dashboard layout',
        project: 'UI Design',
        time: '3 days ago',
        read: true
    }
];

let currentFilter = 'all';

function getIconClass(type) {
    switch(type) {
        case 'overdue': return 'fa-exclamation-circle';
        case 'deadline-soon': return 'fa-clock';
        case 'new-task': return 'fa-plus-circle';
        case 'general': return 'fa-check-circle';
        default: return 'fa-bell';
    }
}

function createNotificationHTML(notification) {
    const unreadClass = notification.read ? '' : 'unread';
    const unreadDot = notification.read ? '' : '<span class="notification-dot"></span>';
    
    return `
        <div class="notification-item ${notification.type} ${unreadClass}" data-id="${notification.id}" data-type="${notification.type}" data-read="${notification.read}">
            <div class="notification-icon ${notification.type}">
                <i class="fas ${getIconClass(notification.type)}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">
                    ${unreadDot}${notification.title}
                </div>
                <div class="notification-message">${notification.message}</div>
                <div class="notification-meta">
                    <span><i class="far fa-clock me-1"></i>${notification.time}</span>
                    <span><i class="fas fa-folder me-1"></i>${notification.project}</span>
                    ${notification.assignedBy ? `<span><i class="far fa-user me-1"></i>By ${notification.assignedBy}</span>` : ''}
                </div>
            </div>
            <div class="notification-actions">
                ${!notification.read ? `<button class="btn btn-sm btn-outline-primary mark-read-btn" title="Mark as read"><i class="fas fa-check"></i></button>` : ''}
                <button class="btn btn-sm btn-outline-danger delete-btn" title="Delete"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    `;
}

function renderNotifications() {
    const container = document.getElementById('notificationsContainer');
    const emptyState = document.getElementById('emptyState');
    
    let filteredNotifications = notifications;
    
    if (currentFilter === 'unread') {
        filteredNotifications = notifications.filter(n => !n.read);
    } else if (currentFilter !== 'all') {
        filteredNotifications = notifications.filter(n => n.type === currentFilter);
    }
    
    if (filteredNotifications.length === 0) {
        container.style.display = 'none';
        emptyState.style.display = 'block';
    } else {
        container.style.display = 'block';
        emptyState.style.display = 'none';
        container.innerHTML = filteredNotifications.map(createNotificationHTML).join('');
    }
    
    updateUnreadCount();
    attachEventListeners();
}

function updateUnreadCount() {
    const unreadCount = notifications.filter(n => !n.read).length;
    document.getElementById('unreadCount').textContent = unreadCount;
    
    if (unreadCount === 0) {
        document.getElementById('unreadCount').style.display = 'none';
    } else {
        document.getElementById('unreadCount').style.display = 'inline-block';
    }
}

function attachEventListeners() {
    // Mark as read buttons
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const notificationItem = e.target.closest('.notification-item');
            const id = parseInt(notificationItem.dataset.id);
            const notification = notifications.find(n => n.id === id);
            if (notification) {
                notification.read = true;
                renderNotifications();
            }
        });
    });
    
  
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const notificationItem = e.target.closest('.notification-item');
            const id = parseInt(notificationItem.dataset.id);
            const index = notifications.findIndex(n => n.id === id);
            if (index > -1) {
                notifications.splice(index, 1);
                renderNotifications();
            }
        });
    });
    
  
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', () => {
            const id = parseInt(item.dataset.id);
            const notification = notifications.find(n => n.id === id);
            if (notification && !notification.read) {
                notification.read = true;
                renderNotifications();
            }
        });
    });
}


document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        currentFilter = tab.dataset.filter;
        renderNotifications();
    });
});


document.getElementById('markAllRead').addEventListener('click', () => {
    notifications.forEach(n => n.read = true);
    renderNotifications();
});


renderNotifications();
</script>
</body>
</html>