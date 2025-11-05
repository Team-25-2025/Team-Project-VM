
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h5 class="mb-1">Make-It-All</h5>
        <small class="text-white">Productivity System</small>
    </div>
    <ul class="sidebar-menu">

        <?php if ($_SESSION['user']['permission'] == 'manager' || $_SESSION['user']['permission'] == 'teamleader'): ?>
            <li>
                <a href="/TeamProjectManage/public/index.php/dashboard">
                    <i class="fas fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
         <?php else: ?>
            <li>
                <a href="/TeamProjectManage/public/index.php/todo">
                    <i class="fas fa-tasks"></i>
                    <span>Tasks</span>
                </a>
            </li>
        <?php endif; ?>

        <li>
            <a href="/TeamProjectManage/public/index.php/mylist">
                <i class="fas fa-tasks"></i>
                <span>My List</span>
            </a>
        </li>

        
        <li>
            <a href="/TeamProjectManage/public/index.php/calendar">
                <i class="fas fa-home"></i>
                <span>Calendar</span>
            </a>
        </li>
        
        <li>
            <a href="/TeamProjectManage/public/index.php/chat">
                <i class="fas fa-users"></i>
                <span>Chat</span>
            </a>
        </li>
        <li>
            <a href="/TeamProjectManage/public/index.php/board">
                <i class="fas fa-chart-line"></i>
                <span>Team Board</span>
            </a>
        </li>
        <?php if ($_SESSION['user']['permission'] == 'manager'): ?>
            <li>
                <a href="/TeamProjectManage/public/index.php/board">
                    <i class="fas fa-chart-line"></i>
                    <span>Projects</span>
                </a>
            </li>
        <?php endif; ?>
        <li>
            <a href="/TeamProjectManage/public/index.php/notification">
                <i class="fas fa-project-diagram"></i>
                <span>Notifications </span>
            </a>
        </li>
        <li>
            <a href="/TeamProjectManage/public/index.php/knowledge/categories">
                <i class="fas fa-book"></i>
                <span>Knowledge</span>
            </a>
        </li>
        <li>
            <a href="/TeamProjectManage/public/index.php/discussion">
                <i class="fas fa-comments"></i>
                <span>Discussions</span>
            </a>
        </li>

        <?php if ($_SESSION['user']['permission'] == 'teamleader' || $_SESSION['user']['permission'] == 'employee'): ?>
        <li>
            <a href="/TeamProjectManage/public/index.php/analytics">
                <i class="fas fa-chart-bar"></i>
                <span>Analytics</span> 
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a href="/TeamProjectManage/public/index.php/settings">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
        <li>
        <form action="/TeamProjectManage/public/" method="post" style="margin: 0; padding: 0;">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit"
            style="
                background: none;
                border: none;
                color: #64748b;
                font: inherit;
                cursor: pointer;
                display: flex;
                align-items: center;
                width: 100%;
                padding: 14px 20px;
                text-align: left;
                transition: all 0.2s;
            "
            onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.color='#667eea'; this.style.paddingLeft='25px';"
            onmouseout="this.style.backgroundColor='#ffffffff'; this.style.color='#64748b'; this.style.paddingLeft='20px';"
            >
            <i class="fas fa-sign-out-alt" style="width: 24px; margin-right: 12px;"></i>
            <span>Logout</span>
            </button>
        </form>
        </li>
    </ul>
</div>
