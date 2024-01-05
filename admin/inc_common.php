<?php

if($ses_id != '' && $ses_level != 10){
die('
    <script>
        alert("관리자만 접근 가능합니다.");
        self.location.href = "../";
    </script>
');

}

?>