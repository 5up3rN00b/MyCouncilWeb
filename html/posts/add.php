<?php
require '../../templates/helper.php';

$db = setupDb();
if (!$db) {
    die('Could not load database!');
}

if (hasValue($_POST['user-id'])) {
    $user_id = $_POST['user-id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $upvotes = $_POST['upvotes'];
    $downvotes = $_POST['downvotes'];

    execSql($db, "START TRANSACTION;");

    $sth = $db->prepare("INSERT INTO `posts` (`user_id`, `title`, `description`, `upvotes`, `downvotes`) VALUES (?, ?, ?, ?, ?)");
    $sth->execute([$user_id, $title, $description, $upvotes, $downvotes]);

    $sth = $db->prepare("SELECT LAST_INSERT_ID();");
    $sth->execute();
    $passArr = $sth->fetchAll();

    echo $passArr[0][0];

    execSql($db, "COMMIT;");
}