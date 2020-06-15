<?php
require '../../templates/helper.php';

$db = setupDb();
if (!$db) {
    die('Could not load database!');
}

if (hasValue($_POST['first-name'])) {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $zipcode = $_POST['zipcode'];
    $hashedPw = hash('sha256', $password);

    if (hasValue($_POST['branch'])) {
        $sth = $db->prepare("INSERT INTO `users` (`email`, `branch`, `first_name`, `last_name`, `password`, `zipcode`) VALUES (?, ?, ?, ?, ?, ?)");
        $sth->execute([$email, $_POST['branch'], $first_name, $last_name, $hashedPw, $zipcode]);
    } else {
        $sth = $db->prepare("INSERT INTO `users` (`email`, `first_name`, `last_name`, `password`, `zipcode`) VALUES (?, ?, ?, ?, ?)");
        $sth->execute([$email, $first_name, $last_name, $hashedPw, $zipcode]);
    }
    if (!$sth) {
        echo 'Register failed';
    } else {
        echo 'Registered successfully';
    }
}

//print_r($_POST);