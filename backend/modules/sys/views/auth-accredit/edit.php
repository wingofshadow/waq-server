<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\modules\sys\models\AuthRule;
?>

<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['edit','name' => $model['name']]),
]); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">上级目录:<?= $parent_name?></h4>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'description')->textInput() ?>
                        <?= $form->field($model, 'name')->textInput()->hint('例如 main/index') ?>
                        <?= $form->field($model, 'rule_name')->dropDownList(AuthRule::getRoutes(),['prompt' => '请选择']) ?>
                        <?= $form->field($model, 'sort')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
        <button class="btn btn-primary" type="submit">保存内容</button>
    </div>
<?php ActiveForm::end(); ?>