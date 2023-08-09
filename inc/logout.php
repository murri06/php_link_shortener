<?php
$domain = "https://murri.rf.gd/";

if (isset($_GET['submit'])) {
    session_start();
    session_destroy();
}
header("Location: $domain");
