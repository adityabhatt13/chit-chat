<!DOCTYPE html>
<html>
<head>
    <title>Chit Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body>
<div class="container">
    <!-- Sidebar (Contacts List) -->
    <div class="sidebar <?= !isset($chatUser) ? 'active' : '' ?>">
        <div class="sidebar-header">
            <div class="avatar"><?= strtoupper(substr((string) session('username'), 0, 2)) ?></div>
            <h3>Chats</h3>
            <a href="/auth/logout" class="logout-btn" title="Logout"><svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="icon">
                <path d="M868 732h-70.3c-4.8 0-9.3 2.1-12.3 5.8-7 8.5-14.5 16.7-22.4 24.5a353.84 353.84 0 0 1-112.7 75.9A352.8 352.8 0 0 1 512.4 866c-47.9 0-94.3-9.4-137.9-27.8a353.84 353.84 0 0 1-112.7-75.9 353.28 353.28 0 0 1-76-112.5C167.3 606.2 158 559.9 158 512s9.4-94.2 27.8-137.8c17.8-42.1 43.4-80 76-112.5s70.5-58.1 112.7-75.9c43.6-18.4 90-27.8 137.9-27.8 47.9 0 94.3 9.3 137.9 27.8 42.2 17.8 80.1 43.4 112.7 75.9 7.9 7.9 15.3 16.1 22.4 24.5 3 3.7 7.6 5.8 12.3 5.8H868c6.3 0 10.2-7 6.7-12.3C798 160.5 663.8 81.6 511.3 82 271.7 82.6 79.6 277.1 82 516.4 84.4 751.9 276.2 942 512.4 942c152.1 0 285.7-78.8 362.3-197.7 3.4-5.3-.4-12.3-6.7-12.3zm88.9-226.3L815 393.7c-5.3-4.2-13-.4-13 6.3v76H488c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h314v76c0 6.7 7.8 10.5 13 6.3l141.9-112a8 8 0 0 0 0-12.6z"/>
            </svg></a>
            
        </div>
        
        <?php if (isset($users) && !empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <a href="/dashboard/chat/<?= $user['id'] ?>" style="text-decoration:none; color:black;" class="user-link">
                    <div class="user-card <?= (isset($chatUser) && $chatUser['id'] == $user['id']) ? 'active' : '' ?>">
                        <div class="avatar"><?= strtoupper(substr($user['username'], 0, 2)) ?></div>
                        <span><?= htmlspecialchars($user['username']) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="padding: 15px; text-align: center; color: #666;">
                No other users available
            </div>
        <?php endif; ?>
    </div>
    <!-- Chat Section -->
    <div class="chat-section <?= isset($chatUser) ? 'active' : '' ?>">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="success-message"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (isset($chatUser)): ?>
            <div class="chat-header">
                <button class="back-btn" onclick="goBackToChats()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="avatar"><?= strtoupper(substr($chatUser['username'], 0, 2)) ?></div>
                <p><?= htmlspecialchars($chatUser['username']) ?></p>
            </div>
            <div class="chat-body">
                <?php if (isset($messages) && !empty($messages)): ?>
                    <?php foreach ($messages as $msg): ?>
                        <div class="message <?= $msg['sender_id'] == session('id') ? 'sent' : 'received' ?>" data-msg-id="<?= $msg['id'] ?>" data-created-at="<?= htmlspecialchars($msg['created_at']) ?>">
                            <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                            <span class="time" title="<?= date('d M Y, h:i A', strtotime($msg['created_at'])) ?>"><?= date('h:i A', strtotime($msg['created_at'])) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; color: #666; margin-top: 20px;">
                        No messages yet. Start the conversation!
                    </div>
                <?php endif; ?>
            </div>
            <form method="POST" action="/dashboard/sendMessage/<?= $chatUser['id'] ?>" class="chat-input">
                <input type="text" name="message" placeholder="Type a message..." required maxlength="1000">
                <button type="submit" class="send-button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
        <?php else: ?>
            <div class="empty-chat">
                <p>Select a user to start chatting</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
// Function to go back to chats list (mobile only)
function goBackToChats() {
    if (window.innerWidth <= 768) {
        window.location.href = '/dashboard';
    }
}

// Auto-scroll to bottom of chat
document.addEventListener('DOMContentLoaded', function() {
    const chatBody = document.querySelector('.chat-body');
    if (chatBody && chatBody.children.length > 1) {
        chatBody.scrollTop = chatBody.scrollHeight;
    }
});

// AJAX polling for new messages every 5 seconds
<?php if (isset($chatUser)): ?>
(function() {
    let lastTimestamp = null;
    // Initialize lastTimestamp from the latest message in chat-body
    document.addEventListener('DOMContentLoaded', function() {
        const chatBody = document.querySelector('.chat-body');
        if (chatBody && chatBody.lastElementChild && chatBody.lastElementChild.getAttribute('data-msg-id')) {
            // Try to get the timestamp from the last message's time span
            const timeElem = chatBody.lastElementChild.querySelector('.time');
            if (timeElem) {
                // Use the parent div's data-msg-id to find the message in PHP array if needed
                // But for now, just use the current time as a fallback
                lastTimestamp = chatBody.lastElementChild.getAttribute('data-created-at') || null;
            }
        }
    });
    function fetchMessages() {
        // Build API URL
        const userId = <?= json_encode($chatUser['id']) ?>;
        let url = `/api/message/poll/${userId}`;
        if (lastTimestamp) {
            url += `?since=${encodeURIComponent(lastTimestamp)}`;
        }
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    const chatBody = document.querySelector('.chat-body');
                    // Render new messages only
                    data.forEach(msg => {
                        // Avoid duplicate messages if polling returns all
                        if (!chatBody.querySelector(`[data-msg-id='${msg.id}']`)) {
                            const div = document.createElement('div');
                            div.className = 'message ' + (msg.sender_id == <?= json_encode(session('id')) ?> ? 'sent' : 'received');
                            div.setAttribute('data-msg-id', msg.id);
                            const time = new Date(msg.created_at);
                            const hours = time.getHours();
                            const minutes = time.getMinutes().toString().padStart(2, '0');
                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            const formattedHours = (hours % 12) || 12;
                            const formattedTime = `${formattedHours}:${minutes} ${ampm}`;
                            div.innerHTML = `<p>${msg.message.replace(/\n/g, '<br>')}</p><span class='time' title='${new Date(msg.created_at).toLocaleString()}'>${formattedTime}</span>`;
                            chatBody.appendChild(div);
                        }
                    });
                    // Scroll to bottom if new messages arrived
                    chatBody.scrollTop = chatBody.scrollHeight;
                    // Update lastTimestamp
                    lastTimestamp = data[data.length-1].created_at;
                }
            })
            .catch(err => {});
    }
    setInterval(function() {
        if (document.hidden === false) {
            fetchMessages();
        }
    }, 5000);
})();
<?php endif; ?>
</script>
</body>
</html>