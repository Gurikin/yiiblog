<?php use app\models\Comment;
use yii\helpers\Html;

foreach ($comments as $comment): ?>
    <div class="comment mb-3 col-12 justify-content-center" id="c<?php echo $comment->id; ?>">

        <div class="author">
            <b><?php echo $comment['author']; ?> says:</b>
        </div>

        <div class="time">
            <?php echo date('F j, Y \a\t h:i a', $comment->create_time); ?>
        </div>

        <div class="content">
            <?php echo nl2br(Html::encode($comment->content)); ?>
        </div>

    </div>

    <hr>
<?php endforeach; ?>