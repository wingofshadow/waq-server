<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\helpers\SysArrayHelper;
use backend\modules\sys\models\AuthAssignment as SysAuthAssignment;

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
class Menu extends ActiveRecord
{
    const TYPE_MENU  = 'menu';
    const TYPE_SYS = 'sys';

    /**
     * @var array
     */
    public static $type = [
        self::TYPE_MENU => "导航菜单",
        self::TYPE_SYS => "系统菜单",
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title','trim'],
            ['title','required'],
            ['type','trim'],
            ['status','required'],
            ['url','trim'],
            ['url', 'default', 'value' => "#"],
            ['sort','trim'],
            ['sort', 'number'],
            [['menu_css','append', 'updated'], 'trim'],
            [['pid','sort'], 'default', 'value' => 0],
            [['level'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'  => 'Menu ID',
            'title'    => '标题',
            'pid'      => '上级id',
            'url'      => '路由',
            'menu_css' => '样式图标',
            'sort'     => '排序',
            'status'   => '状态',
            'append'   => '创建时间',
            'updated'  => '修改时间',
        ];
    }

    /**
     * 返回菜单列表
     * @param string $type 类别
     * @param bool $status 状态
     * @return array
     */
    public static function getMenus($type, $status = false)
    {
        $models = Menu::find()
            ->where(['type'=>$type])
            ->andFilterWhere(['status' => $status])
            ->orderBy('sort asc')
            ->asArray()
            ->all();

        $id = Yii::$app->user->id;

        // 判断是否是管理员
        if($id != Yii::$app->params['adminAccount'] && Yii::$app->config->info('SYS_MENU_SHOW_TYPE') == 1)
        {
            // 查询用户权限
            $authAssignment = SysAuthAssignment::find()
                ->with('itemNameChild')
                ->where(['user_id' => $id])
                ->asArray()
                ->one();

            // 匹配菜单
            if(isset($authAssignment['itemNameChild']))
            {
                $menu = [];
                foreach ($models as $model)
                {
                    foreach ($authAssignment['itemNameChild'] as $item)
                    {
                        if($model['url'] == $item['child'])
                        {
                            $menu[] = $model;
                        }
                    }
                }

                // 数组排序
                $models = SysArrayHelper::arraySort($menu,'sort');
            }
        }

        return SysArrayHelper::itemsMerge($models,'id');
    }

    /**
     * 删除子菜单
     *
     * @return bool
     */
    public function beforeDelete()
    {
        $menus = self::find()->all();
        $ids = SysArrayHelper::getChildsId($menus, $this->id);
        self::deleteAll(['in', 'id', $ids]);

        return parent::beforeDelete();
    }

    /**
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
