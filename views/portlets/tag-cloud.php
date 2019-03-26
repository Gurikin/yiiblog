<?php

use app\widgets\TagCloud;
use yii\base\Widget;
use yii\widgets\ListView;

try {
    //echo Widget::widget(['TagCloud', ['maxTags' => Yii::$app->params['tagCloudCount']]]);
    echo TagCloud::widget([]);
} catch (Exception $e) {
    Yii\BaseYii::debug($e);
}
/** @var \yii\base\Widget $this */