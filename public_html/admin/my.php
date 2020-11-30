<?php

require '../../bootloader.php';

if (is_logged_in()) {
    $user_key = is_logged_user();
    $rows = file_to_array(DB_FILE);

    $text = 'Welcome back,' . ' ' . '<span>' . $_SESSION['email'] . '</span>' .
        '. You have added ' . $rows['users'][$user_key]['items'] . ' items to your cart';
} else {
    header('Location: /login.php');
    exit();
}

$products = [];

foreach ($rows['items'] ?? [] as $items) {
    if ($items['email'] === $_SESSION['email']) {
        $products[] = $items;
    }
}

if (isset($_POST['id']) && $_POST['id'] == 'BUY') {
    foreach ($rows['users'][$user_key]['cart'] ?? [] as $items) {
        $rows['users'][$user_key]['purchased'][] = $items;

        foreach ($rows['users'] as $seller_key => $seller) {
            if ($items['email'] === $seller['email']) {
                $rows['users'][$seller_key]['items'] -= 1;
            }
        }

        unset($rows['users'][$user_key]['cart']);
    }

    foreach ($rows['items'] ?? [] as $key => $items) {
        for ($i = 0; $i < count($rows['users'][$user_key]['purchased']); $i++) {
            if ($rows['users'][$user_key]['purchased'][$i]['id'] === $items['id']) {
                unset($rows['items'][$key]);

                $rows['items'] = array_values($rows['items']);
                break;
            }
        }
    }

    array_to_file($rows, DB_FILE);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <title>Shop</title>
</head>
<body>
<main>
    <?php require ROOT . '/app/templates/nav.php'; ?>
    <article>
        <h3 class="index__h1"><?php print $text; ?></h3>
        <section class="index__section">
            <?php foreach ($products as $product) : ?>
                <div>
                    <h3><?php print $product['name']; ?></h3>
                    <img src="<?php print $product['image']; ?>" alt="">
                    <p><?php print $product['price']; ?>EUR</p>
                </div>
            <?php endforeach; ?>
        </section>
        <h4 class="index__h1">PURCHASED ITEMS:</h4>
        <section class="index__section">
            <?php foreach ($rows['users'][$user_key]['purchased'] ?? [] as $product) : ?>
                <div>
                    <h4><?php print $product['name']; ?></h4>
                    <img src="<?php print $product['image']; ?>" alt="">
                    <p><?php print $product['price']; ?> EUR</p>
                </div>
            <?php endforeach; ?>
        </section>
    </article>
</main>
</body>
</html>

