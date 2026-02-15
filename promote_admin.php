<?php
$user = App\Models\User::first();
if ($user) {
    $user->forceFill(['is_admin' => true])->save();
    echo "SUCCESS: User {$user->email} has been promoted to Admin.";
} else {
    echo "ERROR: No users found in the database.";
}
