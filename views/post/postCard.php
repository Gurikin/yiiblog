<?php
use yii\helpers\Html;
use app\models\Tag;
use app\models\Post;
?>
<div class="org-pane animated bounceInUp delay-0.5s">
    <div class="org-head">
        <p><a href="/post/view?id=<?= Html::encode($model->id) ?>"><?= Html::encode($model->title) ?></a></p>
    </div>
    <div class="org-body align-self-stretch">
        <p class="text-truncate"><?= Html::encode($model->getAttributeLabel('title') . ': ' . $model->title) ?></p>
        <p class="text-truncate"><?= Html::encode($model->getAttributeLabel('content') . ': ' . $model->content) ?></p>
        <p class="text-truncate"><?= Html::encode($model->getAttributeLabel('tags') . ': ' . $model->tags) ?></p>
        <p class="text-truncate"><?= Html::encode($model->getAttributeLabel('create_time') . ': ' . \Yii::$app->formatter->asDatetime($model->create_time, "php:d-m-Y H:i:s")) ?></p>
        <p class="text-truncate"><?= Html::encode($model->getAttributeLabel('update_time') . ': ' . \Yii::$app->formatter->asDatetime($model->update_time, "php:d-m-Y H:i:s")) ?></p>
    </div>
    <div class="org-footer d-flex justify-content-end">
        <span class="mr-auto"><?= Html::encode($model->getAttributeLabel('status') . ": " . $model->status)?></span>
        <a href="/post/view?id=<?= Html::encode($model->id) ?>"
           class="btn btn-primary ml-auto align-right">Подробнее
        </a>
    </div>
</div>