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

    <?php
    $columns = 3;
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}<div class="col-12">{pager}</div>',
        'itemOptions' => ['class' => "col-lg-10 col-md-10 col-xs-10 org-cont"],
        'itemView' => 'postCard',
        'options' => ['class' => 'container d-flex flex-wrap align-items-stretch justify-content-between'],
        'pager' => [
            'options' => [
                'tag' => 'div',
                'class' => 'pagination animated fadeIn delay-1s',
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
    ?>

    <?php Pjax::end(); ?>
</div>
