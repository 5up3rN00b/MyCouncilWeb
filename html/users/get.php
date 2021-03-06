<?php
require '../../templates/helper.php';

$db = setupDb();
if (!$db) {
    die('Could not load database!');
}

if (hasValue($_POST['email']) && hasValue($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sth = $db->prepare("SELECT * FROM `users` WHERE `email`=?");
    $sth->execute([$email]);
    $passArr = $sth->fetchAll();

    if (hash('sha256', $password) == $passArr[0]['password']) {
        if ($passArr[0]['branch'] == 'None') {
            echo 'Citizen' . ':' . $passArr[0]['user_id'] . ':' . $email . ':' . $passArr[0]['first_name'] . ':' . $passArr[0]['last_name'] . ':' . $passArr[0]['zipcode'];
        } else {
            echo 'Leader' . ':' . $passArr[0]['user_id'] . ':' . $email . ':' . $passArr[0]['branch'] . ':' . $passArr[0]['first_name'] . ':' . $passArr[0]['last_name'] . ':' . $passArr[0]['zipcode'];
        }
    } else {
        if (empty($passArr)) {
            echo 'Email does not exist';
        } else {
            echo 'Login failed';
        }
    }
} else {
    if (hasValue($_GET['id'])) {
        $id = $_GET['id'];

        $sth = $db->prepare("SELECT * FROM `users` WHERE `user_id`=?");
        $sth->execute([$id]);
        $passArr = $sth->fetchAll();

        echo $passArr[0]['first_name'] . ' ' . $passArr[0]['last_name'];
    }

    if (hasValue($_GET['all'])) {
        $sth = $db->prepare("SELECT * FROM `users`");
        $sth->execute();
        $passArr = $sth->fetchAll();

        foreach ($passArr as $value) {
            echo $value['user_id'] . '|' . $value['first_name'] . ' ' . $value['last_name'] . '<br>';
        }
    }

    // TODO Add other get methods
}

//print_r($_POST);