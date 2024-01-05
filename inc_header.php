<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= (isset($g_title) && $g_title != '') ? $g_title : '네카라쿠배'; ?>
  </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>


  <?php
  //if (isset($js_Array)) {
  foreach ($js_array as $var) {
    echo '<script src="' . $var . '?v=' . date('YmdHis') . '"></script>' . PHP_EOL;
  }
  //}
  
  ?>



</head>

<body>

  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <img src="images/logo.svg" style="width: 2rem;" class="me-2">
        <span class="fs-4">네카라쿠배</span>
      </a>

      <?php if (isset($ses_id) && $ses_id != '') {
        //로그인 상태
        ?>
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="index.php" class="nav-link <?= ($menu_code == 'home') ? 'active' : ''; ?>"
              aria-current="page">Home</a></li>
          <li class="nav-item"><a href="compnay.php"
              class="nav-link <?= ($menu_code == 'compnay') ? 'active' : ''; ?>">회사소개</a></li>
          <?PHP
          if ($ses_level == 10) {
            ?>
            <li class="nav-item"><a href="admin/index.php" class="nav-link <?= ($menu_code == 'mypage') ? 'active' : ''; ?>">관리자 페이지</a></li>
          <?PHP
          } else {
            ?>
                 <li class="nav-item"><a href="mypage.php" class="nav-link <?= ($menu_code == 'mypage') ? 'active' : ''; ?>">My
                page</a></li>

          <?PHP
          }
          ?>
          <li class="nav-item"><a href="board.php"
              class="nav-link <?= ($menu_code == 'board') ? 'active' : ''; ?>">게시판</a></li>
          <li class="nav-item"><a href="./pg/logout.php"
              class="nav-link  <?= ($menu_code == 'logout') ? 'active' : ''; ?>">로그아웃</a></li>
        </ul>
        <?php
        //로그인 안된 상태
      } else {
        ?>
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="index.php" class="nav-link <?= ($menu_code == 'home') ? 'active' : ''; ?>"
              aria-current="page">Home</a></li>
          <li class="nav-item"><a href="compnay.php"
              class="nav-link <?= ($menu_code == 'compnay') ? 'active' : ''; ?>">회사소개</a></li>
          <li class="nav-item"><a href="stipulation.php"
              class="nav-link <?= ($menu_code == 'member') ? 'active' : ''; ?>">회원가입</a></li>
          <li class="nav-item"><a href="board.php"
              class="nav-link <?= ($menu_code == 'board') ? 'active' : ''; ?>">게시판</a></li>
          <li class="nav-item"><a href="login.php"
              class="nav-link  <?= ($menu_code == 'login') ? 'active' : ''; ?>">로그인</a></li>
        </ul>

        <?php
      }
      ?>



    </header>