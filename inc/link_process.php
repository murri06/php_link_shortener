<?php

namespace Acme;

session_start();
$pdo = new Database('sql205.infinityfree.com', 'if0_34693072_php_link_shortener',
    'if0_34693072', 'EavByKrz0g');
$pdo->connect();
if (isset($_POST['submit'])) {
    if (filter_var($_POST['longLink'], FILTER_VALIDATE_URL)) {
        $longLink = filter_input(INPUT_POST, 'longLink', FILTER_SANITIZE_URL);
        $link = new Link($longLink);
        while (!$link->generateLink($pdo)) ;
        if ($pdo->insertLinkData($link->getLinkShorter(), $link->getLinkDefault(), '0')) {
            $_SESSION['short'] = $link->getLinkShorter();
            header('Location: /index.php');
        } else echo 'Something went wrong...';
    } else header('Location: /index.php?e=0');
}