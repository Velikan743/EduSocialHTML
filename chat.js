document.getElementById("homeBtn").addEventListener("click", function () {
    window.location.href = "index.html";
});

function loadMessages() {
    fetch("fetch_messages.php")
        .then(response => response.json())
        .then(data => {
            let chatBox = document.getElementById("chatBox");
            chatBox.innerHTML = "";
            data.forEach(msg => {
                let messageDiv = document.createElement("div");
                messageDiv.classList.add("message");
                messageDiv.innerHTML = `<strong>${msg.username}:</strong> ${msg.message} <span>${msg.timestamp}</span>`;
                chatBox.appendChild(messageDiv);
            });
        });
}

document.getElementById("sendBtn").addEventListener("click", function () {
    let messageInput = document.getElementById("messageInput").value;
    if (messageInput.trim() !== "") {
        fetch("send_message.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `message=${encodeURIComponent(messageInput)}`
        }).then(() => {
            document.getElementById("messageInput").value = "";
            loadMessages();
        });
    }
});

setInterval(loadMessages, 3000); // Auto-refresh messages every 3 sec
