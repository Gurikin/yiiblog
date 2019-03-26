<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\models\Comment;

?>
<?php
NavBar::begin([
    'options' => [
        'class' => 'navbar-light bg-light navbar-expand',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav flex-column ml-auto'],
    'items' => [
        ['label' => 'Create New Post', 'url' => ['/post/create']],
        ['label' => 'Manage Posts', 'url' => ['/post/admin'], 'visible' => !Yii::$app->user->isGuest],
        ['label' => 'Approve Comments' . ' (' . (new Comment())->pendingCommentCount . ')', 'url' => ['/comment/index'], 'visible' => !Yii::$app->user->isGuest]],
]);
NavBar::end();
?>