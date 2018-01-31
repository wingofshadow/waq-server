<?php
/**
 * Created by PhpStorm.
 * User: divine
 * Date: 2018/1/30
 * Time: 下午11:27
 */

namespace api\controllers;


use common\models\nurse\Nurse;
use Yii;

class NurseController extends BaseController
{

    public function actionIndex()
    {
        $pageNo = Yii::$app->request->post('pageNo', 1);
        $pageSize = Yii::$app->request->post('pageSize', 10);
        $offset = ($pageNo - 1) * $pageSize;
        $nurseList = Nurse::find()
            ->with("province")
            ->offset($offset)
            ->limit($pageSize)
            ->orderBy('id desc')
            ->asArray()
            ->all();
        foreach ($nurseList as &$nurse) {
            $nurse['province'] = $nurse['province']['areaname'];
        }
        unset($nurse);
        return $nurseList;
    }
}