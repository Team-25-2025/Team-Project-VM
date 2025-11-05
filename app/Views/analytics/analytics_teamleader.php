<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manager Analytics - Make-It-All</title>
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

        .main-content {
            transition: margin-left 0.3s ease;
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
        .icon-danger { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
        .icon-warning { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }

        .chart-container {
            height: 250px;
            margin: 20px 0;
            position: relative;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            margin: 20px 0;
        }

        .team-member-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .team-member-card.overloaded {
            border-left: 4px solid #dc3545;
            background: #fff5f5;
        }

        .team-member-card.optimal {
            border-left: 4px solid #198754;
            background: #f8fff9;
        }

        .team-member-card.available {
            border-left: 4px solid #0dcaf0;
            background: #f0fdff;
        }

        .member-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background: #198754; }
        .badge-danger { background: #dc3545; }
        .badge-warning { background: #ffc107; }

        @media (max-width: 768px) {
            .analytics-container {
                padding: 20px;
            }
            .metric-grid {
                grid-template-columns: 1fr;
            }
            .team-grid {
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
                <span class="fw-bold">Team Analytics Dashboard</span>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-4">
        <div class="analytics-container">
            <div class="board-header mb-4">
                <h1><i class="fas fa-chart-pie me-2"></i>Team Performance Overview</h1>
                <p class="text-muted">Monitor team productivity and workload distribution</p>
            </div>

            <!-- Team Performance Metrics -->
            <div class="metric-grid">
                <div class="metric-card">
                    <div class="metric-card-header">
                        <div class="metric-icon icon-primary">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h4>Team Productivity</h4>
                            <h3 style="color: #667eea; margin: 0;">74%</h3>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="teamBarChart"></canvas>
                    </div>
                    <p><strong>Trend:</strong> -3% from last week</p>
                </div>

                <div class="metric-card">
                    <div class="metric-card-header">
                        <div class="metric-icon icon-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h4>Overdue Tasks</h4>
                            <h3 style="color: #dc3545; margin: 0;">5</h3>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="overdueChart"></canvas>
                    </div>
                    <p><strong>Critical:</strong> 2 tasks</p>
                </div>

                <div class="metric-card">
                    <div class="metric-card-header">
                        <div class="metric-icon icon-warning">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div>
                            <h4>Workload Balance</h4>
                            <h3 style="color: #ffc107; margin: 0;">Poor</h3>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="workloadChart"></canvas>
                    </div>
                    <p><strong>Action:</strong> Redistribute tasks</p>
                </div>
            </div>

            <!-- Team Member Analysis -->
            <h3><i class="fas fa-users me-2"></i>Team Member Status</h3>
            <div class="team-grid">
                <div class="team-member-card optimal">
                    <div class="member-header">
                        <h4 style="margin: 0;">Alice</h4>
                        <span class="badge badge-success">Optimal</span>
                    </div>
                    <p><strong>Role:</strong> Admin Manager</p>
                    <p><strong>Tasks:</strong> 4 active</p>
                    <p><strong>Productivity:</strong> 85%</p>
                </div>

                <div class="team-member-card optimal">
                    <div class="member-header">
                        <h4 style="margin: 0;">Bert</h4>
                        <span class="badge badge-success">Optimal</span>
                    </div>
                    <p><strong>Role:</strong> Tech Specialist</p>
                    <p><strong>Tasks:</strong> 3 active</p>
                    <p><strong>Productivity:</strong> 92%</p>
                </div>

                <div class="team-member-card overloaded">
                    <div class="member-header">
                        <h4 style="margin: 0;">Clara</h4>
                        <span class="badge badge-danger">Overloaded</span>
                    </div>
                    <p><strong>Role:</strong> Tech Specialist</p>
                    <p><strong>Tasks:</strong> 6 active ⚠️</p>
                    <p><strong>Productivity:</strong> 65%</p>
                </div>

                <div class="team-member-card available">
                    <div class="member-header">
                        <h4 style="margin: 0;">Emma</h4>
                        <span class="badge badge-warning">Available</span>
                    </div>
                    <p><strong>Role:</strong> Project Manager</p>
                    <p><strong>Tasks:</strong> 5 active</p>
                    <p><strong>Productivity:</strong> 78%</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php requireModule(['nav']) ?>
<script>
// Charts
const teamBarChart = new Chart(document.getElementById('teamBarChart'), {
    type: 'bar',
    data: {
        labels: ['Alice', 'Bert', 'Clara', 'Emma', 'Team Avg'],
        datasets: [{
            label: 'Productivity (%)',
            data: [85, 92, 65, 78, 74],
            backgroundColor: ['#198754', '#198754', '#dc3545', '#198754', '#667eea']
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

const overdueChart = new Chart(document.getElementById('overdueChart'), {
    type: 'doughnut',
    data: {
        labels: ['Critical', 'High Priority', 'Normal'],
        datasets: [{
            data: [2, 3, 8],
            backgroundColor: ['#dc3545', '#ffc107', '#0dcaf0']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

const workloadChart = new Chart(document.getElementById('workloadChart'), {
    type: 'bar',
    data: {
        labels: ['Alice', 'Bert', 'Clara', 'Emma'],
        datasets: [{
            label: 'Current Tasks',
            data: [4, 3, 6, 5],
            backgroundColor: ['#198754', '#198754', '#dc3545', '#198754']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>