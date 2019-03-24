<?php

use app\models\Comment;
use yii\web\Controller;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'content:ntext',
            'tags:ntext',
            'status',
            'create_time:datetime',
            'update_time:datetime',
            'author_id',
        ],
    ]) ?>

    <div id="comments" class="d-flex justify-content-between">
        <div id="comments-view" class="ml-auto mr-auto">
            <?php if ($model->getCommentCount() >= 1): ?>
                <h3>
                    <?= $model->commentCount . ' comment(s)' ?>
                </h3>
                <?php
                echo $this->render('_comments', [
                    'post' => $model,
                    'comments' => $model->comments,
                ]);
                ?>
            <?php endif; ?>
        </div><!--comments-view-->

        <div id="comments-form"class="ml-auto">
            <h3>Оставить комментарий</h3>

            <?php if (Yii::$app->session->hasFlash('commentSubmitted')): ?>
                <div class="flash-success">
                    <?php echo Yii::$app->session->getFlash('commentSubmitted'); ?>
                </div>
            <?php else: ?>
                <?php echo $this->render('/comment/_form', [
                    'model' => (new Comment()),
                ]); ?>
            <?php endif; ?>

        </div><!-- comments-form -->
    </div>
</div>
