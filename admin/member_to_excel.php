<?php
include '../inc/dbconfig.php';
include '../inc/member.php';
include './inc_common.php';
$mem = new Member($db);
$rs = $mem->getAllData();

//1. header().....
//엑셀 파일을 쉽게 만들어주는 api
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=member.xls");
header("Content-Description:PHP8 Generated Data");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .title {
            font-size: 25px;
            text-align: center;
            font-weight: 900;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="6" align="center">회원 목록</td>
        </tr>
        <table border="1">
            <tr>
                <th>아이디</th>
                <th>이름</th>
                <th>이메일</th>
                <th>주소</th>
                <th>등록일시</th>
            </tr>
            <?php
            foreach ($rs as $row) {
                echo '
    <tr>
    <td>' . $row['id'] . '</td>
    <td>' . $row['name'] . '</td>
    <td>' . $row['email'] . '</td>
    <td>' . $row['zipcode'] . '</td>
    <td>' . $row['addr1'] . '</td>
    <td>' . $row['create_at'] . '</td>
    </tr>'
                ;

            }
            ?>

        </table>
</body>

</html>

<head>

</head>