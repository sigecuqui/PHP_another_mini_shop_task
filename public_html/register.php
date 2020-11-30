<?php

require '../bootloader.php';

if (is_logged_in()) {
    header('Location: login.php');
    exit();
}

$form = [
    'attr' => [
        'method' => 'POST',
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_field_contains_no_digit'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter your name',
                    'class' => 'input-field',
                ]
            ]
        ],
        'surname' => [
            'label' => 'Surname',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_field_contains_no_digit'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter your surname',
                    'class' => 'input-field',
                ]
            ]
        ],
        'email' => [
            'label' => 'Email',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_email',
                'validate_user_unique',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter your email',
                    'class' => 'input-field',
                ]
            ]
        ],
        'address' => [
            'label' => 'Address',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter your address',
                    'class' => 'input-field',
                ]
            ]
        ],
        'phone' => [
            'label' => 'Phone',
            'type' => 'number',
            'validators' => [
                'validate_field_not_empty',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter your phone number',
                    'class' => 'input-field',
                ]
            ]
        ],
        'password' => [
            'label' => 'Password',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_name_max_symbols'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter password',
                    'class' => 'input-field',
                ]
            ]
        ],
        'password_repeat' => [
            'label' => 'Password repeat',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Repeat password',
                    'class' => 'input-field',
                ]
            ]
        ],
    ],
    'buttons' => [
        'send' => [
            'title' => 'Register',
            'type' => 'submit',
            'extra' => [
                'attr' => [
                    'class' => 'btn',
                ]
            ]
        ]
    ],
    'validators' => [
        'validate_fields_match' => [
            'password',
            'password_repeat'
        ]
    ]
];

$clean_inputs = get_clean_input($form);

if ($clean_inputs) {
    $success = validate_form($form, $clean_inputs);

    if ($success) {
        unset($clean_inputs['password_repeat']);

        $rows = file_to_array(ROOT . '/app/data/db.json');
        $rows['users'][] = $clean_inputs + ['items' => 0];

        array_to_file($rows, ROOT . '/app/data/db.json');

        header("Location: login.php");
    } else {
        $text_output = 'Registration failed';
    }
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include(ROOT . '/app/templates/nav.php'); ?>
<main>
    <h2>Registration</h2>
    <?php require ROOT . '/core/templates/form.tpl.php'; ?>
    <?php if (isset ($text_output)): ?>
        <p><?php print $text_output; ?></p>
    <?php endif; ?>
</main>
</body>
</html>

