<?php

use app\widgets\TagCloud;

try {
    //echo Widget::widget(['TagCloud', ['maxTags' => Yii::$app->params['tagCloudCount']]]);
    echo TagCloud::widget([]);
} catch (Exception $e) {
    Yii\BaseYii::debug($e);
}
/** @var \yii\base\Widget $this */