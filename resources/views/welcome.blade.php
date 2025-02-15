<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/botui/build/botui.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/botui/build/botui-theme-default.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">


    <style>
        body {
            background-color:rgb(228, 228, 228);
            font-family: 'Roboto', sans-serif;
        }

        #botui-app {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden; 
            display: none;
            z-index: 1000;
        }

        .botui-container {
            padding: 15px;
            height: 350px; /* Fixed height for chat area */
            overflow-y: auto; /* Scroll only within the chat messages area */
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: auto transparent;
        }
        #botui-app::-webkit-scrollbar {
            width: 6px; 
        }
        
        #botui-app::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px; 
        }

        .botui-message {
            margin-bottom: 10px;
        }

        .botui-message-content {
            padding: 10px 14px;
            border-radius: 16px;
            max-width: 80%; 
            clear: both; 
        }

        .botui-message.bot .botui-message-content {
            background-color: #e1f0c4;
            color: #333;
            float: left; 
        }

        .botui-message.user .botui-message-content {
            background-color:rgb(228, 250, 211);
            color: #333;
            float: right; 
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #777;
        }

        #chat-btn {
            background-color: #25d366;
            color: white;
            padding: 10px 16px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 999;
        }

        #chat-btn:hover {
            background-color: #1da851;
        }
        .botui-actions{
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div id="botui-app">
        <bot-ui></bot-ui>
    </div>

    <button id="chat-btn">
        Chat
    </button>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/botui/build/botui.min.js"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
</body>

</html>