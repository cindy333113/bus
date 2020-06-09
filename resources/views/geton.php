 <?php 

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
                        <h1 class="class__board_title">上車</h1>
                    </div>

                    <p class="class__board_notice"> <?= $msg ?></p>

                    <div class="class__board_block">
                        <form name="collectFrom" class="class__form"  action="/collect" method="post">
                            <div class="class__form_textField">
                                <label class="form__textField_label">站牌name</label>
                                <input type="text" name="stop_name" placeholder="站牌name" required >
                            </div>
                            <div class="class__form_textField">
                                <label class="form__textField_label">路線name</label>
                                <input type="text" name="route_name" placeholder="路線name" required >
                            </div>
                            <div class="class__form_textField">
                                <label class="form__textField_label">方向id</label>
                                <input type="text" name="direction" placeholder="方向id" required >
                            </div>
                            <div class="class__form_btn">
                                <button type="submit" class="btn submit__btn" onclick="collectFrom.action='/geton/add'">新增</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>

