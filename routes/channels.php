<?php

use Illuminate\Support\Facades\Broadcast;
use App\Enums\UserRoleEnum;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});




Broadcast::channel('follow-up-updates', function ($user) {
    return in_array($user->role, [
        UserRoleEnum::ADMIN->value,
        UserRoleEnum::SALESMANAGER->value,
    ]);
});