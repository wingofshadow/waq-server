<?php

namespace common\models\nurse;

use Yii;

/**
 * This is the model class for table "nurse".
 *
 * @property int $id
 * @property string $name 姓名
 * @property int $level 等级
 * @property int $age 年龄
 * @property string $desc 描述
 * @property int $from 籍贯
 * @property string $portrait 肖像url
 */
class Nurse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nurse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'age', 'from'], 'required'],
            [['level', 'age', 'from'], 'integer'],
            [['name'], 'string', 'max' => 16],
            [['desc'], 'string', 'max' => 256],
            [['portrait'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'level' => '等级',
            'age' => '年龄',
            'desc' => '描述',
            'from' => '籍贯',
            'portrait' => '肖像url',
        ];
    }
}
