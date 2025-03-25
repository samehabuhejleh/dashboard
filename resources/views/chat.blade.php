<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; display: flex; height: 100vh; margin: 0; }
        #user-container { width: 25%; border-right: 1px solid #ccc; padding: 10px; background: #f8f9fa; overflow-y: auto; }
        #chat-container { width: 75%; padding: 10px; display: none; flex-direction: column; }
        #users-list { list-style: none; padding: 0; margin: 0; }
        #users-list li { cursor: pointer; padding: 10px; border-bottom: 1px solid #ccc; transition: background 0.3s; }
        #users-list li:hover, #users-list li.active { background: #007bff; color: white; }
        #chat-box { flex: 1; height: 70vh; overflow-y: auto; border: 1px solid #ccc; padding: 10px; display: flex; flex-direction: column; background: #fff; }
        .message { padding: 10px; margin: 5px 0; border-radius: 10px; max-width: 70%; word-wrap: break-word; }
        .text-right { align-self: flex-end; background: #dcf8c6; }
        .text-left { align-self: flex-start; background: #f1f1f1; }
        .chat-input { display: flex; margin-top: 10px; }
        #message { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        #send { padding: 10px 15px; border: none; background: #007bff; color: white; cursor: pointer; margin-left: 5px; border-radius: 5px; }
        #send:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div id="user-container">
        <ul id="users-list">
            @foreach ($users as $user)
                <li data-id="{{ $user->id }}">{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>
    <div id="chat-container">
        <h3 id="chat-header">Chat</h3>
        <div id="chat-box"></div>
        <div class="chat-input">
            <input type="text" id="message" placeholder="Type a message">
            <button id="send">Send</button>
        </div>
    </div>

    <script>
$(document).ready(function () {
    let receiverId = null;
    let senderId = $('meta[name="user-id"]').attr("content");
    let currentChannel = null;

    let pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
        cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
        forceTLS: true,
        authEndpoint: "/broadcasting/auth",
        auth: {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        }
    });

    $("#users-list li").click(function () {
        receiverId = $(this).data("id");
        $("#users-list li").removeClass("active");
        $(this).addClass("active");
        $("#chat-container").show();
        $("#chat-header").text("Chat with " + $(this).text());
        loadMessages(receiverId);
        subscribeToPusher(receiverId);
    });

    function subscribeToPusher(receiverId) {
        if (!receiverId) return;

        if (currentChannel) {
            pusher.unsubscribe(currentChannel);
        }

        let chatChannelName = "private-chat." + Math.min(senderId, receiverId) + "." + Math.max(senderId, receiverId);
        currentChannel = chatChannelName;
        var channel = pusher.subscribe(chatChannelName);

        channel.bind("new-message", function (data) {
            if (data.message.receiver_id == senderId || data.message.sender_id == senderId) {
                let alignClass = data.message.sender_id == senderId ? "text-right" : "text-left";
                $("#chat-box").append(`<div class="message ${alignClass}">${data.message.message}</div>`);
                $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
            }
        });
    }

    function loadMessages(receiverId) {
        if (!receiverId) return;
        $.get("/messages/" + receiverId, function (data) {
            $("#chat-box").html("");
            data.forEach(msg => {
                let alignClass = msg.sender_id == senderId ? "text-right" : "text-left";
                $("#chat-box").append(`<div class="message ${alignClass}">${msg.message}</div>`);
            });
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
        });
    }

    $("#send").click(function () {
        let message = $("#message").val();
        if (!message || !receiverId) return;

        $.post("/send-message", {
            receiver_id: receiverId,
            message: message,
            _token: $('meta[name="csrf-token"]').attr("content")
        }, function (data) {
            $("#message").val("");
        });
    });

    $("#message").keypress(function (e) {
        if (e.which == 13) {
            $("#send").click();
        }
    });
});
</script>
</body>
</html>
