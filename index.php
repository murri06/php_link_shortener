<?php

namespace Acme;
require_once 'vendor/autoload.php';

$link = new Link();
$pdo = new Database('sql205.infinityfree.com', 'if0_34693072_php_link_shortener',
    'if0_34693072', 'EavByKrz0g');
$pdo->connect();
//if ($link->generateLink($pdo)) {
//    echo $link->getLinkShorter();
//}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Link Shortener</title>
    <link rel="icon" href="inc/icon-512.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="inc/styles.css">
</head>
<body>
<header>
    <div class="wrapper-header">
        <h2>PHP Link Shortener</h2>
    </div>

</header>
<main>
    <div>
        <div class="wrapper">
            <form method="post">
                <i class="bi bi-link-45deg"></i>
                <input type="text" id="longName" name="longLink" placeholder="Place your long link in here" required>
                <button>Shorten</button>
            </form>
        </div>
    </div>
    <div>
        <div class="wrapper">
            <div class="wrapper-urls">
                <div class="title">
                    <li>Shorten URL</li>
                    <li>Original URL</li>
                    <li>Clicks</li>
                    <li>Action</li>
                </div>
                <div class="data">
                    <?php foreach ($pdo->getAllData('links') as $link): ?>
                        <li><?= $link['shortLink'] ?></li>
                        <li><?= $link['longLink'] ?></li>
                        <li><?= $link['clicks'] ?></li>
                        <li>Delete</li>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>

</footer>
</body>
</html>
