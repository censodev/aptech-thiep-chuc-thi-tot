<?php
    require('./db.php');

    if (!isset($_GET['uid']))
        die;

    $mode = 'DEV';
    // $mode = 'PROD';

    $baseUrl = '';

    switch ($mode) {
        case 'PROD': 
            $baseUrl = 'https://aptechvietnam.com.vn';
            break;
        case 'DEV': 
            $baseUrl = 'http://'.$_SERVER['HTTP_HOST'].'/thiepchucthitot';
            break;
    }

    $uid = isset($_GET['uid']) ? $_GET['uid'] : '';
    $DB = new DB();
    $user = $DB->getUser($uid);
    $name = $user['sub_name'].' '.$user['name'];


    $submitUrl = $baseUrl.'/submit.php';

    $arr_loi_chuc = json_decode(file_get_contents("./assets/data/loichuc.json"));
    $loi_chuc = $arr_loi_chuc[rand(0, 23)]->content;

    $shared_link = $baseUrl.'?uid='.$uid;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aptech | Thiệp chúc thi tốt</title>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="d-flex flex-column align-items-center wrapper">
        <img class="mb-2 mt-4" src="./assets/img/logo.png" alt="">
        <div class="loi-chuc justify-content-center d-flex align-items-center mt-2">
            <p class="px-4 pt-2 pb-3 font-weight-bold text-center"><?php echo $loi_chuc ?></p>
        </div>
        <div class="hello">
            <h5 class="text-center">XIN CHÀO</h5>
            <h3 class="text-uppercase text-center m-0"><?php echo $name ?></h3>
        </div>
        <div class="bean-wrapper d-flex justify-content-center align-items-center mt-auto mb-4">
            <img class="bean mt-4" src="./assets/img/bean1.png" alt="">
        </div>
    </div>

    <div id="congratulation-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 d-flex flex-column align-items-center">

                <img src="./assets/img/logo.png" alt="">
                <div class="pt-5">
                    <h5 class="text-center text-gold">CHÚC MỪNG BẠN</h5>
                    <h3 class="text-uppercase text-center text-gold"><?php echo $name ?></h3>
                    <h5 class="text-center text-gold">NHẬN ĐƯỢC</h5>
                </div>
                <div class="my-2 congratulate-wrapper d-flex align-items-center justify-content-center w-100">
                    <img class="congratulate w-50" src="./assets/img/" alt="">
                </div>
                <div class="footer d-flex flex-column align-items-center">
                    <h5 class="gift-name text-gold text-center"></h5>
                    <p class="text-white text-center text-thin-svn">Chia sẻ với bạn bè để cùng tham gia nhé</p>
                    <div class="fb-share-button" data-href="<?php echo $shared_link ?>" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                </div>

            </div>
        </div>
    </div>

    <!-- FB SDK -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v7.0&appId=316431589407979&autoLogAppEvents=1" nonce="POOuLbCt"></script>

    <!-- JQUERY BS4 -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
    <!-- SCRIPT -->
    <script>
        let count = 0;
        document.querySelector('.bean').addEventListener('click', e => {
            const img = e.target;
            switch(count) {
                case 0:
                    img.src = img.src.replace('bean1.png', 'bean2.png');
                    break;
                case 1:
                    img.src = img.src.replace('bean2.png', 'bean3.png');
                    break;
                case 2:
                    getGift(<?php echo $uid ?>)
                    break;
                default:
                    return;
            }
            count++;
        })

        function getGift(uid) {
            $.ajax({
                url: '<?php echo $submitUrl ?>',
                type: 'POST',
                dataType: 'json',
                data: { uid: uid },
                beforeSend: function() { loadSpinner() },
                success: function(res) { congratulate(res) },
                error: function(err) { console.log(err) }
            })
        }

        function congratulate(rs) {
            console.log(rs)
            const congratulate = document.querySelector('.congratulate');
            congratulate.src = congratulate.src + rs.img;
            document.querySelector('.gift-name').innerHTML = rs.gift;
            $('#congratulation-modal').modal('show');
        }

        function loadSpinner() {

        }

        function endSpinner() {

        }
        
    </script>
</body>
</html>