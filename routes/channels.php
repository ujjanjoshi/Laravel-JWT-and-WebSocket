<?php

use App\Models\User;
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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('public.forwebsocket.{id}', function (User $user, $id) {
    return true;
});
Broadcast::channel('public.login.{id}', function (User $user, $id) {
    return true;
});
Broadcast::channel('public.specificnotf.{id}', function (User $user, $id) {
    return true;
});
Broadcast::channel('public.specificclass.{id}', function (User $user, $id) {
    return true;
});
Broadcast::channel('public.billprinted.{id}', function (User $user, $id) {
    return true;
});
Broadcast::channel('public.resultpublished.{id}', function (User $user, $id) {
    return true;
});
//billprinted
//resultpublished
//Broadcast::channel('private.notificationtodos.{id}', function (User $user, $id) {
//    return true;
//});
//
//Broadcast::channel('private.todocreate.{id}', function (User $user, $id) {
//    return true;
//});



