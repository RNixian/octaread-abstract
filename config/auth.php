<?php
return [

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users', // Default provider for users
    ],

    'admin' => [ // Custom guard for admins
        'driver' => 'session',
        'provider' => 'admins', 
    ],

],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\usermodel::class, // Model for users
    ],

    'admins' => [ // Custom provider for admins
        'driver' => 'eloquent',
        'model' => App\Models\adminmodel::class, // Model for admins
    ],
],

];
