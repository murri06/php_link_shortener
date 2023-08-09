<?php
$domain = "https://murri.rf.gd/";

if (isset($_POST['submit'])) {
    session_start();
    session_destroy();
}
header("Location: $domain");
