<?php
session_start();
include '../inc_common.php';
include '../../inc/dbconfig.php';
include '../../inc/board.php';  //게시판 클래스

$board_title = (isset($_POST['board_title']) && $_POST['board_title'] != '') ? $_POST['board_title'] : '';
$board_type = (isset($_POST['board_type']) && $_POST['board_type'] != '') ? $_POST['board_type'] : '';
$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';
$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';

if ($mode == '') {
    $arr = ["result" => "mode_empty"];
    die(json_encode($arr)); //{"result" : "enterkey"}
}


$board = new Board($db);

//게시판 생성 
if ($mode == 'input') {
    if ($board_title == '') {
        $arr = ["result" => "title_empty"];
        die(json_encode($arr));
    }
    if ($board_type == '') {
        $arr = ["result" => "btype_empty"];
        die(json_encode($arr));
    }


    //게시판 코드 생성
    $bcode = $board->bcode_create();

    //게시판 생성
    $arr = [
        'name' => $board_title,
        'btype' => $board_type,
        'bcode' => $bcode,
    ];
    $board->create($arr);
    $arr = ["result" => "success"];
    die(json_encode($arr));

} else if ($mode == "delete") {
    //게시판 삭제
    $board->delete($idx);
    $arr = ["result" => "success"];
    die(json_encode($arr));

} else if ($mode == "edit") {
    //게시판 수정
    if ($idx == '') {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }
    if ($board_title == '') {
        $arr = ["result" => "title_empty"];
        die(json_encode($arr));
    }

    $arr = [
        'name' => $board_title,
        'btype' => $board_type,
        'idx' => $idx,
    ];
     $board->update($arr);
     $arr = ["result" => "edit_success"];

} else if ($mode == "getInfo") {
    //게시판 정보 조회
    if ($idx == '') {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }
    $row = $board->getInfo($idx);

    $arr = ["result" => "success", "list" => $row];
    die(json_encode($arr));
}