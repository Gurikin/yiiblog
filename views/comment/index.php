<?php

use app\models\Comment;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'content:ntext',
            'status',
            'create_time:datetime',
            'author',
            //'email:email',
            //'url:url',
//            'post_id' => [
//                    'header'=>'post',
//                    'data'=>$searchModel->post_id,
//            ],
            'actionColumn' => [
                'class' => ActionColumn::className(),
                'header' => 'Действия',
                'template' => '<div class="d-flex justify-content-center">{view}{update}{approve}{delete}</div>',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="more detail"
                                                            class="fa fa-eye"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('/comment/view', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'view'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="edit"
                                                            class="fa fa-pen"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('/comment/update', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'update'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => ($model['status'] == Comment::STATUS_APPROVED) ? 'btn-link disabled' : '',
                            ]);
                    },
                    'approve' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="approve"
                                                            class="fas fa-check"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('/comment/approve', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'approve'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => ($model['status'] == Comment::STATUS_APPROVED) ? 'btn-link disabled' : '',
                            ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="delete"
                                                            class="far fa-trash-alt"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('/comment/delete', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'delete'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                    },
                ]
            ]

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
