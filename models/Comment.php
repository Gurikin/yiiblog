<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_comment".
 *
 * @property int $id
 * @property string $content
 * @property int $status
 * @property int $create_time
 * @property string $author
 * @property string $email
 * @property string $url
 * @property int $post_id
 *
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{
    const STATUS_PENDING=1;
    const STATUS_APPROVED=2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'author', 'email'], 'required'],
            [['author', 'email', 'url'], 'string', 'max' => 128],
            [['email'], 'email'],
            [['url'], 'url', 'defaultScheme' => ''],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Comment',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'author' => 'Name',
            'email' => 'Email',
            'url' => 'Website',
            'post_id' => 'Post',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord)
                $this->create_time = time();
                $this->status = self::STATUS_PENDING;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param null $post Post
     * @return string
     */
    public function getUrl($post=null)
    {
        if($post===null)
            $post=$this->post;
        return $post->url.'#c'.$this->id;
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function approve()
    {
        //$this->setAttribute('status',self::STATUS_APPROVED);
        //$this->status = self::STATUS_APPROVED;
        $this->updateAttributes(['status'=>self::STATUS_APPROVED]);
    }

    /**
     * @return integer the number of comments that are pending approval
     */
    public function getPendingCommentCount()
    {
        return self::find()->where(['status'=>self::STATUS_PENDING])->count();
    }

    /**
     * @param int $limit
     * @return array|\yii\db\ActiveQuery|\yii\db\ActiveRecord[]
     */
    public function findRecentComments($limit=10) {
        return self::find()->with('post')->where(['status'=>self::STATUS_APPROVED,])->orderBy(['create_time'=>SORT_DESC])->limit($limit);
    }
}
