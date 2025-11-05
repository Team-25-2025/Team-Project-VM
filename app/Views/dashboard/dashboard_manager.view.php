
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Make-It-All Company</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .progress-bar {
            transition: width 0.3s ease;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.view.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
</head>
<?php view('partials/nav.php') ?>
<div class="main-content" id="mainContent">
  <body class="bg-gray-50">
    <div class="min-h-screen p-6">
       <div class="d-flex"> 
        <button class="sidebar-toggle-inline me-3 pb-20" id="sidebarToggleInline">
          <i class="fas fa-bars"></i>
        </button>
          <div class="mb-8">
              <h1 class="text-3xl font-bold text-gray-900 mb-2">Manager Dashboard</h1>
              <p class="text-gray-600">Monitor project progress and team workload</p>
          </div>
        </div>
        
        <div class="mb-6 flex gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Project</label>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Projects</option>
                    <option>Website Redesign</option>
                    <option>Mobile App Development</option>
                    <option>Database Migration</option>
                    <option>Security Audit</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Time Range</label>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Quarter</option>
                </select>
            </div>
        </div>

    
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Total Projects</h3>
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900">4</p>
                <p class="text-sm text-gray-500 mt-1">3 on track</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Task Completion</h3>
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900">54%</p>
                <p class="text-sm text-gray-500 mt-1">49 of 91 tasks</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Overdue Tasks</h3>
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-red-600">6</p>
                <p class="text-sm text-gray-500 mt-1">Require immediate attention</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Pending Approval</h3>
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900">6</p>
                <p class="text-sm text-gray-500 mt-1">Tasks awaiting review</p>
            </div>
        </div>

        <!-- Projects Overview -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Projects Overview</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Project 1 -->
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">Website Redesign</h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ On Track
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Alice Johnson
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Due: 11/15/2025
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        3 members
                                    </span>
                                </div>
                            </div>
                        </div>

                     
                        <div class="mb-3">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">Progress</span>
                                <span class="text-gray-600">75%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full progress-bar" style="width: 75%"></div>
                            </div>
                        </div>

                       
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div class="bg-gray-50 rounded p-2">
                                <p class="text-xs text-gray-600">Total Tasks</p>
                                <p class="text-lg font-bold text-gray-900">24</p>
                            </div>
                            <div class="bg-green-50 rounded p-2">
                                <p class="text-xs text-green-600">Completed</p>
                                <p class="text-lg font-bold text-green-700">18</p>
                            </div>
                            <div class="bg-red-50 rounded p-2">
                                <p class="text-xs text-red-600">Overdue</p>
                                <p class="text-lg font-bold text-red-700">2</p>
                            </div>
                            <div class="bg-orange-50 rounded p-2">
                                <p class="text-xs text-orange-600">Pending</p>
                                <p class="text-lg font-bold text-orange-700">1</p>
                            </div>
                        </div>

                     
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">Team Members:</p>
                            <div class="flex gap-2 flex-wrap">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Alice</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Bob</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Charlie</span>
                            </div>
                        </div>
                    </div>

               
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">Database Migration</h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ⚠ At Risk
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        George Wilson
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Due: 10/30/2025
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        2 members
                                    </span>
                                </div>
                            </div>
                        </div>

                       
                        <div class="mb-3">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">Progress</span>
                                <span class="text-gray-600">30%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full progress-bar" style="width: 30%"></div>
                            </div>
                        </div>

                    
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div class="bg-gray-50 rounded p-2">
                                <p class="text-xs text-gray-600">Total Tasks</p>
                                <p class="text-lg font-bold text-gray-900">15</p>
                            </div>
                            <div class="bg-green-50 rounded p-2">
                                <p class="text-xs text-green-600">Completed</p>
                                <p class="text-lg font-bold text-green-700">5</p>
                            </div>
                            <div class="bg-red-50 rounded p-2">
                                <p class="text-xs text-red-600">Overdue</p>
                                <p class="text-lg font-bold text-red-700">3</p>
                            </div>
                            <div class="bg-orange-50 rounded p-2">
                                <p class="text-xs text-orange-600">Pending</p>
                                <p class="text-lg font-bold text-orange-700">0</p>
                            </div>
                        </div>

                       
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">Team Members:</p>
                            <div class="flex gap-2 flex-wrap">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">George</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Hannah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Team Workload Distribution</h2>
                <p class="text-sm text-gray-600 mt-1">Current task count per team member</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                   
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-gray-900">George</h3>
                            <span class="px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                                High Load
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Current Tasks:</span>
                                <span class="font-bold text-gray-900">7</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Completed:</span>
                                <span class="font-medium text-green-600">4</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-red-600">Overdue:</span>
                                <span class="font-bold text-red-600">2</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-600 h-2 rounded-full" style="width: 87%"></div>
                            </div>
                        </div>
                    </div>

                
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-gray-900">Alice</h3>
                            <span class="px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                Moderate
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Current Tasks:</span>
                                <span class="font-bold text-gray-900">5</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Completed:</span>
                                <span class="font-medium text-green-600">12</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-red-600">Overdue:</span>
                                <span class="font-bold text-red-600">1</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: 62%"></div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-gray-900">Eve</h3>
                            <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                Available
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Current Tasks:</span>
                                <span class="font-bold text-gray-900">2</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Completed:</span>
                                <span class="font-medium text-green-600">5</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

   
        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-red-900">Action Required</h3>
                    <p class="text-sm text-red-700">
                        There are 6 overdue tasks across all projects. Please review and address these items.
                    </p>
                </div>
            </div>
        </div>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php requireModule(['nav']) ?>
<script>
</script>
</body>
</html>