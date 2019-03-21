<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Lookup;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    //====test block====//
    //    var_dump(Lookup::items('PostStatus'));
    //    var_dump(Lookup::item('PostStatus',Post::STATUS_PUBLISHED));
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'content:ntext',
            'tags:ntext',
            'status',
            //'create_time:datetime',
            //'update_time:datetime',
            //'author_id',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '<div class="d-flex justify-content-center">{view}</div>',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="more detail"
                                                            class="fa fa-eye"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('post/view', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'view'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                    }],
            ],
        ]]); ?>
    <?php Pjax::end(); ?>
</div>
