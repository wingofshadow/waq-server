<?php
use backend\widgets\crop\Jcrop;
use common\models\sys\Provinces;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '个人中心';
if ($admin == true) {
    $this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
    $this->params['breadcrumbs'][] = ['label' => '后台用户', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php $form = ActiveForm::begin([]); ?>
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox-content text-center">
                <div class="m-b-md">
                    <img class="img-circle circle-border" alt="image"
                         src="<?php echo !empty($model->head_portrait) ? $model->head_portrait : '/resource/backend/img/profile_small.jpg' ?>">
                </div>
                <p class="font-bold">

                <h3><i class="fa <?php echo $model->sex == 1 ? 'fa-mars' : 'fa-venus'; ?>"></i> <?= $model->realname ?>
                </h3></p>
                <div class="text-center">
                    <a class="btn btn-xs btn-primary" data-toggle="modal" data-target="#avatar-modal"> <i
                            class="fa fa-upload"></i> 头像上传</a>
                </div>
            </div>
            <div class="ibox-content">
                <p><i class="fa fa-map-marker"></i> <?= Provinces::getCityName($model->provinces) ?>
                    ·<?= Provinces::getCityName($model->city) ?>·<?= Provinces::getCityName($model->area) ?></p>

                <p><i class="fa fa-mobile"></i> <?php echo !empty($model->mobile_phone) ? $model->mobile_phone : '～' ?>
                </p>

                <p>E-MAIL： <?php echo !empty($model->email) ? $model->email : '～' ?></p>

                <p>最后登陆IP： <?php echo $model->last_ip ?></p>

                <p>最后登陆时间： <?php echo Yii::$app->formatter->asDatetime($model->last_time) ?></p>
            </div>
            <div class="ibox-content">
                <h5>详细地址</h5>

                <p><?= $model->address ?></p>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>资料编辑</h5>
                </div>
                <div class="ibox-content">
                    <div class="col-md-12">

                        <?= $form->field($model, 'realname')->textInput() ?>
                        <?= $form->field($model, 'sex')->radioList(['1' => '男', '2' => '女']) ?>
                        <?= $form->field($model, 'mobile_phone')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model, 'birthday')->widget('kartik\date\DatePicker', [
                            'language' => 'zh-CN',
                            'layout' => '{picker}{input}',
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,// 今日高亮
                                'autoclose' => true,// 选择后自动关闭
                                'todayBtn' => true,// 今日按钮显示
                            ],
                            'options' => [
                                'class' => 'form-control no_bor',
                                'readonly' => 'readonly',// 禁止输入
                            ]
                        ]); ?>
                        <?= \backend\widgets\provinces\Provinces::widget([
                            'form' => $form,
                            'model' => $model,
                            'provincesName' => 'provinces',
                            'cityName' => 'city',
                            'areaName' => 'area',
                        ]) ?>
                        <?= $form->field($model, 'address')->textarea() ?>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary" type="submit" onclick="SendForm()">保存内容</button>
                            <?php if ($admin == true) { ?>
                                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                            <?php } ?>
                        </div>
                    </div>
                    　
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">头像上传</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <?= $form->field($model, 'head_portrait')->widget(Jcrop::className(), [
                            'uploadUrl' => Url::to(['/file/crop-upload']),
                            'onCompleteJcrop' => 'onCompleteCrop',
                            'width' => 60,
                            'height' => 60,
                        ])->label(false) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function onCompleteCrop(filename, response) {
        var urlPath = response.filelink;
        $('#avatar-modal').modal('hide');
        $('.img-circle').attr('src', urlPath);
    }

    // 提交表单时候触发
    function SendForm() {
        var status = "<?php echo Yii::$app->user->identity->id == $model->id ? true : false ;?>";
        if (status) {
            var src = $('#manager-head_portrait').val();
            if (src) {
                $('#head_portrait', window.parent.document).attr('src', src);
            }
        }
    }
</script>
