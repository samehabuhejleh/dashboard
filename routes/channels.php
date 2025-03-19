<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
// routes/channels.php

Broadcast::channel('chat.{senderId}.{receiverId}', function ($user, $senderId, $receiverId) {
    return (int) $user->id === (int) $senderId || (int) $user->id === (int) $receiverId;
});
