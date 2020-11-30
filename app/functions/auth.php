<?php

/**
 * Check if user is logged in
 *
 * @return bool
 */
function is_logged_in(): bool
{
    if ($_SESSION) {
        $db_data = file_to_array(DB_FILE);

        foreach ($db_data['users'] ?? [] as $db_entry) {
            if ($_SESSION['email'] === $db_entry['email']
                && $_SESSION['password'] === $db_entry['password']) {

                return true;
            }
        }
    }

    return false;
}

/**
 * End user session. Log out user and redirect to given page.
 *
 * @param string|null $redirect
 */
function logout(string $redirect = null): void
{
    $_SESSION = [];
    session_destroy();

    if ($redirect) {
        header("Location: $redirect");
    }
}

/**
 * Function returns which index the user is written in database
 *
 * @return false|int|string
 */
function is_logged_user()
{
    if ($_SESSION) {
        $data = file_to_array(DB_FILE);
        foreach ($data['users'] as $key => $entry) {
            if ($_SESSION['email'] === $entry['email'] &&
                $_SESSION['password'] === $entry['password']) {
                return $key;
            }
        }
    }
    return false;
}