<?php

namespace Acme;
require_once 'vendor/autoload.php';
session_start();

$pdo = new Database('sql205.infinityfree.com', 'if0_34693072_php_link_shortener',
    'if0_34693072', 'EavByKrz0g');
$pdo->connect();
$domain = "https://murri.rf.gd/";

if (isset($_POST['submit'])) {
    if (filter_var($_POST['longLink'], FILTER_VALIDATE_URL)) {
        $longLink = filter_input(INPUT_POST, 'longLink', FILTER_SANITIZE_URL);
        $link = new Link($longLink);
        while (!$link->generateLink($pdo)) ;
        if ($pdo->insertLinkData($link->getLinkShorter(), $link->getLinkDefault(), '0')) {
            $_SESSION['short'] = $link->getLinkShorter();
            header("Location: $domain");
        } else echo 'Something went wrong...';
    } else header("Location: $domain?e=0");
}

if (isset($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($pdo->deleteQuery('links', $id)) {
        header("Location: $domain");
    }
}

if (isset($_GET['e']))
    switch ($_GET['e']) {
        case 0:
            $err = 'Its not a link!';
            break;
        case 1:
            $usernameErr = 'That login is occupied, please choose another!';
            break;
        case 2:
            $passwordErr = 'Passwords does not matches!';
            break;
        case 3:
            $success = 'Now you can login into your account!';
            break;
        case 4:
            $passwordErr = 'Something went wrong, please try again later!';
            break;
        case 5:
            $loginErr = 'Login and password does not matches!';
            break;
    }

if (isset($_GET['u'])) {
    $u = filter_input(INPUT_GET, 'u', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $res = $pdo->getLongLink($u);
    if (isset($res['longLink'])) {
        $pdo->updateClicks($u);
        header("Location: " . $res['longLink']);
    } else $err = 'This link is not valid';
}

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
        <?php if (isset($_SESSION["username"])): ?>
            <form action="inc/logout.php" method="post">
                <button type="submit" name="submit">Logout</button>
            </form>
        <?php endif; ?>
    </div>

</header>
<main>
    <?php if (isset($_SESSION["username"])): ?>
        <div>
            <div class="wrapper">
                <form method="post" class="form-shortener">
                    <i class="bi bi-link-45deg"></i>
                    <input type="text" id="longName" name="longLink" placeholder="Place your long link in here"
                           required>
                    <button name="submit" type="submit">Shorten</button>
                </form>
                <?php if (isset($err)) : ?>
                    <label class="error"><?= $err ?></label>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <div class="wrapper">
                <div class="header-update">
                    <h3>List of links</h3>
                    <button class="update-btn" onclick="refreshPage()"><i class="bi bi-arrow-repeat"></i></button>
                </div>
                <div class="wrapper-urls">
                    <div class="title">
                        <li>Shorten URL</li>
                        <li>Original URL</li>
                        <li>Clicks</li>
                        <li>Action</li>
                    </div>

                    <?php
                    foreach ($pdo->getAllData('links') as $link):
                        ?>
                        <div class="data">
                            <li><a href="<?= $domain . '?u=' . $link['shortLink'] ?>"
                                   target="_blank"><?= $domain . '?u=' . $link['shortLink'] ?></a></li>
                            <li><a href="<?= $link['longLink'] ?>" target="_blank">
                                    <?php
                                    if (strlen($link['longLink']) > 60) {
                                        echo substr($link['longLink'], 0, 50) . '...';
                                    } else {
                                        echo $link['longLink'];
                                    } ?></a></li>
                            <li><?= $link['clicks'] ?></li>
                            <li>
                                <form method="post" class="form-delete">
                                    <button name="submit" type="submit"><i class="bi bi-trash-fill"
                                                                           onclick="return confirm('Are you sure you want to delete this link?')"></i>
                                    </button>
                                    <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                </form>
                            </li>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="popup-box">
            <div class="info">
                <h3>here is your shorten link</h3>
                <input type="text" readonly
                       value="<?php if (isset($_SESSION['short'])) echo $domain . '?u=' . $_SESSION['short'] ?>">
            </div>
        </div>
    <?php
    else:?>
        <div class="login-register-form">
            <div class="login-wrapper">
                <h3>Login</h3>
                <form action="inc/login.php" method="post">
                    <input type="text" name="username" required placeholder="login">
                    <input type="password" name="password" required placeholder="password">
                    <div class="btn-container">
                        <?php if (isset($loginErr)) : ?>
                            <label><?= $loginErr ?></label>
                        <?php endif; ?>
                        <button type="submit" name="login">Login</button>
                    </div>
                </form>
            </div>
            <div class="login-wrapper">
                <h3>Register</h3>
                <form action="inc/login.php" method="post">
                    <input type="text" name="username" required placeholder="login">
                    <?php if (isset($usernameErr)) : ?>
                        <label class="error"><i class="bi bi-exclamation-triangle-fill"></i><?= $usernameErr ?></label>
                    <?php endif; ?>
                    <input type="password" name="password" required placeholder="password">
                    <input type="password" name="passwordRepeat" required placeholder="repeat password">
                    <?php if (isset($passwordErr)) : ?>
                        <label class="error"><i class="bi bi-exclamation-triangle-fill"></i><?= $passwordErr ?></label>
                    <?php endif; ?>
                    <div class="btn-container">
                        <?php if (isset($success)) : ?>
                            <label><?= $success ?></label>
                        <?php endif; ?>
                        <button type="submit" name="register">Register</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</main>
<footer>

</footer>

<script>
    function refreshPage() {
        location.reload();
    }
</script>
</body>
</html>
