<?php

namespace backend\modules\sys;

/**
 * 系统模块定义类
 * Class Module
 * @package backend\modules\sys
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\sys\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
