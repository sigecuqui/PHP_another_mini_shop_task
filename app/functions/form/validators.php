<?php

// //////////////////////////////
// [1] FORM VALIDATORS
// //////////////////////////////

/**
 * Check if login is successful
 *
 * @param $form_values
 * @param array $form
 * @return bool
 */
function validate_login($form_values, array &$form): bool
{
    $db_data = file_to_array(DB_FILE);

    foreach ($db_data['users'] as $entry) {
        if ($form_values['email'] === $entry['email']
            && $form_values['password'] === $entry['password']) {

            return true;
        }
    }

    $form['error'] = 'Unable to login: check your email and/or password';

    return false;
}

// //////////////////////////////
// [2] FIELD VALIDATORS
// //////////////////////////////

/**
 * Checks if user(data) already exists in our saved file.
 *
 * @param string $field_input
 * @param array $field
 * @return bool
 */
function validate_user_unique(string $field_input, array &$field): bool
{
    $data = file_to_array(DB_FILE);
    foreach ($data['users'] ?? [] as $entry) {
        if ($field_input === $entry['email']) {
            $field['error'] = 'This email is already taken';
            return false;
        }
    }

    return true;
}
