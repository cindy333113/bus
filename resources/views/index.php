<?php
foreach($stopList as $key => $stop){
    echo $stop['stop_name'].'<br>';
};
?>



 <?php //var_dump($rows) 
 //php -S localhost:8080 -t public public/index.php
 ?>

</table>
<!DOCTYPE html>

<html>




<?php ?>

<body class="page__login">
    <div class="wrapper">
        <div class="container">

            <div class="class__board">
                <div class="class__board_inner">
                    <div class="class__board_logo">
                        <h1 class="class__board_title">WEB Project</h1>
                    </div>

                    <p class="class__board_notice"> <?= $msg ?></p>

                    <div class="class__board_block">
                        <form class="class__form"  action="/login" method="post">
                            <div class="class__form_textField">
                                <label class="form__textField_label">使用者帳號</label>
                                <input type="text" name="account" placeholder="使用者帳號" required >
                            </div>
                            <div class="class__form_textField">
                                <label class="form__textField_label">使用者密碼</label>
                                <input type="password" name="password" placeholder="使用者密碼" required>
                            </div>
                            <div class="class__form_btn">
                                <button type="submit" class="btn submit__btn">登入</button>
                                <button type="button" class="btn general__btn" onclick="location.href='register.php'">註冊</button>
                                <p> hola </p>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>


</html>

