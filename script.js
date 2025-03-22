document.addEventListener("DOMContentLoaded", function () {
    // Fetch and display posts
    fetch("fetch_posts.php")
        .then(response => response.json())
        .then(posts => {
            let feed = document.getElementById("feed");
            feed.innerHTML = "";

            posts.forEach(post => {
                let postElement = document.createElement("div");
                postElement.classList.add("post");

                let username = document.createElement("p");
                username.innerHTML = `<strong>${post.username}</strong>`;
                postElement.appendChild(username);

                if (post.filetype.startsWith("image")) {
                    let img = document.createElement("img");
                    img.src = post.filepath;
                    img.alt = "Uploaded Image";
                    postElement.appendChild(img);
                } else if (post.filetype.startsWith("video")) {
                    let video = document.createElement("video");
                    video.src = post.filepath;
                    video.controls = true;
                    postElement.appendChild(video);
                }

                feed.appendChild(postElement);
            });
        })
        .catch(error => console.error("Error fetching posts:", error));

    // Ensure DOM elements exist before adding event listeners
    let postBtn = document.getElementById("postBtn");
    let popup = document.getElementById("uploadPopup");
    let closePopup = document.getElementById("closePopup");
    let chatBtn = document.getElementById("chatBtn");
    let logoutBtn = document.getElementById("logoutBtn");

    // Post button functionality - Open upload popup
    if (postBtn && popup) {
        postBtn.addEventListener("click", function () {
            popup.style.display = "flex";
        });
    }

    // Close popup functionality
    if (closePopup && popup) {
        closePopup.addEventListener("click", function () {
            popup.style.display = "none";
        });
    }

    // Upload file functionality
    let uploadForm = document.getElementById("uploadForm");
    if (uploadForm) {
        uploadForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(uploadForm);

            fetch("upload.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    popup.style.display = "none";
                    location.reload(); // Refresh to show new post
                })
                .catch(error => console.error("Error uploading file:", error));
        });
    }

    // Chat button functionality - Redirect to chat page
    if (chatBtn) {
        chatBtn.addEventListener("click", function () {
            window.location.href = "chat.html"; // Redirect to chat page
        });
    }

    // Logout button functionality
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function () {
            fetch("logout.php")
                .then(() => {
                    window.location.href = "login.html"; // Redirect to login page
                })
                .catch(error => console.error("Logout failed:", error));
        });
    }
});
