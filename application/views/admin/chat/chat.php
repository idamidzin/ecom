<style>
/* Container for the chat layout */
.chat-layout {
    display: flex;
    flex-direction: row;
    min-height: 450px;
    height: 450px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Contacts section */
.contacts {
    width: 30%;
    border-right: 1px solid #d1d5db;
    background-color: #f9f9f9;
    overflow-y: auto;
}

.contacts .contact {
    padding: 10px 15px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #e1e1e1;
    cursor: pointer;
}

.contacts .contact:hover {
    background-color: #e5e7eb;
}

.contacts .contact-name {
    font-size: 14px;
    font-weight: normal;
}

/* Chat section */
.chat {
    width: 70%;
    display: flex;
    flex-direction: column;
}

/* Chat messages area */
.chat-messages {
    /* flex: 1; */
    padding: 15px;
    overflow-y: auto;
    background-color: #f8f9fa;
}

.chat-message {
    display: flex;
    margin-bottom: 10px;
}

.chat-message.user {
    justify-content: flex-end;
}

.chat-message.friend {
    justify-content: flex-start;
}

.message {
    max-width: 60%;
    padding: 10px;
    font-size: 14px;
    line-height: 1.4;
    border-radius: 8px;
    position: relative;
}

.message.user {
    background-color: #dcf8c6;
    color: #000000;
    border-top-right-radius: 0;
}

.message.friend {
    background-color: #ffffff;
    color: #000000;
    border: 1px solid #e1e1e1;
    border-top-left-radius: 0;
}

.time-user,
.time-friend {
    font-size: 12px;
    margin-top: 5px;
    color: #9ca3af;
}

/* Chat input area */
.chat-input {
    display: flex;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #d1d5db;
    background-color: #f1f5f9;
}

.chat-input textarea {
    flex: 1;
    border: none;
    outline: none;
    font-size: 14px;
    border-radius: 8px;
    resize: none;
    margin-right: 10px;
}

.chat-input button {
    padding: 10px 20px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.chat-input button:hover {
    background-color: #45a049;
}

.received {
    border-radius: 16px 16px 0 16px;
}

.sent {
    border-radius: 16px 16px 0 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chat-layout {
        flex-direction: column; /* Susunan vertikal untuk layar kecil */
        height: auto;
        min-height: 350px;
    }

    .contacts {
        width: 100%;
        display: none; /* Sembunyikan kontak secara default */
    }

    .contacts.active {
        display: block; /* Tampilkan kontak jika aktif */
    }

    .chat {
        width: 100%;
        display: none; /* Sembunyikan chat secara default */
    }

    .chat.active {
        display: flex; /* Tampilkan chat jika aktif */
    }

    .chat-messages {
        height: 300px; /* Tinggi dinamis untuk layar kecil */
        min-height: 300px;
    }

    .chat-input textarea {
        font-size: 12px;
    }

    .chat-input button {
        padding: 8px 15px;
        font-size: 12px;
    }

    .contacts .contact-name {
        font-size: 14px;
    }

    .message {
        font-size: 12px;
    }

    .time-user,
    .time-friend {
        font-size: 10px;
    }

    .time-user {
        justify-content: flex-end;
    }
}

</style>

<div class="content">
    <h2 class="intro-y text-lg font-medium mt-5">
        Chat
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <div class="chat-layout">
                <div class="contacts" id="contacts">
                    <div class="p-3">
                        <h4 class="ml-1" style="font-weight: bold;">Daftar Kontak</h4>
                    </div>
                    <hr>
                    <?php foreach ($users as $user): ?>
                        <?php if ($user_id != $user->id_user) { ?>
                            <div class="contact" onclick="selectContact(<?= $user->id_user ?>, '<?= $user->nama_user ?>')">
                                <div class="contact-name" data-id="<?= $user->id_user ?>"><?= $user->nama_user ?></div>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>
                </div>

                <div class="chat" id="chat">
                    <a style="display: inline-flex !important; background-color: #243e8d; padding: 10px; color: white;" onclick="showChat(false)">
                        <i data-lucide="arrow-left"></i> <span id="selected-contact"></span>
                    </a>
                    <div class="chat-messages" id="chat-messages"></div>
                    <div class="chat-input">
                    <textarea id="message-input" style="height: 40px;" placeholder="Tulis pesan disini"></textarea>
                        <button id="send-button" style="height: 40px; background-color: #243e8d;"><i class="fa fa-paper-plane" style="font-size: 14px;"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
let currentFriendId = null;
const userId = `<?= $user_id; ?>`;

Pusher.logToConsole = false;

var pusher = new Pusher('1195c945bd85e10d0c5b', {
    cluster: 'ap1'
});

var channel = pusher.subscribe(`chat-channel-${userId}`);
channel.bind(`new-message`, function(data) {
    const messageText = data.message || '';

    const chatMessages = document.getElementById('chat-messages');
    const newMessage = `
        <div class="chat-message friend">
            <div class="message">
                <p>${messageText}</p>
                <span class="time-friend">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
            </div>
        </div>
    `;
    chatMessages.innerHTML += newMessage;
    chatMessages.scrollTop = chatMessages.scrollHeight;
});

$(document).ready(function () {
    // $('.contact').first().click();
    showChat(false);
    loadMessages();
});

function selectContact(userId, name) {
    document.getElementById('contacts').classList.remove('active');
    document.getElementById('chat').classList.add('active');
    document.getElementById('selected-contact').innerHTML = name;
    window.location.href = '<?= site_url("admin/chat?sender_id=") ?>' + userId;
}

function showChat(show) {
    if (show) {
        document.getElementById('contacts').classList.remove('active');
        document.getElementById('chat').classList.add('active');
    } else {
        document.getElementById('contacts').classList.add('active');
        document.getElementById('chat').classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('contacts').classList.add('active');
});

function loadMessages() {
    const sender_id = '<?= $sender_id ?>';
    currentFriendId = sender_id ? sender_id : null;
    if (!currentFriendId) return;

    $.post('<?= site_url("admin/Chat/getMessages") ?>', { friend_id: currentFriendId }, function (res) {
        try {
            const data = JSON.parse(res);
            const { messages, user } = data;
            const chatBox = $('#chat-messages');
            chatBox.html('');

            if (user) {
                document.getElementById('selected-contact').innerHTML = user.nama_user;
            }

            if (messages.length > 0) {
                let groupedMessages = [];
                let lastTimestamp = null;

                messages.forEach(msg => {
                    const timestamp = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    const isUser = msg.receiver_id == userId;
                    const msgClass = isUser ? 'friend received' : 'user sent';
                    const formattedMessage = msg.message.replace(/\n/g, '<br>');

                    groupedMessages.push({
                        isUser,
                        time: timestamp,
                        msgClass: msgClass,
                        messages: [formattedMessage],
                    });
                    lastTimestamp = timestamp;
                });

                groupedMessages.forEach(group => {
                    chatBox.append(`
                        <div class="chat-message ${group.msgClass}">
                            <div class="message">
                                <p>${group.messages}</p>
                                <span style="text-align: ${group.isUser ? 'left' : 'right'}; display: block;" class="time-${group.msgClass}">${group.time}</span>
                            </div>
                        </div>
                    `);
                });
            }

            chatBox.scrollTop(chatBox[0].scrollHeight);
        } catch (e) {
            console.error('Error parsing messages:', e);
        }
    });
}

document.getElementById('send-button').addEventListener('click', function () {
    const input = document.getElementById('message-input');
    const messageText = input.value.trim();

    if (messageText && currentFriendId) {
        const chatMessages = document.getElementById('chat-messages');
        const currentTime = new Date();
        const currentTimestamp = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        // Cari elemen terakhir di chat box
        const lastMessageGroup = chatMessages.querySelector('.chat-message:last-child');
        const isSameMinute = lastMessageGroup && lastMessageGroup.classList.contains('user') && lastMessageGroup.querySelector('.time-user').textContent === currentTimestamp;

        if (isSameMinute) {
            // Tambahkan pesan baru ke grup yang sama
            const lastMessageContent = lastMessageGroup.querySelector('.message p');
            lastMessageContent.innerHTML += `<br>${escapeHtml(messageText)}`;
        } else {
            // Buat grup pesan baru
            const newMessage = `
                <div class="chat-message user">
                    <div class="message">
                        <p>${escapeHtml(messageText)}</p>
                        <span class="time-user">${currentTimestamp}</span>
                    </div>
                </div>
            `;
            chatMessages.innerHTML += newMessage;
        }

        // Scroll ke bawah
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Kirim pesan ke server
        $.post('<?= site_url("admin/Chat/sendMessage") ?>', {
            receiver_id: currentFriendId,
            message: messageText
        }, function (response) {
            console.log('Message sent:', response);
        });

        // Kosongkan input
        input.value = '';
    }
});

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
</script>