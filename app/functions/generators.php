<?php

/**
 * Generate dynamic navigation for users, depending on log in status
 *
 * @return array|string[]
 */
function nav(): array
{
    if (is_logged_in()) {
        return [
            'Home' => '/index.php',
            'My Stuff' => '/admin/my.php',
            'Add Stuff' => '/admin/add.php',
            'My Order' => '/admin/cart.php',
            'Logout' => '/logout.php',
        ];
    } else {
        return [
            'Home' => '/index.php',
            'Login' => '/login.php',
            'Register' => '/register.php',
        ];
    }
}


