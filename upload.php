<?php

    $password = "csokertesi";

    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        header("Location: /?error=Incorrect request");
        die();
    }

    // Check if password is set and correct
    if (!isset($_POST['password']) || $_POST['password'] != $password) {
        header("Location: /?error=Incorrect password");
        die();
    }

    // Check if file is set
    if (!isset($_FILES['file'])) {
        header("Location: /?error=No file selected");
        die();
    }

    // Check if file is valid
    $file = $_FILES['file'];
    if ($file['error'] != 0) {
        header("Location: /?error=File error");
        die();
    }

    // Check if file already exists
    if (file_exists("./Exports/" . $file['name'])) {
        header("Location: /?error=File already exists");
        die();
    }

    // Move file to exports folder
    move_uploaded_file($file['tmp_name'], "./Exports/" . $file['name']);
    header("Location: /?success=File uploaded")
?>  