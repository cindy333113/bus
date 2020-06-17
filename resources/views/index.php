<?php

?>

<!DOCTYPE html>

<html>

<body class="page__login">
    <div class="wrapper">
        <div class="container">

            <div class="class__board">
                <div class="class__board_inner">
                    <div class="class__board_logo">
                        <h1 class="class__board_title">WEB Project</h1>
                    </div>

                    <div class="class__board_block">
                        <h3> <?= $msg??'' ?>歡迎來到首頁 繼續嘗試其他功能？</h3>
                        <div class="class__form_btn">
                            <button type="button" class="btn general__btn" onclick="location.href='/login'">前往登入</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>