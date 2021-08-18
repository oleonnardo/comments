<?php
session_start();

require_once __DIR__ . base64_decode($_GET['vendor']);

if (array_key_exists('url', $_GET)) {
    $_SESSION['pageUrl'] = base64_decode($_GET['url']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leonardo Comments</title>
    <link href="assets/css/comments-plugin.css" rel="stylesheet" type="text/css">
</head>
<body>

    <?php
    include_once 'resources/errors.php';
    include_once 'resources/form.php';
    include_once 'resources/comentarios.php';
    ?>

    <script src="assets/plugins/ckeditor/ckeditor.js"></script>
    <script src="assets/js/comments-plugins.js"></script>
</body>
</html>
