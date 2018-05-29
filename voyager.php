<?php

return [

    'user' => [
        'add_default_role_on_register' => true,
        'default_role'                 => 'user',
        'admin_permission'             => 'browse_admin',
        'namespace'                    => 'App\\Models\\User',
    ],

    'models' => [
        'namespace' => 'App\\Models',
    ],

];