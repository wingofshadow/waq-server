<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\sys\Provinces;

$this->title = '个人中心';
if($admin == true)
{
    $this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
    $this->params['breadcrumbs'][] = ['label' => '后台用户', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<link href="/resource/backend/other/cropper/cropper.min.css" rel="stylesheet">
<link href="/resource/backend/other/cropper/sitelogo.css" rel="stylesheet">

<div class="wrapper wrapper-content animated fadeInRight">
    <?php $form = ActiveForm::begin([]); ?>
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox-content text-center">
                <div class="m-b-md">
                    <img class="img-circle circle-border" alt="image" src="<?php echo !empty($model->head_portrait) ? $model->head_portrait : '/resource/backend/img/profile_small.jpg' ?>">
                </div>
                <p class="font-bold"><h3><i class="fa <?php echo $model->sex == 1 ? 'fa-mars': 'fa-venus'; ?>"></i> <?= $model->realname?></h3></p>
                <div class="text-center">
                    <a class="btn btn-xs btn-primary" data-toggle="modal" data-target="#avatar-modal"> <i class="fa fa-upload"></i>  头像上传</a>
                </div>
            </div>
            <div class="ibox-content">
                <p><i class="fa fa-map-marker"></i> <?= Provinces::getCityName($model->provinces)?>·<?= Provinces::getCityName($model->city)?>·<?= Provinces::getCityName($model->area)?></p>
                <p><i class="fa fa-mobile"></i> <?php echo !empty($model->mobile_phone) ? $model->mobile_phone : '～' ?> </p>
                <p>E-MAIL： <?php echo !empty($model->email) ? $model->email : '～' ?></p>
                <p>最后登陆IP： <?php echo $model->last_ip ?></p>
                <p>最后登陆时间： <?php echo Yii::$app->formatter->asDatetime($model->last_time) ?></p>
            </div>
            <div class="ibox-content">
                <h5>详细地址</h5>
                <p><?= $model->address?></p>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>资料编辑</h5>
                </div>
                <div class="ibox-content">
                    <div class="col-md-12">
                        <div class="form-group" >
                            <?= $form->field($model, 'head_portrait')->hiddenInput()->label(false) ?>
                        </div>
                        <?= $form->field($model, 'realname')->textInput() ?>
                        <?= $form->field($model, 'sex')->radioList(['1' => '男','2' => '女']) ?>
                        <?= $form->field($model, 'mobile_phone')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model,'birthday')->widget('kartik\date\DatePicker',[
                            'language'  => 'zh-CN',
                            'layout'=>'{picker}{input}',
                            'pluginOptions' => [
                                'format'         => 'yyyy-mm-dd',
                                'todayHighlight' => true,// 今日高亮
                                'autoclose'      => true,// 选择后自动关闭
                                'todayBtn'       => true,// 今日按钮显示
                            ],
                            'options'=>[
                                'class'     => 'form-control no_bor',
                                'readonly'  => 'readonly',// 禁止输入
                            ]
                        ]); ?>
                        <?= \backend\widgets\provinces\Provinces::widget([
                            'form'          => $form,
                            'model'         => $model,
                            'provincesName' => 'provinces',
                            'cityName'      => 'city',
                            'areaName'      => 'area',
                        ])?>
                        <?= $form->field($model, 'address')->textarea() ?>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary" type="submit" onclick="SendForm()">保存内容</button>
                            <?php if($admin == true) { ?>
                                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                            <?php } ?>
                        </div>
                    </div>　
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">头像上传</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <div class="avatar-upload">
                            <input class="avatar-src" name="avatar_src" type="hidden">
                            <input class="avatar-data" name="avatar_data" type="hidden">
                            <button class="btn btn-primary"  type="button" style="height: 35px;" onClick="$('input[id=avatarInput]').click();">图片选择</button>
                            <span id="avatar-name" style="display: none"></span>
                            <input class="avatar-input hide" id="avatarInput" name="avatar_file" type="file" accept="image/*"></div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg" id="imageHead"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                            </div>
                        </div>
                        <div class="row avatar-btns">
                            <div class="col-md-3">
                                <span class="btn btn-white fa fa-undo" data-method="rotate" data-option="-90" title="向左旋转90°"> 左旋转</span>
                                <span class="btn  btn-white fa fa-repeat" data-method="rotate" data-option="90" title="向右旋转90°"> 右旋转</span>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <div class="btn btn-white fa fa-arrows" data-method="setDragMode" data-option="move" title="移动"> 移动</div>
                                <div class="btn btn-white fa fa-crop" data-method="setDragMode" data-option="crop" title="裁剪"> 裁剪</div>
                                <div class="btn btn-white fa fa-search-plus" data-method="zoom" data-option="0.1" title="放大图片"> 放大</div>
                                <div class="btn btn-white fa fa-search-minus" data-method="zoom" data-option="-0.1" title="缩小图片"> 缩小</div>
                                <div type="button" class="btn btn-white fa fa-refresh" data-method="reset" title="重置图片"> 重置</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary avatar-save" data-dismiss="modal">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/resource/backend/other/cropper/cropper.js"></script>
<script src="/resource/backend/other/cropper/sitelogo.js"></script>
<script src="/resource/backend/other/cropper/html2canvas.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    // 做个下简易的验证  大小 格式
    $('#avatarInput').on('change', function(e) {
        var filemaxsize = 1024 * 5;// 5M
        var target = $(e.target);
        var Size = target[0].files[0].size / 1024;
        if(Size > filemaxsize) {
            alert('图片过大，请重新选择!');
            $(".avatar-wrapper").childre().remove;
            return false;
        }
        if(!this.files[0].type.match(/image.*/)) {
            alert('请选择正确的图片!')
        } else {
            var filename = document.querySelector("#avatar-name");
            var texts = document.querySelector("#avatarInput").value;
            var teststr = texts; // 你这里的路径写错了
            testend = teststr.match(/[^\\]+\.[^\(]+/i); // 直接完整文件名的
            filename.innerHTML = testend;
        }

    });

    $(".avatar-save").on("click", function() {
        var img_lg = document.getElementById('imageHead');
        // 截图小的显示框内的内容
        html2canvas(img_lg, {
            allowTaint  : true,
            taintTest   : false,
            onrendered  : function(canvas) {
                canvas.id = "mycanvas";
                var dataUrl = canvas.toDataURL();
                var base64 = dataUrl.split(',');
                imagesAjax(base64[1]);
            }
        });
    });

    function imagesAjax(src) {
        var data = {};
        data.img = src;
        data.jid = $('#jid').val();
        $.ajax({
            url     : "<?= Url::to(['/file/upload-base64-img'])?>",
            type    : "post",
            dataType: 'json',
            data    : data,
            success : function(data) {
                if(data.code == 200) {
                    data = data.data;
                    $('#manager-head_portrait').val(data.urlPath);
                    $('.img-circle').attr('src',data.urlPath);
                }
            }
        });
    }

    // 提交表单时候触发
    function SendForm(){
        var status = "<?php echo Yii::$app->user->identity->id == $model->id ? true : false ;?>";
        if(status){
            var src = $('#manager-head_portrait').val();
            if(src){
                $('#head_portrait',window.parent.document).attr('src',src);
            }
        }
    }
</script>

