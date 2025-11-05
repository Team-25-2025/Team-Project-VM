<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Make-It-All</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/chat/chat.view.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
</head>
<body>
    
    <?php view('partials/nav.php') ?>
   
    <div class="main-content" id="mainContent">
    <div class="chat-container">
        
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
                <i class="fas fa-bars"></i>
            </button>
                <h2>Messages</h2>
                <div class="chat-actions">
                    <button class="icon-btn" id="newChatBtn" title="New Chat">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="icon-btn" id="newGroupBtn" title="New Group">
                        <i class="fas fa-users"></i>
                    </button>
                    <button class="icon-btn" id="chatSettingsBtn" title="Chat Settings">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>

            
            <div class="chat-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search conversations..." id="chatSearchInput">
            </div>

            
            <div class="chat-list">
                
                <div class="chat-item active" data-chat="1">
                    <div class="chat-avatar">
                        <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                        <span class="online-status online"></span>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h4>John Smith</h4>
                            <span class="chat-time">2m ago</span>
                        </div>
                        <p class="chat-preview">Great! I'll review the code tomorrow morning.</p>
                        <span class="unread-count">2</span>
                    </div>
                </div>

                <div class="chat-item" data-chat="2">
                    <div class="chat-avatar">
                        <div class="group-avatar">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h4>Development Team</h4>
                            <span class="chat-time">1h ago</span>
                        </div>
                        <p class="chat-preview"><strong>Sarah:</strong> Meeting at 3 PM today</p>
                        <span class="unread-count">5</span>
                    </div>
                </div>

                <div class="chat-item" data-chat="3">
                    <div class="chat-avatar">
                        <img src="https://i.pravatar.cc/150?img=5" alt="Emma Davis">
                        <span class="online-status away"></span>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h4>Emma Davis</h4>
                            <span class="chat-time">3h ago</span>
                        </div>
                        <p class="chat-preview">Can you send me the latest design files?</p>
                    </div>
                </div>

                <div class="chat-item" data-chat="4">
                    <div class="chat-avatar">
                        <img src="https://i.pravatar.cc/150?img=8" alt="Mike Chen">
                        <span class="online-status offline"></span>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h4>Mike Chen</h4>
                            <span class="chat-time">Yesterday</span>
                        </div>
                        <p class="chat-preview">Thanks for the update!</p>
                    </div>
                </div>

                <div class="chat-item" data-chat="5">
                    <div class="chat-avatar">
                        <div class="group-avatar">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h4>Project Alpha</h4>
                            <span class="chat-time">2 days ago</span>
                        </div>
                        <p class="chat-preview"><strong>You:</strong> Completed the task list</p>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="chat-window">
            
            <div class="chat-window-header">
                <div class="chat-user-info">
                    <div class="chat-avatar">
                        <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                        <span class="online-status online"></span>
                    </div>
                    <div>
                        <h3>John Smith</h3>
                        <span class="user-status">Active now</span>
                    </div>
                </div>
                <div class="chat-window-actions">
                    <button class="icon-btn" title="Voice Call">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="icon-btn" title="Video Call">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="icon-btn" title="Chat Info">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </div>
            </div>

       
            <div class="messages-area" id="messagesArea">
               
                <div class="date-divider">
                    <span>Today</span>
                </div>

               
                <div class="message received">
                    <div class="message-avatar">
                        <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <p>Hey! Did you get a chance to review the pull request?</p>
                        </div>
                        <span class="message-time">10:30 AM</span>
                    </div>
                </div>

            
                <div class="message sent">
                    <div class="message-content">
                        <div class="message-bubble">
                            <p>Yes, I just finished reviewing it. Looks good overall! 👍</p>
                        </div>
                        <span class="message-time">10:32 AM <i class="fas fa-check-double read"></i></span>
                    </div>
                </div>

            
                <div class="message received pinned">
                    <div class="pin-indicator">
                        <i class="fas fa-thumbtack"></i>
                        <span>Pinned Message</span>
                    </div>
                    <div class="message-avatar">
                        <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <p>Just added a few minor comments. Can you take a look when you have time?</p>
                        </div>
                        <span class="message-time">10:35 AM</span>
                    </div>
                </div>

               
                <div class="message sent">
                    <div class="message-content">
                        <div class="message-bubble">
                            <p>Great! I'll review the code tomorrow morning.</p>
                        </div>
                        <span class="message-time">10:38 AM <i class="fas fa-check-double read"></i></span>
                    </div>
                </div>

                
                <div class="message received">
                    <div class="message-avatar">
                        <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <div class="file-attachment">
                                <i class="fas fa-file-pdf"></i>
                                <div class="file-info">
                                    <span class="file-name">project_documentation.pdf</span>
                                    <span class="file-size">2.4 MB</span>
                                </div>
                                <button class="download-btn">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <span class="message-time">10:40 AM</span>
                    </div>
                </div>

              
                <div class="message received typing-indicator">
                    <div class="message-avatar">
                        <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <div class="typing-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="message-input-area">
                <button class="icon-btn" title="Attach File">
                    <i class="fas fa-paperclip"></i>
                </button>
                <button class="icon-btn" title="Emoji">
                    <i class="fas fa-smile"></i>
                </button>
                <div class="input-wrapper">
                    <input type="text" placeholder="Type a message..." id="messageInput">
                </div>
                <button class="icon-btn" title="Voice Message">
                    <i class="fas fa-microphone"></i>
                </button>
                <button class="send-btn" id="sendBtn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>


        <div class="chat-info-panel" id="chatInfoPanel">
            <div class="info-header">
                <h3>Chat Info</h3>
                <button class="icon-btn" id="closeChatInfo">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="info-content">
                <div class="info-profile">
                    <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                    <h3>John Smith</h3>
                    <p>Software Developer</p>
                    <span class="status-badge online">Online</span>
                </div>

                <div class="info-section">
                    <h4>Contact Information</h4>
                    <p><i class="fas fa-envelope"></i> john.smith@make-it-all.co.uk</p>
                    <p><i class="fas fa-phone"></i> +44 1509 888999</p>
                </div>

                <div class="info-section">
                    <h4>Shared Files</h4>
                    <div class="shared-file">
                        <i class="fas fa-file-pdf"></i>
                        <span>project_documentation.pdf</span>
                    </div>
                    <div class="shared-file">
                        <i class="fas fa-file-image"></i>
                        <span>design_mockup.png</span>
                    </div>
                </div>

                <div class="info-section">
                    <h4>Actions</h4>
                    <button class="info-action-btn">
                        <i class="fas fa-bell-slash"></i> Mute Notifications
                    </button>
                    <button class="info-action-btn danger">
                        <i class="fas fa-trash"></i> Delete Chat
                    </button>
                </div>
            </div>
        </div>
    </div>

   
    <div class="modal-overlay" id="newChatModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Start New Chat</h3>
                <button class="close-modal" data-modal="newChatModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="search-users">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search employees...">
                </div>
                <div class="user-list">
                    <div class="user-item">
                        <img src="https://i.pravatar.cc/150?img=2" alt="Sarah Johnson">
                        <div class="user-info">
                            <h4>Sarah Johnson</h4>
                            <p>Project Manager</p>
                        </div>
                        <button class="select-btn">Chat</button>
                    </div>
                    <div class="user-item">
                        <img src="https://i.pravatar.cc/150?img=3" alt="Alex Brown">
                        <div class="user-info">
                            <h4>Alex Brown</h4>
                            <p>Designer</p>
                        </div>
                        <button class="select-btn">Chat</button>
                    </div>
                    <div class="user-item">
                        <img src="https://i.pravatar.cc/150?img=4" alt="Lisa Wong">
                        <div class="user-info">
                            <h4>Lisa Wong</h4>
                            <p>Developer</p>
                        </div>
                        <button class="select-btn">Chat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <div class="modal-overlay" id="newGroupModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Create Group Chat</h3>
                <button class="close-modal" data-modal="newGroupModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <label>Group Name</label>
                <input type="text" placeholder="Enter group name..." class="form-input">
                
                <label>Add Members</label>
                <div class="search-users">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search employees...">
                </div>
                
                <div class="selected-members">
                    <span class="member-tag">John Smith <i class="fas fa-times"></i></span>
                    <span class="member-tag">Emma Davis <i class="fas fa-times"></i></span>
                </div>

                <div class="user-list">
                    <div class="user-item">
                        <input type="checkbox" id="user1" checked>
                        <img src="https://i.pravatar.cc/150?img=1" alt="John Smith">
                        <div class="user-info">
                            <h4>John Smith</h4>
                            <p>Software Developer</p>
                        </div>
                    </div>
                    <div class="user-item">
                        <input type="checkbox" id="user2" checked>
                        <img src="https://i.pravatar.cc/150?img=5" alt="Emma Davis">
                        <div class="user-info">
                            <h4>Emma Davis</h4>
                            <p>QA Engineer</p>
                        </div>
                    </div>
                    <div class="user-item">
                        <input type="checkbox" id="user3">
                        <img src="https://i.pravatar.cc/150?img=8" alt="Mike Chen">
                        <div class="user-info">
                            <h4>Mike Chen</h4>
                            <p>UI Designer</p>
                        </div>
                    </div>
                </div>

                <button class="primary-btn">Create Group</button>
            </div>
        </div>
    </div>

   
    <div class="modal-overlay" id="chatSettingsModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Chat Settings</h3>
                <button class="close-modal" data-modal="chatSettingsModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="setting-item">
                    <div class="setting-info">
                        <h4>Dark Mode</h4>
                        <p>Switch to dark theme</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="darkModeToggle">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h4>Notifications</h4>
                        <p>Enable message notifications</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h4>Text Size</h4>
                        <p>Adjust message text size</p>
                    </div>
                    <select class="form-select">
                        <option>Small</option>
                        <option selected>Medium</option>
                        <option>Large</option>
                    </select>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h4>Enter to Send</h4>
                        <p>Press Enter to send messages</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php requireModule(['nav', 'chat/chat']) ?>
</body>
</html>