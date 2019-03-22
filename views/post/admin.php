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

    <?php if (!empty($_GET['tag'])): ?>
        <h1>Записи с тегом <i><?php echo Html::encode($_GET['tag']); ?></i></h1>
    <?php endif; ?>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($data) {return Html::a(Html::encode($data->title), $data->url);},
            ],
            ['value' => function($data) {return Lookup::item("PostStatus",$data->status);},
                'filter' => Lookup::items('PostStatus')],
            'create_time:datetime',
            //'update_time:datetime',
            //'author_id',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '<div class="d-flex justify-content-center">{view}{update}{delete}</div>',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="more detail"
                                                            class="fa fa-eye"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('post/view', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'view'),
                                'data-method' => 'post',
                                'data-pjax' => '1',
                            ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="edit"
                                                            class="fa fa-pen"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('post/update', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'view'),
                                'data-method' => 'post',
                                'data-pjax' => '1',
//                                'class' => ($model['status'] >= 1 && $model['status'] !== 3) ? 'btn-link disabled' : '',
                            ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="delete"
                                                            class="far fa-trash-alt"></em></div>',
                            (new yii\grid\ActionColumn())->createUrl('post/delete', $model, $model['id'], 1), [
                                'title' => Yii::t('yii', 'view'),
                                'data-method' => 'post',
                                'data-pjax' => '1',
//                                'class' => ($model['status'] == 0 || $model['status'] > 3) ? 'btn-link disabled' : '',
                            ]);
                    },],
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
        ]]); ?>
    <?php Pjax::end(); ?>
</div>

<?php /**/ ?>
