<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Settings - Make-It-All</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">

<style>
    .settings-container {
        display: flex;
        min-height: calc(100vh - 56px);
    }
    
    .settings-sidebar {
        width: 280px;
        background: white;
        border-right: 1px solid #e0e0e0;
        padding: 20px 0;
    }
    
    .settings-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .settings-menu li {
        margin-bottom: 4px;
    }
    
    .settings-menu a {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        color: #333;
        text-decoration: none;
        transition: all 0.2s;
        border-left: 3px solid transparent;
    }
    
    .settings-menu a:hover {
        background-color: #f5f5f5;
        color: #667eea;
    }
    
    .settings-menu a.active {
        background-color: #f0f4ff;
        color: #667eea;
        border-left-color: #667eea;
        font-weight: 500;
    }
    
    .settings-menu i {
        width: 24px;
        margin-right: 12px;
        font-size: 18px;
    }
    
    .settings-content {
        flex: 1;
        padding: 40px;
        background-color: #f5f5f5;
    }
    
    .settings-section {
        display: none;
    }
    
    .settings-section.active {
        display: block;
    }
    
    .settings-card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .settings-card h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #333;
    }
    
    .form-label {
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
    }
    
    .form-switch .form-check-input {
        width: 48px;
        height: 24px;
        cursor: pointer;
    }
    
    .form-switch .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 36px;
        font-weight: 600;
        margin-bottom: 16px;
    }
    
    .danger-zone {
        border: 1px solid #dc3545;
        border-radius: 8px;
        padding: 20px;
        background-color: #fff5f5;
    }
    
    .danger-zone h4 {
        color: #dc3545;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
    }
    
    @media (max-width: 768px) {
        .settings-container {
            flex-direction: column;
        }
        
        .settings-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .settings-content {
            padding: 20px;
        }
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
                <span class="fw-semibold">Settings</span>
            </div>
        </div>
    </nav>

    <div class="settings-container">
       
        <div class="settings-sidebar">
            <ul class="settings-menu">
                <li>
                    <a href="#" class="settings-menu-item active" data-section="profile">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="settings-menu-item" data-section="account">
                        <i class="fas fa-user-circle"></i>
                        <span>Account</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="settings-menu-item" data-section="security">
                        <i class="fas fa-shield-alt"></i>
                        <span>Security</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="settings-menu-item" data-section="notifications">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="settings-menu-item" data-section="privacy">
                        <i class="fas fa-lock"></i>
                        <span>Privacy</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="settings-menu-item" data-section="appearance">
                        <i class="fas fa-palette"></i>
                        <span>Appearance</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="settings-menu-item" data-section="preferences">
                        <i class="fas fa-sliders-h"></i>
                        <span>Preferences</span>
                    </a>
                </li>
            </ul>
        </div>

        
        <div class="settings-content">
            
        
            <div class="settings-section active" id="profile">
                <h2 class="mb-4">Profile Settings</h2>
                
                <div class="settings-card">
                    <h3>Personal Information</h3>
                    <div class="d-flex align-items-center mb-4">
                        <div class="profile-avatar">JD</div>
                        <button class="btn btn-outline-primary ms-3">Change Avatar</button>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="John">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" value="Doe">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control" value="Project Manager">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Department</label>
                            <select class="form-select">
                                <option>IT</option>
                                <option>Development</option>
                                <option>Management</option>
                                <option>Design</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" rows="3" placeholder="Tell us about yourself..."></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Changes</button>
                    </div>
                </div>
            </div>

       
            <div class="settings-section" id="account">
                <h2 class="mb-4">Account Settings</h2>
                
                <div class="settings-card">
                    <h3>Email & Contact</h3>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="john.doe@make-it-all.co.uk" readonly>
                            <small class="text-muted">Your email address cannot be changed as it's your username</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" value="+44 123 456 7890">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-save">Update Contact Info</button>
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Language & Region</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Language</label>
                            <select class="form-select">
                                <option>English (UK)</option>
                                <option>English (US)</option>
                                <option>French</option>
                                <option>German</option>
                                <option>Spanish</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Timezone</label>
                            <select class="form-select">
                                <option>GMT (London)</option>
                                <option>EST (New York)</option>
                                <option>PST (Los Angeles)</option>
                                <option>CET (Paris)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-save">Save Preferences</button>
                    </div>
                </div>
            </div>

          
            <div class="settings-section" id="security">
                <h2 class="mb-4">Security Settings</h2>
                
                <div class="settings-card">
                    <h3>Password</h3>
                    <p class="text-muted mb-3">Ensure your account is using a strong password to stay secure</p>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-save">Change Password</button>
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Two-Factor Authentication</h3>
                    <p class="text-muted mb-3">Add an extra layer of security to your account</p>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                        <label class="form-check-label" for="twoFactorAuth">
                            Enable Two-Factor Authentication
                        </label>
                    </div>
                    <button class="btn btn-outline-primary">Configure 2FA</button>
                </div>

                <div class="settings-card">
                    <h3>Active Sessions</h3>
                    <p class="text-muted mb-3">Manage your active sessions across devices</p>
                    <div class="list-group mb-3">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-laptop me-2 text-primary"></i>
                                <strong>Windows PC</strong> - Loughborough, UK
                                <br>
                                <small class="text-muted">Current session • Last active: now</small>
                            </div>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-mobile-alt me-2 text-primary"></i>
                                <strong>iPhone</strong> - Loughborough, UK
                                <br>
                                <small class="text-muted">Last active: 2 hours ago</small>
                            </div>
                            <button class="btn btn-sm btn-outline-danger">Revoke</button>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger">Sign Out All Other Sessions</button>
                </div>
            </div>

         
            <div class="settings-section" id="notifications">
                <h2 class="mb-4">Notification Settings</h2>
                
                <div class="settings-card">
                    <h3>Email Notifications</h3>
                    <p class="text-muted mb-3">Choose what emails you'd like to receive</p>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailTaskAssigned" checked>
                        <label class="form-check-label" for="emailTaskAssigned">
                            <strong>Task Assignments</strong>
                            <br>
                            <small class="text-muted">When a task is assigned to you</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailTaskUpdated" checked>
                        <label class="form-check-label" for="emailTaskUpdated">
                            <strong>Task Updates</strong>
                            <br>
                            <small class="text-muted">When tasks you're involved in are updated</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailDeadlines" checked>
                        <label class="form-check-label" for="emailDeadlines">
                            <strong>Deadline Reminders</strong>
                            <br>
                            <small class="text-muted">Notifications about upcoming deadlines</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailComments">
                        <label class="form-check-label" for="emailComments">
                            <strong>Comments & Mentions</strong>
                            <br>
                            <small class="text-muted">When someone mentions you or comments on your posts</small>
                        </label>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Preferences</button>
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Push Notifications</h3>
                    <p class="text-muted mb-3">Manage browser and mobile push notifications</p>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="pushEnabled" checked>
                        <label class="form-check-label" for="pushEnabled">
                            <strong>Enable Push Notifications</strong>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="pushMessages" checked>
                        <label class="form-check-label" for="pushMessages">
                            <strong>Chat Messages</strong>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="pushProjects" checked>
                        <label class="form-check-label" for="pushProjects">
                            <strong>Project Updates</strong>
                        </label>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Preferences</button>
                    </div>
                </div>
            </div>

          
            <div class="settings-section" id="privacy">
                <h2 class="mb-4">Privacy Settings</h2>
                
                <div class="settings-card">
                    <h3>Profile Visibility</h3>
                    <p class="text-muted mb-3">Control who can see your profile information</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Who can see your profile?</label>
                        <select class="form-select">
                            <option selected>Everyone in the company</option>
                            <option>Only my team</option>
                            <option>Only managers</option>
                            <option>Private</option>
                        </select>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="showEmail" checked>
                        <label class="form-check-label" for="showEmail">
                            Show email address on profile
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="showPhone">
                        <label class="form-check-label" for="showPhone">
                            Show phone number on profile
                        </label>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Settings</button>
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Activity Tracking</h3>
                    <p class="text-muted mb-3">Control how your activity is tracked</p>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="trackActivity" checked>
                        <label class="form-check-label" for="trackActivity">
                            <strong>Enable Activity Tracking</strong>
                            <br>
                            <small class="text-muted">Allow managers to view your task activity and productivity metrics</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="showOnlineStatus" checked>
                        <label class="form-check-label" for="showOnlineStatus">
                            <strong>Show Online Status</strong>
                            <br>
                            <small class="text-muted">Let others see when you're online</small>
                        </label>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Settings</button>
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Data & Privacy</h3>
                    <p class="text-muted mb-3">Manage your data and privacy</p>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">Download My Data</button>
                        <button class="btn btn-outline-secondary">View Privacy Policy</button>
                    </div>
                </div>
            </div>

            
            <div class="settings-section" id="appearance">
                <h2 class="mb-4">Appearance Settings</h2>
                
                <div class="settings-card">
                    <h3>Theme</h3>
                    <p class="text-muted mb-3">Customize the look and feel of your workspace</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Theme Mode</label>
                        <select class="form-select">
                            <option selected>Light</option>
                            <option>Dark</option>
                            <option>Auto (System)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Accent Color</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary" style="background-color: #667eea; width: 50px; height: 50px;"></button>
                            <button class="btn btn-outline-secondary" style="background-color: #2196f3; width: 50px; height: 50px;"></button>
                            <button class="btn btn-outline-secondary" style="background-color: #4caf50; width: 50px; height: 50px;"></button>
                            <button class="btn btn-outline-secondary" style="background-color: #ff9800; width: 50px; height: 50px;"></button>
                            <button class="btn btn-outline-secondary" style="background-color: #e91e63; width: 50px; height: 50px;"></button>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Apply Theme</button>
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Display Options</h3>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="compactView">
                        <label class="form-check-label" for="compactView">
                            <strong>Compact View</strong>
                            <br>
                            <small class="text-muted">Show more content on screen</small>
                        </label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="animations" checked>
                        <label class="form-check-label" for="animations">
                            <strong>Enable Animations</strong>
                            <br>
                            <small class="text-muted">Smooth transitions and effects</small>
                        </label>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Preferences</button>
                    </div>
                </div>
            </div>

          
            <div class="settings-section" id="preferences">
                <h2 class="mb-4">General Preferences</h2>
                
                <div class="settings-card">
                    <h3>Default Views</h3>
                    <p class="text-muted mb-3">Set your preferred default views</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Task View</label>
                        <select class="form-select">
                            <option selected>Kanban Board</option>
                            <option>List View</option>
                            <option>Calendar View</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Default Priority Filter</label>
                        <select class="form-select">
                            <option selected>All Priorities</option>
                            <option>Critical Only</option>
                            <option>High & Critical</option>
                            <option>Medium & Above</option>
                        </select>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Preferences</button>
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Calendar Settings</h3>
                    
                    <div class="mb-3">
                        <label class="form-label">Week Starts On</label>
                        <select class="form-select">
                            <option>Sunday</option>
                            <option selected>Monday</option>
                            <option>Saturday</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Working Hours</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="time" class="form-control" value="09:00">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" value="17:00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-save">Save Settings</button>
                    </div>
                </div>

                <div class="settings-card danger-zone">
                    <h4><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h4>
                    <p class="mb-3">These actions are irreversible. Please proceed with caution.</p>
                    <button class="btn btn-danger">Deactivate Account</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php requireModule(['nav']) ?>
<script>

const settingsMenuItems = document.querySelectorAll('.settings-menu-item');
const settingsSections = document.querySelectorAll('.settings-section');

settingsMenuItems.forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        
        
        const targetSection = item.getAttribute('data-section');
        
        
        settingsMenuItems.forEach(menuItem => {
            menuItem.classList.remove('active');
        });
        
        
        item.classList.add('active');
        
        
        settingsSections.forEach(section => {
            section.classList.remove('active');
        });
        
        
        document.getElementById(targetSection).classList.add('active');
        
        
        document.querySelector('.settings-content').scrollTop = 0;
    });
});


document.querySelectorAll('.form-switch .form-check-input').forEach(toggle => {
    toggle.addEventListener('change', () => {
        
        const label = toggle.nextElementSibling;
        const originalText = label.innerHTML;
        
        
        toggle.parentElement.style.opacity = '0.6';
        setTimeout(() => {
            toggle.parentElement.style.opacity = '1';
        }, 200);
    });
});


document.querySelectorAll('.btn-save').forEach(button => {
    button.addEventListener('click', () => {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check me-2"></i>Saved!';
        button.disabled = true;
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    });
});
</script>
</body>
</html>