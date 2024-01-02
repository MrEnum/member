<?php
include '../inc/dbconfig.php';
include '../inc/member.php';

$mem = new Member($db);

$id = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$email = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email'] : '';
$password = (isset($_POST['pw1']) && $_POST['pw1'] != '') ? $_POST['pw1'] : '';
$name = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$zipcode = (isset($_POST['zipcode']) && $_POST['zipcode'] != '') ? $_POST['zipcode'] : '';
$addr1 = (isset($_POST['addr1']) && $_POST['addr1'] != '') ? $_POST['addr1'] : '';
$addr2 = (isset($_POST['addr2']) && $_POST['addr2'] != '') ? $_POST['addr2'] : '';

$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';

//id중복체크
if ($mode == 'id_chk') {
    if ($id == '') {
        die(json_encode(['result' => 'empty_id']));
    }

    if ($mem->id_exists(trim($id))) {
        die(json_encode(['result' => 'fail']));
    } else {
        die(json_encode(['result' => 'success']));
    }

    //이메일 중복체크
} else if ($mode == 'email_chk') {

    if ($email == '') {
        die(json_encode(['result' => 'empty_email']));
    }

    //이메일 형식 확인
    if($mem->email_format_check($email) === false){
        die(json_encode(['result'=> 'email_format_wrong']));
    }

    if ($mem->email_exists(trim($email))) {
        die(json_encode(['result' => 'fail']));
    } else {
        die(json_encode(['result' => 'success']));
    }

} else if ($mode == 'input') {
    //profile image 처리
    $temparr = explode('.', $_FILES['photo']['name']);    // ['2','jpg']
    $ext = end($temparr);    // ['2','jpg']

    $photo = $id . '.' . $ext;

    copy($_FILES['photo']['tmp_name'], "../data/profile/" . $photo);
    $arr = [
        'id' => $id,
        'email' => $email,
        'password' => $password,
        'name' => $name,
        'zipcode' => $zipcode,
        'addr1' => $addr1,
        'addr2' => $addr2,
        'photo' => $photo
    ];
    $mem->input($arr);

    echo "
    <script>
    self.location.href='../member_success/php'
    </script>";
}


