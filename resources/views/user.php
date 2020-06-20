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

                    <form action="/logout" method="post">
                        <div class="class__board_block">
                            <h3>使用者資訊</h3>
                            <div class="class__text">
                                <?php $identity = strtolower($_SESSION['auth']['identity']); ?>
                                <p>乘客ID:<?= $user["{$identity}_id"]??'' ?></p>
                                <p>乘客帳號:<?= $user["{$identity}_account"]??'' ?></p>
                                <p>乘客姓名:<?= $user["{$identity}_name"]??'' ?></p>
                            </div>
                            <button type="submit">登出</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>