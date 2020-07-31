<?php
    require('./db.php');

    if ($_POST) {
        $DB = new DB();
        $uid = $_POST['uid'];
        $gift = $DB->assignGift(intval($uid));
        echo json_encode(['gift' => $gift['name'], 'img' => $gift['img']]);
    }