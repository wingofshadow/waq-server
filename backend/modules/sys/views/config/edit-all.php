<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\sys\Config;

$this->title = '系统配置';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-9">
            <div class="tabs-container">
                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <?php foreach ($configCateAll as $k => $cate){ ?>
                            <li <?php if($k == 0){ ?>class="active"<?php } ?>>
                                <a aria-expanded="false" href="#tab-<?= $cate['id'] ?>" data-toggle="tab"> <?= $cate['title'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php foreach ($configCateAll as $k => $cate){ ?>
                            <div class="tab-pane <?php if($k == 0){ ?>active<?php } ?>" id="tab-<?= $cate['id'] ?>">
                                <div class="panel-body">
                                    <form class="form-horizontal" method="post" action="" id="form-tab-<?= $cate['id'] ?>">
                                        <?php foreach ($cate['-'] as $item){ ?>
                                            <h2 style="font-size: 20px;"><i class="fa fa-share-alt"></i> <?= $item['title']?></h2>
                                            <?php if(isset($item['config'])){ ?>
                                                <div class="col-sm-12" style="padding-left: 37px;">
                                                    <?php foreach ($item['config'] as $row){ ?>
                                                        <?php if($row['type'] == 'text'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <?= Html::input('text','config[' . $row['name'] . ']',$row['value'],['class' => 'form-control']);?>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'password'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <?= Html::input('password','config[' . $row['name'] . ']',$row['value'],['class' => 'form-control']);?>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'secretKeyText'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <div class="input-group">
                                                                    <?= Html::input('text','config[' . $row['name'] . ']',$row['value'],['class' => 'form-control','id' => $row['id']]);?>
                                                                    <span class="input-group-btn">
                                                                            <span class="btn btn-white" onclick="createKey(<?= $row['extra']?>,<?= $row['id']?>)">生成新的</span>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'textarea'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <?= Html::textarea('config[' . $row['name'] . ']',$row['value'],['class'=>'form-control']);?>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'dropDownList'){
                                                            // 获取数组
                                                            $option = Config::parseConfigAttr($row['extra']);
                                                            ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <?= Html::dropDownList('config[' . $row['name'] . ']',$row['value'],$option,['class'=>'form-control']);?>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'radioList'){
                                                            // 获取数组
                                                            $option = Config::parseConfigAttr($row['extra']);
                                                            ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <div class="col-sm-push-10">
                                                                    <?php foreach ($option as $key => $v){ ?>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="config[<?= $row['name']?>]" class="radio" value="<?= $key?>" <?php if($key == $row['value']){ ?>checked<?php } ?>><?= $v?>
                                                                        </label>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'baiduUEditor'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <?= \crazydb\ueditor\UEditor::widget([
                                                                    'id' => "config[".$row['name']."]",
                                                                    'attribute' => $row['name'],
                                                                    'name' => $row['name'],
                                                                    'value' => $row['value'],
                                                                ]) ?>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'image'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <div class="col-sm-push-10">
                                                                    <?= \backend\widgets\webuploader\Image::widget([
                                                                        'boxId' => $row['name'],
                                                                        'name'  =>"config[".$row['name']."]",
                                                                        'value' => $row['value'],
                                                                        'options' => [
                                                                            'multiple'   => false,
                                                                        ]
                                                                    ])?>
                                                                </div>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'images'){ ?>
                                                            <div class="form-group" style="padding-left: -15px">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <div class="col-sm-push-10">
                                                                    <?= \backend\widgets\webuploader\Image::widget([
                                                                        'boxId' => $row['name'],
                                                                        'name'  => "config[".$row['name']."][]",
                                                                        'value' => $row['value'],
                                                                        'options' => [
                                                                            'multiple'   => true,
                                                                        ]
                                                                    ])?>
                                                                </div>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'file'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <div class="col-sm-push-10" style="padding-left: 15px">
                                                                    <?= \backend\widgets\webuploader\File::widget([
                                                                        'boxId' => $row['name'],
                                                                        'name'  =>"config[".$row['name']."]",
                                                                        'value' => $row['value'],
                                                                        'options' => [
                                                                            'multiple'   => false,
                                                                        ]
                                                                    ])?>
                                                                </div>
                                                            </div>
                                                        <?php }elseif($row['type'] == 'files'){ ?>
                                                            <div class="form-group">
                                                                <?= Html::label($row['title'],$row['name'],['class' => 'control-label demo']);?>　<?php if($row['is_hide_remark'] != 1){ ?>(<?= $row['remark']?>)<?php } ?>
                                                                <div class="col-sm-push-10" style="padding-left: 15px">
                                                                    <?= \backend\widgets\webuploader\File::widget([
                                                                        'boxId' => $row['name'],
                                                                        'name'  => "config[".$row['name']."][]",
                                                                        'value' => $row['value'],
                                                                        'options' => [
                                                                            'multiple'   => true,
                                                                        ]
                                                                    ])?>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    }
                                                    ?>
                                                </div>
                                            <?php }
                                        } ?>
                                        <?= Html::input('hidden','_csrf',Yii::$app->request->csrfToken,['id' => '_csrf']);?>
                                        <div class="form-group">
                                            <div class="col-sm-12 text-center">
                                                <span type="submit" class="btn btn-primary" onclick="present(<?= $cate['id'] ?>)">保存内容</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3" id="explain">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h4>说明：</h4>
                        <h5>单击标题名称获取配置标识</h5>
                        <div class="hr-line-dashed"></div>
                        <h5 class="tag-title"></h5>
                        <?= Html::input('text','demo','',['class' => 'form-control','id'=>'demo','readonly' => 'readonly']);?>
                        <div class="hr-line-dashed"></div>
                        <div class="clearfix">当前显示 ： <span id="demo-title"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        var menuYloc = $("#explain").offset().top;
        $(window).scroll(function () {
            var offsetTop = menuYloc + $(window).scrollTop() - 73 + "px";
            $("#explain").animate({ top: offsetTop }, { duration: 600, queue: false });
        });
    });

    // 单击
    $('.demo').click(function(){
        $('#demo').val($(this).attr('for'));
        $('#demo-title').text($(this).text());
    });

    function present(obj){
        // 获取表单内信息
        var values = $("#form-tab-"+obj).serialize();

        $.ajax({
            type:"post",
            url:"<?= Url::to(['update-info'])?>",
            dataType: "json",
            data: values,
            success: function(data){
                if(data.code == 200) {
                    rfAffirm(data.message);
                }else{
                    rfAffirm(data.message);
                }
            }
        });
    }

    function createKey(num,id){
        var letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var token = '';
        for(var i = 0; i < num; i++) {
            var j = parseInt(Math.random() * 61 + 1);
            token += letters[j];
        }
        $("#"+id).val(token);
    }
</script>