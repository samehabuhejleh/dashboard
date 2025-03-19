@extends('layouts.user')

@section('content')
<!-- User List for selecting Receiver -->
<div id="user-list" style="margin-bottom: 20px;">
    <h4>Select a User to Chat:</h4>
    <ul id="users">
        <!-- Populate with dynamic users -->
        @foreach ($users as $user)
            @if ($user->id != auth()->id()) <!-- Do not list the logged-in user -->
                <li data-user-id="{{ $user->id }}" style="cursor: pointer; padding: 5px; border: 1px solid #ccc; margin-bottom: 5px;">
                    {{ $user->name }}
                </li>
            @endif
        @endforeach
    </ul>
</div>

<!-- Chat Box -->
<div id="chat-box" style="border: 1px solid #ccc; height: 300px; overflow-y: scroll; padding: 10px; margin-bottom: 10px;"></div>

<!-- Message Input -->
<input type="text" id="message" placeholder="Type a message" style="width: 80%; padding: 10px;">
<button id="send" style="padding: 10px;">Send</button>
@endsection

@push('js')
<!-- Include Pusher CDN -->
<script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/web/pusher.min.js"></script>

<script>
$(document).ready(function () {
    var senderId = "{{ auth()->id() }}";
    var receiverId = null; // Dynamically set receiver ID


        Pusher.logToConsole = true;
        var pusher = new Pusher('8359898a5e7d7425e234', {
        cluster: 'ap2',
        forceTLS: true
        });

    // Event listener for selecting a receiver from the user list
    $('#users li').click(function () {
        receiverId = $(this).data('user-id');
        console.log("Receiver ID set to: " + receiverId);

        // Subscribe to the private chat channel for the selected receiver
        var channel = pusher.subscribe('chat.' + senderId + '.' + receiverId);

        // Listen for 'MessageSent' event
        channel.bind('MessageSent', function(event) {
            console.log("Message received: ", event);
            $("#chat-box").append("<p><strong>" + (event.sender_id == senderId ? "Me" : "User") + ":</strong> " + event.message + "</p>");
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight); // Scroll to bottom
        });

        // Fetch existing messages for the selected chat
        $.get("/get-messages/" + receiverId, function (messages) {
            console.log("Messages fetched: ", messages);
            $("#chat-box").empty(); // Clear the chat box before appending new messages
            messages.forEach(function (msg) {
                $("#chat-box").append("<p><strong>" + (msg.sender_id == senderId ? "Me" : "User") + ":</strong> " + msg.message + "</p>");
            });
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight); // Scroll to bottom
        }).fail(function (error) {
            console.error("Error fetching messages: ", error);
        });
    });

    // Sending a message
    $("#send").click(function () {
        var message = $("#message").val();
        console.log("Sending message: ", message);

        if (message.trim() === "" || !receiverId) {
            console.log("Message is empty or no receiver selected.");
            return; // Prevent sending empty messages or without a receiver
        }

        // Send the message to the server
        $.post("/send-message", {
            receiver_id: receiverId,
            message: message,
            _token: "{{ csrf_token() }}"
        }, function (response) {
            console.log("Message sent: ", response);
            $("#message").val(""); // Clear the input field
            // Append the sent message to chat box
            $("#chat-box").append("<p><strong>Me:</strong> " + response.message + "</p>");
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight); // Scroll to bottom
        }).fail(function (error) {
            console.error("Error sending message: ", error);
        });
    });
});
</script>
@endpush
