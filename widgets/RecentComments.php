<?php
/**
 * Created by PhpStorm.
 * User: biv
 * Date: 27.03.2019
 * Time: 10:55
 */

namespace app\widgets;


use app\models\Comment;
use app\models\helpers\Util;
use yii\base\Widget;

class RecentComments extends Widget
{
    public $title='Recent Comments';
    public $maxComments=10;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        $recentCommentPath = Util::file_build_path('/','portlets','recent-comments');
        $model = (new Comment)->findRecentComments($this->maxComments)->all();
        return $this->render($recentCommentPath, ['comments'=>$model]);
    }
}