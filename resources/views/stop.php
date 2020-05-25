<?php



?>

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
                        <form name="stopFrom" class="class__form"  action="/stop" method="post">
                            <div class="class__form_textField">
                                <label class="form__textField_label">站牌id</label>
                                <input type="text" name="STOP_ID" placeholder="站牌ID" required >
                            </div>
                            <div class="class__form_textField">
                                <label class="form__textField_label">站牌名稱</label>
                                <input type="text" name="STOP_NAME" placeholder="站牌名稱" required>
                            </div>
                            <div class="class__form_btn">
                                <button type="submit" class="btn submit__btn" onclick="stopFrom.action='/stop/add'">新增</button>
                                <button type="submit" class="btn submit__btn" onclick="stopFrom.action='/stop/update'">修改</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>

