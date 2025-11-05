<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Analytics - Make-It-All</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #222;
            background-color: #f5f5f5;
            overflow-x: hidden;
        }

        .navbar {
            border-bottom: 1px solid #e0e0e0;
        }

        .analytics-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin: 24px 0;
        }

        .metric-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .metric-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transform: translateY(-2px);
            border-color: #667eea;
        }

        .metric-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            font-size: 1.25rem;
            color: white;
        }

        .icon-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .icon-success { background: linear-gradient(135deg, #198754 0%, #146c43 100%); }
        .icon-warning { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }

        .chart-container {
            height: 250px;
            margin: 20px 0;
            position: relative;
        }

        .task-list {
            margin: 24px 0;
        }

        .task-item {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .task-item.overdue {
            border-left: 4px solid #dc3545;
            background: #fff5f5;
        }

        .task-item.priority {
            border-left: 4px solid #ffc107;
            background: #fffbf0;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .task-title {
            font-weight: 600;
            color: #333;
            font-size: 1.05rem;
        }

        .task-meta {
            display: flex;
            gap: 12px;
            font-size: 0.9rem;
            color: #666;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-danger { background: #dc3545; }
        .badge-warning { background: #ffc107; }
        .badge-info { background: #0dcaf0; }

        .task-description {
            color: #555;
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .analytics-container {
                padding: 20px;
            }
            .metric-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<?php view('partials/nav.php') ?>

<div class="main-content" id="mainContent">
    <nav class="navbar bg-light px-4">
        <div class="container-fluid d-flex align-items-center">
            <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-brand mb-0">
                <span class="fw-bold">My Productivity Analytics</span>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-4">
        <div class="analytics-container">
            <div class="board-header mb-4">
                <h1><i class="fas fa-user-chart me-2"></i>My Productivity Dashboard</h1>
                <p class="text-muted">Welcome back! Here's your current performance overview.</p>
            </div>

            <!-- Urgent Tasks -->
            <div class="task-list">
                <h3><i class="fas fa-exclamation-circle me-2"></i>Action Required</h3>
                
                <div class="task-item overdue">
                    <div class="task-header">
                        <div class="task-title">Fix Database Connection Timeout</div>
                        <div class="task-meta">
                            <span class="badge badge-danger">OVERDUE</span>
                            <span><i class="fas fa-calendar-times me-1"></i>Due: 2 days ago</span>
                        </div>
                    </div>
                    <div class="task-description">
                        Production database experiencing connection timeouts during peak hours.
                    </div>
                </div>

                <div class="task-item priority">
                    <div class="task-header">
                        <div class="task-title">Update API Documentation</div>
                        <div class="task-meta">
                            <span class="badge badge-warning">HIGH PRIORITY</span>
                            <span><i class="fas fa-clock me-1"></i>Due: Today</span>
                        </div>
                    </div>
                    <div class="task-description">
                        Document the new authentication endpoints for the mobile app team.
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="metric-grid">
                <div class="metric-card">
                    <div class="metric-card-header">
                        <div class="metric-icon icon-primary">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div>
                            <h4>Productivity Score</h4>
                            <h3 style="color: #667eea; margin: 0;">78%</h3>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="employeeBarChart"></canvas>
                    </div>
                    <p><strong>Weekly Trend:</strong> +5% improvement</p>
                </div>

                <div class="metric-card">
                    <div class="metric-card-header">
                        <div class="metric-icon icon-warning">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div>
                            <h4>Task Overview</h4>
                            <h3 style="color: #ffc107; margin: 0;">8/12</h3>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="employeeTaskChart"></canvas>
                    </div>
                    <p><strong>Overdue:</strong> 1 task</p>
                </div>

                <div class="metric-card">
                    <div class="metric-card-header">
                        <div class="metric-icon icon-success">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4>Time Management</h4>
                            <h3 style="color: #198754; margin: 0;">65%</h3>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="employeeTimeChart"></canvas>
                    </div>
                    <p><strong>Focus Areas:</strong> Reduce meeting time</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php requireModule(['nav']) ?>
<script>
// Charts
const employeeBarChart = new Chart(document.getElementById('employeeBarChart'), {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        datasets: [{
            label: 'Daily Productivity',
            data: [72, 85, 78, 82, 75],
            backgroundColor: '#667eea'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});

const employeeTaskChart = new Chart(document.getElementById('employeeTaskChart'), {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'In Progress', 'Overdue', 'Pending'],
        datasets: [{
            data: [8, 2, 1, 1],
            backgroundColor: ['#198754', '#0dcaf0', '#dc3545', '#6c757d']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

const employeeTimeChart = new Chart(document.getElementById('employeeTimeChart'), {
    type: 'pie',
    data: {
        labels: ['Development', 'Meetings', 'Code Review', 'Documentation'],
        datasets: [{
            data: [45, 25, 15, 15],
            backgroundColor: ['#198754', '#dc3545', '#0dcaf0', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
</body>
</html>