<?php

use App\Models\FollowUp;
use App\Enums\UserRoleEnum;
use App\Enums\FollowUpStatusEnum;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});






Broadcast::channel('follow-up-updates.{followUpId}', function ($user, $followUpId) {
    // Check if the user has the correct role (ADMIN or SALESMANAGER)
    $hasRole = in_array($user->role, [
        UserRoleEnum::ADMIN->value,
        UserRoleEnum::SALESMANAGER->value,
    ]);

    // Check if the user is assigned to the particular FollowUp
    $isAssigned = FollowUp::where('id', $followUpId)
                          ->where('user_id', $user->id) 
                          ->where('status', FollowUpStatusEnum::MISSED->value) 
                          ->exists();

    return $hasRole || $isAssigned;
});