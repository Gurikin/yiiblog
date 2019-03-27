<?php
use app\models\helpers\Util;
use app\widgets\RecentComments;

$userMenuPath = Util::file_build_path('..','portlets','user-menu');
$tagCloudPath = Util::file_build_path('..','portlets','tag-cloud');
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
            <?php if (!Yii::$app->user->isGuest) echo $this->render($userMenuPath); ?>
        </div><!-- sidebar -->
        <div id="tag-cloud" class="d-flex justify-content-center align-items-baseline">
            <?php echo $this->render($tagCloudPath);?>
        </div><!-- tab-cloud -->
        <div id="recent-comments" class="">
            <h5>Recent comments:</h5>
            <?php echo RecentComments::widget([]);?>
        </div><!-- tab-cloud -->
    </div>
</div>
