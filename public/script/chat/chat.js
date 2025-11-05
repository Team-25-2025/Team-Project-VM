const chatItems = document.querySelectorAll('.chat-item');
chatItems.forEach(item => {
    item.addEventListener('click', () => {
        
        chatItems.forEach(i => i.classList.remove('active'));
        
        item.classList.add('active');
        
        console.log('Loading chat:', item.dataset.chat);
    });
});


const newChatBtn = document.getElementById('newChatBtn');
const newGroupBtn = document.getElementById('newGroupBtn');
const chatSettingsBtn = document.getElementById('chatSettingsBtn');

const newChatModal = document.getElementById('newChatModal');
const newGroupModal = document.getElementById('newGroupModal');
const chatSettingsModal = document.getElementById('chatSettingsModal');

newChatBtn.addEventListener('click', () => {
    newChatModal.classList.add('active');
});

newGroupBtn.addEventListener('click', () => {
    newGroupModal.classList.add('active');
});

chatSettingsBtn.addEventListener('click', () => {
    chatSettingsModal.classList.add('active');
});


const closeModalBtns = document.querySelectorAll('.close-modal');
closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const modalId = btn.dataset.modal;
        document.getElementById(modalId).classList.remove('active');
    });
});


const modals = document.querySelectorAll('.modal-overlay');
modals.forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
});


const messageInput = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');
const messagesArea = document.getElementById('messagesArea');

function sendMessage() {
    const text = messageInput.value.trim();
    if (text) {
     
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message sent';
        messageDiv.innerHTML = `
            <div class="message-content">
                <div class="message-bubble">
                    <p>${text}</p>
                </div>
                <span class="message-time">${new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })} <i class="fas fa-check-double"></i></span>
            </div>
        `;
        
        
        const typingIndicator = document.querySelector('.typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
        
  
        messagesArea.appendChild(messageDiv);
        
  
        messageInput.value = '';
        
      
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }
}

sendBtn.addEventListener('click', sendMessage);

messageInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        sendMessage();
    }
});


const darkModeToggle = document.getElementById('darkModeToggle');
darkModeToggle.addEventListener('change', () => {
    document.body.classList.toggle('dark-mode');
});


const chatInfoPanel = document.getElementById('chatInfoPanel');
const closeChatInfoBtn = document.getElementById('closeChatInfo');


const chatWindowActions = document.querySelector('.chat-window-actions');
if (chatWindowActions) {
    const actionButtons = chatWindowActions.querySelectorAll('.icon-btn');
    
    
    if (actionButtons.length >= 3) {
        const infoButton = actionButtons[2];
        infoButton.addEventListener('click', () => {
            console.log('Info button clicked!');
            chatInfoPanel.classList.toggle('active');
        });
    }
}


if (closeChatInfoBtn) {
    closeChatInfoBtn.addEventListener('click', () => {
        chatInfoPanel.classList.remove('active');
    });
}


const chatSearchInput = document.getElementById('chatSearchInput');
chatSearchInput.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    chatItems.forEach(item => {
        const name = item.querySelector('h4').textContent.toLowerCase();
        const preview = item.querySelector('.chat-preview').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || preview.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});


messagesArea.scrollTop = messagesArea.scrollHeight;

console.log('Chat system loaded successfully!');