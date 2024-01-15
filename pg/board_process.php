<?php
include '../inc/dbconfig.php';
include '../inc/board.php'; //게시판 class
include '../inc/member.php'; //회원 class
include '../inc/common.php';


$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';
$bcode = (isset($_POST['bcode']) && $_POST['bcode'] != '') ? $_POST['bcode'] : '';
$subject = (isset($_POST['subject']) && $_POST['subject'] != '') ? $_POST['subject'] : '';
$content = (isset($_POST['content']) && $_POST['content'] != '') ? $_POST['content'] : '';


$board = new Board($db);
$member = new Member($db);

if ($mode == '') {
    $arr = ["result" => "empty_mode"];
    $json_str = json_encode($arr);
    die($json_str);
}
if ($bcode == '') {
    $arr = ["result" => "empty_mode"];
    $json_str = json_encode($arr);
    die($json_str);
}



if ($mode == "input") {
    //이미지 변환하여 저장하기
    preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);


    //data:image/png;base64, ivckksocooccksockckkcosAAiaDFKLVIDkls
    $img_array = [];
    // echo '<script>alert("뽀이치 들어가기 직전");</script>';
    foreach ($matches[1] as $key => $row) {
        if (substr($row, 0, 5) != 'data:') {
            continue;
        }
        //data:image/png;base64, ivckksocooccksockckkcosAAiaDFKLVIDkls
        list($type, $data) = explode(';', $row);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        list(,$ext) = explode('/', $type);
        $ext = ($ext == 'jpeg') ? 'jpg' : $ext;

        $filename = date('YmdHis') . '_' . $key . "." . $ext;
        file_put_contents(BOARD_DIR . '/' . $filename, $data);

        $content = str_replace($row, BOARD_WEB_DIR."/". $filename, $content);
        $img_array[] = BOARD_WEB_DIR . '/' . $filename;
    }


    if ($subject == '') {
        die(json_encode(["result" => "empty_subject"]));
    }
    if ($content == '' || $content == '<p><br></p>') {
        die(json_encode(["result" => "empty_content"]));
    }


    $memArr = $member->getInfo($ses_id);
    $arr = [
        'bcode' => $bcode,
        'id' => $ses_id,
        'name' => $memArr['name'],
        'subject' => $subject,
        'content' => $content,
        'ip' => $_SERVER['REMOTE_ADDR']
    ];

    $board->input($arr);
    die(json_encode(["result" => "success"]));
}