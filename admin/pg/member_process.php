<?php
session_start();
include '../inc_common.php';
include '../../inc/dbconfig.php';
include '../../inc/member.php';

$mem = new Member($db);

$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';
$id = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$email = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email'] : '';
$password = (isset($_POST['pw1']) && $_POST['pw1'] != '') ? $_POST['pw1'] : '';
$name = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$zipcode = (isset($_POST['zipcode']) && $_POST['zipcode'] != '') ? $_POST['zipcode'] : '';
$addr1 = (isset($_POST['addr1']) && $_POST['addr1'] != '') ? $_POST['addr1'] : '';
$addr2 = (isset($_POST['addr2']) && $_POST['addr2'] != '') ? $_POST['addr2'] : '';
$level = (isset($_POST['level']) && $_POST['level'] != '') ? $_POST['level'] : '';

$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';


$old_photo = (isset($_POST['old_photo']) && $_POST['old_photo'] != '') ? $_POST['old_photo'] : '';
$photo = '';
if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {

    $new_photo = $_FILES['photo'];
    $old_photo = $mem->profile_upload($id, $new_photo, $old_photo); 

}

$arr = [
    'idx' => $idx,
    'id' => $id,
    'email' => $email,
    'password' => $password,
    'name' => $name,
    'zipcode' => $zipcode,
    'addr1' => $addr1,
    'addr2' => $addr2,
    'photo' => $old_photo,
    'level' => $level
];
$mem->edit($arr);

echo "
    <script>
    alert('수정되었습니다.');
    self.location.href='../index.php'
    </script>";
