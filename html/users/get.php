<?php
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

}

print_r($_POST);