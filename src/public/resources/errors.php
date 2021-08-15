<?php

if (array_key_exists('errors', $_GET)) {
    if (is_array($_GET['errors'])) {
        echo "<div class='alert alert-danger'>" . implode("<br>", $_GET['errors']). "</div>";
    }
}
