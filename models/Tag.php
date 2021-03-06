<?php /** @noinspection PhpMethodParametersCountMismatchInspection */

/** @noinspection PhpParamsInspection */

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property int $id
 * @property string $name
 * @property int $frequency
 */
class Tag extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }


    /**
     * @param $tags
     * @return array[]|false|string[]
     */
    public static function string2array($tags)
    {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param $tags
     * @return string
     */
    public static function array2string($tags)
    {
        return implode(', ', $tags);
    }


    /**
     * @param $oldTags
     * @param $newTags
     */
    public function updateFrequency($oldTags, $newTags)
    {
        $oldTags = self::string2array($oldTags);
        $newTags = self::string2array($newTags);
        $this->addTags(array_values(array_diff($newTags, $oldTags)));
        $this->removeTags(array_values(array_diff($oldTags, $newTags)));
    }

    /**
     * @param $tags
     */
    public function addTags($tags)
    {
        foreach ($tags as $name) {
            if ($tag = self::find()->where(['name' => $name])->one()) {
                $tag->updateCounters(['frequency' => 1]);
            } else {
                $tag = new Tag();
                $tag->name = $name;
                $tag->frequency = 1;
            }
            $tag->save();
        }
    }

    /**
     * @param $tags
     */
    public function removeTags($tags)
    {
        if (empty($tags))
            return;
        foreach ($tags as $name) {
            if ($tag = self::find()->where(['name' => $name])->one()) {
                $tag->updateCounters(array('frequency' => -1));
                $tag->save();
                $tag->deleteAll('frequency<=0');
            }
        }
    }

    /**
     * Returns tag names and their corresponding weights.
     * Only the tags with the top weights will be returned.
     * @param integer the maximum number of tags that should be returned
     * @return array weights indexed by tag names.
     */
    public function findTagWeights($limit = 20)
    {
        $models = self::find()->orderBy(['frequency'=>SORT_DESC])->limit($limit)->all();
        $total = 0;
        foreach ($models as $model)
            $total += $model->frequency;
        $tags = array();
        if ($total > 0) {
            foreach ($models as $model)
                $tags[$model->name] = 8 + (int)(16 * $model->frequency / ($total + 10));
            ksort($tags);
        }
        return $tags;
    }
}
