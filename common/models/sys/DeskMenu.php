<?php

namespace common\models\sys;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\helpers\SysArrayHelper;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $pid
 * @property string $url
 * @property string $main_css
 * @property integer $sort
 * @property integer $status
 * @property string $group
 * @property integer $append
 * @property integer $updated
 */
class DeskMenu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_desk_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','status','url_type','target'], 'required'],
            [['status','menu_css','url','append', 'updated'], 'trim'],
            ['sort', 'number'],
            ['cover', 'string'],
            [['pid','sort'], 'default', 'value' => 0],
            [['level'], 'default', 'value' => 1],
            [['url'], 'default', 'value' => "#"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => '导航id',
            'title'    => '标题',
            'cover'    => '封面',
            'pid'      => '上级id',
            'url'      => '路由',
            'url_type' => '路由类型',
            'menu_css' => '样式图标',
            'target' => '新窗口打开',
            'sort'     => '排序',
            'status'   => '状态',
            'append'   => '创建时间',
            'updated'  => '修改时间',
        ];
    }

    /**
     * 删除子分类
     *
     * @return bool
     */
    public function beforeDelete()
    {
        $models = self::find()->all();
        $ids = SysArrayHelper::getChildsId($models, $this->id);
        self::deleteAll(['in', 'id', $ids]);

        return parent::beforeDelete();
    }

    /**
     * 行为
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
