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
    <div class="col-4 wrap animated fadeIn delay-0.5s">
        <div id="sidebar">
            <?php if (!Yii::$app->user->isGuest) echo $this->render('..\portlets\user-menu'); ?>
        </div><!-- sidebar -->
        <div id="tag-cloud" class="d-flex justify-content-center align-items-baseline">
            <?php echo $this->render('..\portlets\tag-cloud');?>
        </div>
    </div>
</div>
