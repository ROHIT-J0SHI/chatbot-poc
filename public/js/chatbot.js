const botui = new BotUI("botui-app");
let userName, email, phone, message;

function getCsrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
}

function askForEmail() {
    botui.message
        .add({ content: "What is your email?" })
        .then(() =>
            botui.action.text({ action: { placeholder: "Enter your email" } })
        )
        .then((res) => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(res.value)) {
                botui.message
                    .add({ content: "Please enter a valid email address." })
                    .then(askForEmail);
            } else {
                email = res.value;
                askForPhone();
            }
        });
}

function askForPhone() {
    botui.message
        .add({ content: "What is your phone number?" })
        .then(() =>
            botui.action.text({
                action: { placeholder: "Enter your phone number" },
            })
        )
        .then((res) => {
            const phoneRegex = /^\d{10}$/; // 10 digits
            if (!phoneRegex.test(res.value)) {
                botui.message
                    .add({
                        content: "Please enter a valid 10-digit phone number.",
                    })
                    .then(askForPhone);
            } else {
                phone = res.value;
                askForMessage(); // Directly ask for the message
            }
        });
}


function askForMessage() {
    botui.message
        .add({ content: "Please enter your message:" })
        .then(() =>
            botui.action.text({ action: { placeholder: "Enter your message" } })
        )
        .then((res) => {
            message = res.value;
            botui.message.add({
                content:
                    "Thanks for chatting with us. We will get back to you soon. Take care!",
            }); // Immediate response
            sendMessage();
        });
}

function sendMessage() {
    const csrfToken = getCsrfToken();

    axios
        .post(
            "/api/chatbot/store",
            {
                name: userName,
                email: email,
                phone: phone,
                message: message,
            },
            {
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                },
            }
        )
        .then(function (response) {
            botui.message
                .add({ content: "Your message has been sent successfully!" })
                .then(endConversation);
        })
        .catch(function (error) {
            console.error("Error sending message:", error);
            botui.message
                .add({
                    content:
                        "There was an error sending your message. Please try again.",
                })
                .then(endConversation);
        });
}

function endConversation() {
    document.getElementById("botui-app").style.display = "none";
    document.getElementById("chat-btn").style.display = "block";
}

// Start conversation
botui.message
    .add({ content: "Hello! Welcome to our chatbot. What is your name?" })
    .then(() =>
        botui.action.text({ action: { placeholder: "Enter your name" } })
    )
    .then((res) => {
        userName = res.value.trim();
        if (!userName) {
            botui.message
                .add({ content: "Please provide a valid name." })
                .then(() => {
                    return botui.action
                        .text({
                            action: {
                                placeholder: "Enter your name",
                            },
                        })
                        .then((res) => {
                            userName = res.value.trim();
                            if (!userName) {
                                askForEmail();
                            } else {
                                botui.message
                                    .add({
                                        content: `Nice to meet you, ${userName}!`,
                                    })
                                    .then(askForEmail);
                            }
                        });
                });
        } else {
            botui.message
                .add({ content: `Nice to meet you, ${userName}!` })
                .then(askForEmail);
        }
    });

// Chat Button and Close Button Logic
const chatBtn = document.getElementById("chat-btn");
const botuiApp = document.getElementById("botui-app");

chatBtn.addEventListener("click", () => {
    botuiApp.style.display = "block";
    chatBtn.style.display = "none";
});

botuiApp.style.display = "none";

const closeButton = document.createElement("button");
closeButton.textContent = "×"; // Simple close icon
closeButton.classList.add("close-button");
closeButton.addEventListener("click", () => {
    botuiApp.style.display = "none";
    chatBtn.style.display = "block";
});

botuiApp.appendChild(closeButton);

const botuiContainer = document.querySelector("#botui-app .botui-container");
if (botuiContainer) {
    botuiContainer.appendChild(closeButton);
} else {
    console.error(
        "BotUI container not found. Close button could not be added."
    );
}