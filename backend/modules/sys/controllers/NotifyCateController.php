<?php
namespace backend\modules\sys\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\sys\NotifyCate;
use backend\controllers\MController;

/**
 * 公告分类控制器
 *
 * Class TagController
 * @package backend\modules\sys\controllers
 */
class NotifyCateController extends MController
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        $data = NotifyCate::find();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('sort')
            ->limit($pages->limit)
            ->all();

        return $this->render('index',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * 编辑/新增
     *
     * @return array|mixed|string|yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id   = $request->get('id');
        $model    = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            if($request->isAjax)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            else
            {
                return $model->save()
                    ? $this->redirect(['index'])
                    : $this->message($this->analysisError($model->getFirstErrors()),$this->redirect(['index']),'error');
            }
        }

        return $this->renderAjax('edit', [
            'model'         => $model,
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())
        {
            return $this->message("删除成功",$this->redirect(['index']));
        }
        else
        {
            return $this->message("删除失败",$this->redirect(['index']),'error');
        }
    }

    /**
     * 返回模型
     * @param $id
     * @return $this|NotifyCate|static
     */
    protected function findModel($id)
    {
        if (empty($id))
        {
            $model = new NotifyCate;
            return $model->loadDefaultValues();
        }

        if (empty(($model = NotifyCate::findOne($id))))
        {
            return new NotifyCate;
        }

        return $model;
    }
}