<?php

require '../bootloader.php';

$data = file_to_array(DB_FILE);

if (is_logged_in()) {
    $user_key = is_logged_user();
    $users['Pirkėjas'] = $data['users'][$user_key];
    $pvm_number = rand(1000000000000,9999999999999);
    $date = date('Y-m-d',time());

    foreach ($data['items'] as $item_key => $items) {
        if ($items['id'] == $_POST['id']) {
            $product = $items;
            unset($data['items'][$item_key]);
            $data['items'] = array_values($data['items']);
            array_to_file($data, DB_FILE);
        }
    }

    foreach ($data['users'] as $key => $seller) {
        if ($seller['email'] == $product['email']) {
            $users['Pardavejas'] = $seller;
            $data['users'][$key]['items'] -= 1;
            array_to_file($data, DB_FILE);
        }
    }

} else {
    header('Location: /login.php');
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Shop</title>
</head>
<body>
<main>

    <?php require ROOT . '/app/templates/nav.php'; ?>

    <article>
        <h1>PVM Sąskaita-faktūra</h1>
        <h2>PVM Serija: PG-<?php print $pvm_number; ?></h2>
        <h3><?php print $date; ?></h3>
        <section>

            <?php foreach ($users as $user_key => $user) :?>

                <div class="contacts">
                    <h4><?php print $user_key; ?></h4>
                    <p><?php print "{$user['name']} {$user['surname']}"; ?></p>
                    <p><?php print $user['email']; ?></p>
                    <p><?php print $user['address']; ?></p>
                    <p><?php print $user['phone']; ?></p>
                </div>

            <?php endforeach; ?>

        </section>
        <section class="grid-container">
            <h3>Jusu preke <?php print $product['name']; ?></h3>
            <div>
                <img class="product-img" src="<?php print $product['image']; ?>" alt="">
                <p><?php print $product['price']; ?> $</p>
                <p>Email/skype/phone: <?php print $product['contact']; ?></p>
            </div>
        </section>
    </article>
</main>
</body>
</html>