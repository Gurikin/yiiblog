<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-light bg-light fixed-top navbar-fixed-top navbar-expand-lg navbar-expand-md navbar',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => [
        Yii::$app->user->isGuest ? (
        ['label' => 'Login', 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn nav-link']
            )
            . Html::endForm()
            . '</li>'
        )
    ],
]);
NavBar::end();
