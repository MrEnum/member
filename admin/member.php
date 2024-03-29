<?php
session_start();
print_r($_SESSION);


$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

$g_title = '네카라쿠배';
$js_array = ['js/member.js'];

$menu_code = 'member';
include 'inc_common.php';
include 'inc_header.php';
include '../inc/dbconfig.php';
include '../inc/member.php'; //회원관리 class
include '../inc/lib.php'; //페이지네이션


$sn = (isset($_GET['sn']) && $_GET['sn'] != '' && is_numeric($_GET['sn'])) ? $_GET['sn'] : '';
$sf = (isset($_GET['sf']) && $_GET['sf'] != '') ? $_GET['sf'] : '';


// $total, $limit, $page_limit, $page, $param


$mem = new Member($db);

$paramArr = ['sn'=> $sn, 'sf'=>$sf];
$total = $mem->total($paramArr);

$limit = 5;
$page_limit = 5;
$page = (isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

$param = '';


$memArr = $mem->list($page, $limit, $paramArr);
?>

<main class="border rounded-2 p-5 " style="height: calc(100vh - 257px)">


    <div>
        <h3>회원관리</h3>
    </div>

    <table class="table table-border">
        <tr>
            <th>번호</th>
            <th>아이디</th>
            <th>이름</th>
            <th>이메일</th>
            <th>등록일시</th>
            <th>관리</th>
        </tr>
        <?php
        foreach ($memArr as $row) {

            ?>
            <tr>
                <td>
                    <?= $row['idx']; ?>
                </td>
                <td>
                    <?= $row['id']; ?>
                </td>
                <td>
                    <?= $row['name']; ?>
                </td>
                <td>
                    <?= $row['email']; ?>
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
    <div class="container mt-3 d-flex gab-2 w-50">
        <select class="form-select w-25" name="sn" id="sn">
            <option value="1">이름</option>
            <option value="2">아이디</option>
            <option value="3">이메일</option>
        </select>
        <input type="text" class="form-control w-25" id="sf" name="sf">
        <button class="btn btn-primary" id="btn_search">검색</button>
        <button class="btn btn-success" id="btn_all">전체목록</button>
    </div>

    <div class="d-flex mt-3 justify-content-between align-items-start">
        <?php
        $param = '&sn='.$sn.'&sf='.$sf;
        echo my_pagination($total, $limit, $page_limit, $page, $param);
        ?>
        <button class="btn btn-primary" id="btn_excel">엑셀로 저장</button>
    </div>
</main>
<?php
include 'inc_footer.php';

?>