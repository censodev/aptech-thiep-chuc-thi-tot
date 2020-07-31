<?php
    require('./db.php');

    if ($_POST) {
        $DB = new DB();
        $uid = $_POST['uid'];
        $gift = $DB->assignGift(intval($uid));
        $img = '';
        switch ($gift['id']) {
            case 1: $img ='loa.png'; break;
            case 2: $img ='ban-phim.png'; break;
            case 3: $img ='ocam.png'; break;
            case 4: $img ='lot-chuot.png'; break;
            case 5: $img ='balo.png'; break;
            case 6: $img ='ao.png'; break;
            case 7: $img ='led.png'; break;
            case 8: $img ='keo.png'; break;
            case 9: $img ='bimbim.png'; break;
        }

        echo json_encode(['gift' => $gift['name'], 'img' => $img]);
        // return json_encode(['gift' => $gift]);
    }