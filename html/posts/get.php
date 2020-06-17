<?php
require '../../templates/helper.php';

$db = setupDb();
if (!$db) {
    die('Could not load database!');
}

if (hasValue($_GET['all'])) {
    $sth = $db->prepare("SELECT * FROM posts");
    $sth->execute();
    $passArr = $sth->fetchAll();

    foreach ($passArr as $value) {
        echo $value['post_id'] . '|' . $value['user_id'] . '|' . $value['title'] . '|' . $value['description'] . '|' . $value['upvotes'] . '|' . $value['downvotes'] . '|' . $value['branch'] . "<br>";
    }
}