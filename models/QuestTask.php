<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "quests".
 *
 * @property int $id
 * @property string $task
 * @property string $key
 * @property int $passed
 */
class QuestTask extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quests}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task'], 'required'],
            [['task'], 'string'],
            [['passed'], 'integer'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'key',
                ],
                'value' => function($event) {
                    return substr (md5 ($this->task), 0, 6);
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task' => 'Заданне',
            'key' => 'Ключ',
            'passed' => 'Выкананае',
        ];
    }

    public static function findUnPassed()
    {
        return static::findOne([
            'passed' => 0,
        ]);
    }
}
