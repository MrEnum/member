<?php

// //db연결
// include 'inc/dbconfig.php';
// include 'inc/member.php';


// //아이디 중복 테스트

// $email = "kingchobo@naver.com";

// $mem = new Member($db);

// if ($mem->email_exists($email)) {
//     echo "이메일이 중복됩니다.";
// } else {
//     echo "사용할 수 있는 이메일입니다..";
// }

$_FILES['photo']['name'] = '2.jpg';
$id = 'zzz';
$arr = explode('.', $_FILES['photo']['name']);
$ext = end($arr);    // ['2','jpg']
$photo = $id . '.' . $ext;

echo $photo;