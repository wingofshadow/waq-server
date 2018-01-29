<?php
namespace common\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\web\NotFoundHttpException;
use yii\db\ActiveRecord;
use common\helpers\AddonsHelp;
use common\enums\StatusEnum;
use common\models\wechat\Rule;

/**
 * This is the model class for table "{{%sys_addons}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $cover
 * @property string $description
 * @property integer $status
 * @property string $config
 * @property integer $is_setting
 * @property string $author
 * @property string $version
 * @property integer $sort
 * @property integer $has_adminlist
 * @property string $append
 */
class Addons extends ActiveRecord
{
    public $install;
    public $uninstall;
    public $upgrade;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_addons}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','unique','message'=>'该模块已经存在'],
            ['name','match','pattern'=>'/^[_a-zA-Z]+$/','message'=>'标识由英文和下划线组成'],
            [['name','title','version', 'description','install','uninstall','upgrade'], 'trim'],
            [['name','title', 'type','version', 'description','author','brief_introduction'], 'required'],
            [['description', 'config'], 'string'],
            [['wxapp_support','status', 'setting', 'is_rule', 'hook','updated', 'append'], 'integer'],
            [['name', 'author'], 'string', 'max' => 40],
            [['version'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 20],
            [['title_initial'], 'string', 'max' => 1],
            [['cover','wechat_message'], 'string', 'max' => 1000],
            [['group'], 'safe'],
            [['install','uninstall','upgrade'], 'string', 'max' => 100],
            [['brief_introduction'], 'string', 'max' => 140],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '模块标识',
            'title' => '模板名称',
            'title_initial' => '首字母拼音',
            'cover' => '封面',
            'group' => '组别',
            'type' => '类别',
            'brief_introduction' => '简单说明',
            'description' => '模块说明',
            'status' => '状态',
            'config' => '配置信息',
            'hook' => '钩子',
            'is_rule' => '需要嵌入规则 ',
            'wxapp_support' => '小程序',
            'setting' => '存在全局设置项',
            'author' => '作者',
            'version' => '版本',
            'wechat_message' => '微信公众平台消息处理选项',
            'install' => '模块安装脚本',
            'uninstall' => '模块卸载脚本',
            'upgrade' => '模块升级脚本',
            'append' => '创建时间',
            'updated' => '更新时间',
        ];
    }

    /**
     * 获取插件列表
     * @return array
     */
    public function getList()
    {
        $addon_dir = Yii::getAlias('@addons');

        // 获取插件列表
        $dirs = array_map('basename',glob($addon_dir.'/*'));

        $addons = [];
        $where = ['in','name',$dirs];
        $list =	$this->find()
            ->where($where)
            ->asArray()
            ->all();

        foreach($list as $addon)
        {
            $addon['uninstall'] = 0;
            $addons[$addon['name']]	= $addon;
        }

        foreach ($dirs as $value)
        {
            // 判断是否安装
            if(!isset($addons[$value]))
            {
                $class = AddonsHelp::getAddonsClass($value);
                // 实例化插件失败忽略执行
                if(class_exists($class))
                {
                    $obj    =   new $class;
                    $addons[$value]	= $obj->info;

                    if($addons[$value])
                    {
                        $addons[$value]['uninstall'] = 1;
                        unset($addons[$value]['status']);
                    }
                }
            }
        }

        return $addons;
    }

    /**
     * 重组数组
     * @param $data
     * @return array
     */
    public static function regroupType($data)
    {
        $addonsType = Yii::$app->params['addonsType']['addon']['child'];

        $arr = [];
        foreach ($data as $vo)
        {
            $type = $vo['type'];
            $arr[$type][] = $vo;
        }

        $list = [];
        foreach ($addonsType as $key => &$item)
        {
            $list[$key]['title'] = $item;
            $list[$key]['list'] = [];
            if(isset($arr[$key]))
            {
                $list[$key]['list'] = $arr[$key];
            }
        }

        return $list;
    }

    /**
     * 根据模块标识获取模块
     * @param $name
     * @return array|null|ActiveRecord
     */
    public static function getAddon($name)
    {
        return Addons::find()->where(['name' => $name, 'status' => StatusEnum::ENABLED])->one();
    }

    /**
     * 获取插件列表
     * @return array|ActiveRecord[]
     */
    public static function getPlugList()
    {
        $models = self::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['type' => 'plug'])
            ->asArray()
            ->all();

        return $models ? $models : [];
    }

    /**
     * 获取模块列表
     * @return array|ActiveRecord[]
     */
    public static function getModuleList()
    {
        $models = self::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['<>','type','plug'])
            ->asArray()
            ->all();

        return $models ? $models : [];
    }

    /**
     * 获取模块数据
     * @param $message
     * @param $addon
     * @return string
     */
    public static function getWechatMessage($message, $addon)
    {
        try
        {
            $class = '\addons\\' . $addon . '\\WechatMessage';
            if(!class_exists($class))
            {
                throw new NotFoundHttpException($class . '未找到');
            }

            $class = new $class;
            if(!method_exists($class, 'run'))
            {
                throw new NotFoundHttpException($class . '/actionRun 方法未找到');
            }

            return $class->run($message);
        }
        catch (\Exception $e)
        {
            Yii::warning($e->getMessage());
            return '模块异常,请联系管理员';
        }
    }

    /**
     * 获取小程序
     * @return mixed
     */
    public static function getWxAppList()
    {
        $model = self::find()->where(['wxapp_support' => 1,'status' => StatusEnum::ENABLED])->all();
        return ArrayHelper::map($model,'name','title');
    }

    /**
     * 卸载插件的时候清理安装的信息
     */
    public function afterDelete()
    {
        AddonsBinding::deleted($this->name);
        Rule::deleted($this->name);
        parent::afterDelete();
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
