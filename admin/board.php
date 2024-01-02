<?php
session_start();
print_r($_SESSION);


$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

$g_title = '네카라쿠배';
$js_array = ['js/board.js'];

$menu_code = 'board';
include 'inc_common.php';
include 'inc_header.php';
include '../inc/dbconfig.php';
include '../inc/board.php'; //게시판관리 class
// include '../inc/lib.php'; //페이지네이션


$sn = (isset($_GET['sn']) && $_GET['sn'] != '' && is_numeric($_GET['sn'])) ? $_GET['sn'] : '';
$sf = (isset($_GET['sf']) && $_GET['sf'] != '') ? $_GET['sf'] : '';

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
                <td><button class="btn btn-primary btn-sm btn_mem_edit" data-idx="<?=$row['idx']?>">수정</button>
                    <button class="btn btn-danger btn-sm btn_mem_delete" data-idx="<?=$row['idx']?>">삭제</button>
                    <!-- onclick으로 구현하는게 쉬운방법이긴하나 이 방법이 깔끔함-->
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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#board_create_modal">게시판 생성</button>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="board_create_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">게시판 생성</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex gab-2">
                <input type="text" id="board_title" class="form-control" placeholder="게시판 이름">
                <select name="" id="board_type" class="form-select">
                    <option value="board">게시판</option>
                    <option value="gallery">갤러리</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" id="btn_board_create">확인</button>
            </div>
        </div>
    </div>
</div>
<?php
include 'inc_footer.php';

?>