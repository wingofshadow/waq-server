<?php

namespace common\models\nurse;

use common\models\sys\Provinces;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
class Nurse extends ActiveRecord
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
            [['name', 'level', 'age', 'from'], 'required'],
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

    public function getProvince()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'from']);
    }

    /**
     * 行为插入时间戳
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }
}
