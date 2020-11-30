<?php

require '../../bootloader.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$form = [
    'attr' => [
        'method' => 'POST',
    ],
    'fields' => [
        'name' => [
            'label' => 'Item',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter item\'s name',
                    'class' => 'input-field',
                ],
            ],
        ],
        'price' => [
            'label' => 'Price',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_numeric',
                'validate_field_range' => [
                    'min' => 1,
                    'max' => 9999,
                ]
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter item\'s price',
                    'class' => 'input-field',
                ],
            ],
        ],
        'contact' => [
            'label' => 'Contact me',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter your contacts: email, phone',
                    'class' => 'input-field',
                ],
            ],
        ],
        'image' => [
            'label' => 'Image URL',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_url',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Enter item\'s image URL',
                    'class' => 'input-field',
                ],
            ],
        ],
    ],
    'buttons' => [
        'send' => [
            'title' => 'Add',
            'type' => 'submit',
            'extra' => [
                'attr' => [
                    'class' => 'btn',
                ],
            ],
        ],
    ],
];

$clean_inputs = get_clean_input($form);

if ($clean_inputs) {
    $is_valid = validate_form($form, $clean_inputs);

    if ($is_valid) {
        $user = is_logged_user();
        $input_from_json = file_to_array(DB_FILE);

        $input_from_json['items'][] = $clean_inputs + ['email' => $_SESSION['email'], 'id' => uniqid()];
        $input_from_json['users'][$user]['items'] += 1;

        array_to_file($input_from_json, DB_FILE);

        $text_output = 'Item added successfully';
    } else {
        $text_output = 'Error: Item can not be added';
    }
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include(ROOT . '/app/templates/nav.php'); ?>
<main>
    <h2>Add item</h2>
    <p><?php require ROOT . '/core/templates/form.tpl.php'; ?></p>
    <?php if (isset($text_output)) print $text_output; ?>
</main>
</body>
</html>

