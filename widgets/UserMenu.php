<?php
/**
 * Created by PhpStorm.
 * User: gurik
 * Date: 25.03.2019
 * Time: 21:43
 */

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\Block;
use yii\widgets\Menu;

/**
 * @property string title
 */
class UserMenu extends Menu
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->title=Html::encode(Yii::$app->user->name);
        parent::init();
    }
}