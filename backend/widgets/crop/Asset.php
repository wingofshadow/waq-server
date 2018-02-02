<?php
namespace backend\widgets\crop;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        '/resource/backend/other/jcrop/jquery.Jcrop.min.css',
        '/resource/backend/other/jcrop/jcrop.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        '/resource/backend/other/jcrop/SimpleAjaxUploader.min.js',
        '/resource/backend/other/jcrop/jquery.Jcrop.min.js',
        '/resource/backend/other/jcrop/jcrop.js',
    ];
}