<?php

namespace app\models;

use yii\base\Model;

/**
 * @property int $id
 * @property string $task
 * @property string $key
 * @property app\models\QuestTask $questTask [w]
 */
class QuestForm extends Model
{
    /** @var int */
    public $id;
    /** @var string */
    public $task;
    /** @var string $key */
    public $key;
    /** @var app\models\QuestTask */
    private $_questTask;

    public function setQuestTask(QuestTask $questTask)
    {
        $this->id = $questTask->id;
        $this->task = $questTask->task;
        $this->_questTask = $questTask;
    }

    public function rules()
    {
        return [
            ['key', 'required', 'message' => 'Трэба ўвесці ключ'], 
            ['key', 'string', 'max' => 255, 'tooLong' => 'Задоўгае значэнне ключа'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        $valid = 0 === strcasecmp ($this->key, $this->_questTask->key);
        if ( ! $valid) {
            $this->addError('key', 'Хібны ключ, паспрабуйце яшчэ');
        }
        return $valid;
    }

    public function savePassed()
    {
        $this->_questTask->passed = true;
        return $this->_questTask->save(false);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task' => 'Заданне',
            'key' => 'Ключ',
        ];
    }
}
