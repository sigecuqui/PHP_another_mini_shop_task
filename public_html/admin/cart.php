<?php
require '../../bootloader.php';

if (is_logged_in()) {
    $user_key = is_logged_user();
    $rows = file_to_array(DB_FILE);

    if (isset($_POST['id'])) {
        foreach ($rows['items'] ?? [] as $key => $items) {
            if ($items['id'] == $_POST['id']) {
                $rows['users'][$user_key]['cart'][] = $items;
                $rows['items'][$key]['disabled'] = 'true';
            }
        }

        array_to_file($rows, DB_FILE);
    }
    $products = $rows['users'][$user_key]['cart'] ?? [];

    $total_price = 0;

    foreach ($products as $product) {
        $total_price += $product['price'];
    }


    $text = 'This is your cart,' . ' ' . '<span>' . $_SESSION['email'] . '</span>';
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
    <link rel="stylesheet" href="../css/style.css">
    <title>Shop</title>
</head>
<body>
<?php include(ROOT . '/app/templates/nav.php'); ?>
<main>
    <article>
        <h3 class="index__h1"><?php print $text; ?></h3>
        <section class="index__section">
            <?php if ($products == []): ?>
                <h2>List is empty</h2>
            <?php else: ?>
                <?php foreach ($products as $product) : ?>
                    <div>
                        <h3><?php print $product['name']; ?></h3>
                        <img src="<?php print $product['image']; ?>" alt="image">
                        <p><?php print $product['price']; ?> EUR</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <div>
            <h3 class="total_price">Total price: <?php print $total_price; ?> EUR</h3>
            <form method="POST" action="/admin/my.php">
                <input type="hidden" name="id" value="BUY">
                <button class="btn" type="submit">Checkout</button>
            </form>
        </div>
    </article>
</main>
</body>
</html>
