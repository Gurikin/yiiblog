<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
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

    <?php if(!empty($_GET['tag'])): ?>
        <h1>Записи с тегом <i><?php echo Html::encode($_GET['tag']); ?></i></h1>
    <?php endif; ?>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $columns = 3;
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}<div class="col-12">{pager}</div>',
        'itemOptions' => ['class' => "col-lg-6 col-md-6 col-xs-10 org-cont"],
        'itemView' => 'postCard',
        'options' => ['class' => 'container d-flex flex-wrap align-items-stretch justify-content-between'],
        'pager' => [
            'options' => [
                'tag' => 'div',
                'class' => 'pagination',
                'id' => 'pager-container',
            ],
            'linkOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '<span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>',
            'nextPageLabel' => '<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>',
            'activePageCssClass' => 'page-item active',
            'disabledPageCssClass' => 'disabled page-link',
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
        ],
    ]);
    //====test block====//
    //    var_dump(Lookup::items('PostStatus'));
    //    var_dump(Lookup::item('PostStatus',Post::STATUS_PUBLISHED));
    ?>

    <?php /*echo GridView::widget([
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
        ],
        'pager' => [
            'options' => [
                'tag' => 'div',
                'class' => 'pagination',
                'id' => 'pager-container',
            ],
            'linkOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '<span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>',
            'nextPageLabel' => '<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>',
            'activePageCssClass' => 'page-item active',
            'disabledPageCssClass' => 'disabled page-link',
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
        ]]);*/ ?>
    <?php Pjax::end(); ?>
</div>

<?php /**/ ?>
