<?php
$err_array = error_get_last();
$a = (int) ini_get('post_max_size');


if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > (int) ini_get('post_max_size') * 1024 * 1024) {
    $arr = ['result' => 'post_size_exceed'];
    die(json_encode($arr));
}


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
        list(, $ext) = explode('/', $type);
        $ext = ($ext == 'jpeg') ? 'jpg' : $ext;

        $filename = date('YmdHis') . '_' . $key . "." . $ext;
        file_put_contents(BOARD_DIR . '/' . $filename, $data);

        $content = str_replace($row, BOARD_WEB_DIR . "/" . $filename, $content);
        $img_array[] = BOARD_WEB_DIR . '/' . $filename;
    }


    if ($subject == '') {
        die(json_encode(["result" => "empty_subject"]));
    }
    if ($content == '' || $content == '<p><br></p>') {
        die(json_encode(["result" => "empty_content"]));
    }

    // 파일첨부
    //$_FILES[]
    if (isset($_FILES['files']) && $_FILES['files']['name'] != '') {
        if (sizeof($_FILES['files']['name']) > 3) {
            $arr = ["result" => "file_upload_count_exceed"];
        }
        $tmp_arr = [];
        foreach ($_FILES['files']['name'] as $key => $val) {
            $full_str = '';

            $tmparr = explode('.', $_FILES['files']['name'][$key]);
            $ext = end($tmparr);

            $not_arrowed_file_ext = ['txt', 'exe', 'xls'];

            if (in_array($ext, $not_arrowed_file_ext)) {
                $arr = ['result' => 'not_allowed_file'];
                die(json_encode($arr));
            }


            $flag = rand(1000, 9999);
            $filename = 'a' . date('YmdHis') . $flag . '.' . $ext;
            $file_ori = $_FILES['files']['name'][$key];

            copy($_FILES['files']['tmp_name'][$key], BOARD_DIR . "/" . $filename);

            $full_str = $filename . '|' . $file_ori;
            $tmp_arr[] = $full_str;
        }
        $file_list_str = implode('?', $tmp_arr);
    }


    $memArr = $member->getInfo($ses_id);
    $name = $memArr['name'];
    $arr = [
        'bcode' => $bcode,
        'id' => $ses_id,
        'name' => $name,
        'subject' => $subject,
        'content' => $content,
        'files' => $file_list_str,
        'ip' => $_SERVER['REMOTE_ADDR']
    ];

    $board->input($arr);
    die(json_encode(["result" => "success"]));
}
