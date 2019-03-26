<?php
/**
 * Created by PhpStorm.
 * User: biv2
 * Date: 26.03.2019
 * Time: 15:38
 */

namespace app\widgets;


use app\models\Tag;
use yii\base\Widget;
use yii\helpers\Html;

class TagCloud extends Widget
{
    public $title='Tags';
    public $maxTags=20;

    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        $tags = (new Tag())->findTagWeights($this->maxTags);
        $r = '';
        foreach ($tags as $tag=>$weight) {
            $link=Html::a(Html::encode($tag),['post/index','tag'=>$tag],['class'=>'badge badge-light']);
            $weight *= 1.5;
            $r .= Html::tag('span',$link,['class'=>'tag','style'=>"font-size:{$weight}pt"])."\n";
        }
        return $r;
    }
}