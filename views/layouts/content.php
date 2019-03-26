<?php
use yii\widgets\Pjax;
?>
<div class="container d-flex">
    <div class="col-8">
        <div id="content">
            <?php
                echo ($content);
            ?>
        </div><!-- content -->
    </div>
    <div class="col-4 animated fadeIn delay-0.5s">
        <div id="sidebar">
            <?php if (!Yii::$app->user->isGuest) echo $this->render('../userMenu'); ?>
        </div><!-- sidebar -->
    </div>
</div>
