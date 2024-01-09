<?php
session_start();
print_r($_SESSION);


$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

$g_title = '네카라쿠배';
$js_array = ['js/member.js'];

$menu_code = 'board';
include 'inc_common.php';
include 'inc_header.php';
include '../inc/dbconfig.php';
include '../inc/board.php'; //게시판관리 class
// include '../inc/lib.php'; //페이지네이션


$sn = (isset($_GET['sn']) && $_GET['sn'] != '' && is_numeric($_GET['sn'])) ? $_GET['sn'] : '';
$sf = (isset($_GET['sf']) && $_GET['sf'] != '') ? $_GET['sf'] : '';


// $total, $limit, $page_limit, $page, $param


$board = new Board($db);

$boardArr = $board->list();
?>

<main class="border rounded-2 p-5 " style="height: calc(100vh - 257px)">


    <div>
        <h3>게시판 관리</h3>
    </div>

    <table class="table table-border">
        <tr>
            <th>번호</th>
            <th>이름</th>
            <th>게시판 코드</th>
            <th>게시판 종류</th>
            <th>게시물 갯수</th>
            <th>등록 일시</th>
        </tr>
        <?php
        foreach ($boardArr as $row) {

            ?>
            <tr>
                <td>
                    <?= $row['idx']; ?>
                </td>
                <td>
                    <?= $row['name']; ?>
                </td>
                <td>
                    <?= $row['bcode']; ?>
                </td>
                <td>
                    <?= $row['btype']; ?>
                </td>

                <td>
                    <?= $row['cnt']; ?>
                </td>
                <td>
                    <?= $row['create_at']; ?>
                </td>

            </tr>
            <?php
        }
        ?>
    </table>
    <!-- <div class="container mt-3 d-flex gab-2 w-50">
        <select class="form-select w-25" name="sn" id="sn">
            <option value="1">이름</option>
            <option value="2">아이디</option>
            <option value="3">이메일</option>
        </select>
        <input type="text" class="form-control w-25" id="sf" name="sf">
        <button class="btn btn-primary" id="btn_search">검색</button>
        <button class="btn btn-success" id="btn_all">전체목록</button>
    </div> -->

    <div class="d-flex mt-3 justify-content-between align-items-start">
        <button class="btn btn-primary btn-sm btn_mem_edit">게시판 생성</button>
    </div>
</main>
<?php
include 'inc_footer.php';

?>