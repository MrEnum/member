<?php

$servername = 'localhost'; // 웹서버와 db서버가 한 컴퓨터에 있음을 의미
$dbuser = 'root';
$dbpassword = '1111';
$dbname = 'memsite';


try {
    $db = new PDO("mysql:host={$servername}; dbname={$dbname}", $dbuser, $dbpassword);

    //Prepared Statement를 지원하지 않는 경우 데이터베이스의 기능을 사용하도록 해줌
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); //쿼리 버퍼링을 활성화
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //PDO객체가 에러를 처리하는 방식 정함
    //echo "DB 연결 성공";
} catch (PDOException $e) {
    echo $e->getMessage();
}

define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT'] . '/project/member');
define('ADMIN_DIR', DOCUMENT_ROOT . '/admin');
define('DATA_DIR', DOCUMENT_ROOT . '/data');
define('PROFILE_DIR', DATA_DIR . '/profile');
define('BOARD_DIR', DATA_DIR . '/board');
define('BOARD_WEB_DIR', 'data/board');



