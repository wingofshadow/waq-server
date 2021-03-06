<?php
use common\models\sys\Provinces;
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '人员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">

</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>人员信息</h5>
                </div>
                <div class="ibox-content">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'name')->textInput() ?>
                        <?= $form->field($model, 'level')->textInput() ?>
                        <?= $form->field($model, 'age')->textInput() ?>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'from')->dropDownList(Provinces::getCityList(),
                                    [
                                        'prompt' => '--请选择省--',
                                    ]) ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'portrait')->widget('backend\widgets\webuploader\Image', [
                            'boxId' => 'portrait',
                            'options' => [
                                'multiple' => false,
                            ]
                        ])->label('上传头像'); ?>
                        <?= $form->field($model, 'desc')->textarea() ?>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                        </div>
                    </div>
                    　
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
