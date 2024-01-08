<?php

// session_start();
$ses_id = (isset($_SESSION["ses_id"]) && $_SESSION['ses_id'] != '') ? $_SESSION["ses_id"] : "";
$ses_level = (isset($_SESSION["ses_level"]) && $_SESSION['ses_level'] != '') ? $_SESSION["ses_level"] : "";

// echo 
// '<script>
// alert ( "' . $ses_id . '" + ", " + "' . $ses_level . '");
// </script>
// ';

if ($ses_id == '' || $ses_level != 10) {
    die('
    <script>
        alert("관리자만 접근 가능합니다.");
        self.location.href = "../";
    </script>
');

}

?>