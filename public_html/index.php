<?php

require '../bootloader.php';

$db_data = file_to_array(DB_FILE);
$number = count($db_data['items'] ?? []);
$list = "$number items in this shop";
$products = $db_data['items'] ?? [];

if (is_logged_in()) {
    $products = [];

    foreach ($db_data['items'] ?? [] as $item) {
        if ($item['email'] !== $_SESSION['email']) {
            $products[] = $item;
        }
    }
    $number = count($products ?? []);
    $list = "$number items in this shop";
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include(ROOT . '/app/templates/nav.php'); ?>
<main>
    <h1 class="index__h1">Welcome to BBZ shop</h1>
    <h2><?php print $list; ?></h2>
    <section class="index__section">
        <?php foreach ($products as $item): ?>
            <div>
                <img src="<?php print $item['image']; ?>" alt="item image">
                <div class="bottom_product">
                    <h3><?php print $item['name']; ?></h3>
                    <p><?php print $item['price']; ?> EUR</p>
                    <p>Contact seller: <?php print $item['contact']; ?></p>
                    <?php if (is_logged_in()) : ?>
                        <form method="POST" action="/admin/cart.php">
                            <input type="hidden" name="id" value="<?php print $item['id']; ?>">
                            <button class="btn" type="submit">Add to cart</button>
                        </form>
<!--                        <form method="POST" action="/pvm.php">-->
<!--                            <input type="hidden" name="id" value="--><?php //print $item['id']; ?><!--">-->
<!--                            <button type="submit">Buy this thing</button>-->
<!--                        </form>-->
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>
</body>
</html>

