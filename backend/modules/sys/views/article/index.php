<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use common\models\sys\Cate;
use common\models\sys\Article;

$this->title = '文章管理';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>查询</h5>
                </div>
                <div class="ibox-content">
                    <form action="" method="get" class="form-horizontal" role="form" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 control-label">关键字</label>
                            <div class="col-sm-8 input-group">
                                <input type="text" class="form-control" name="keyword" value="" placeholder="<?= $keyword ?>"/>
                                <input type="hidden" class="form-control" name="type" value="<?= $type ?>" />
                                <span class="input-group-btn">
                                    <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 control-label">文章分类</label>
                            <div class="col-sm-8">
                                <div class="row row-fix tpl-category-container">
                                    <?= Html::dropDownList('cate_id',$cate_id,Cate::getTree(),['class' => 'form-control tpl-category-parent','prompt' =>'请选择分类']); ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>文章管理</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="<?= Url::to(['edit'])?>">
                            <i class="fa fa-plus"></i>  创建文章
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>文章标题</th>
                            <th>分类</th>
                            <th>排序</th>
                            <th>浏览量</th>
                            <th>推荐位</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr id = <?= $model->id ?>>
                                <td><?= $model->id ?></td>
                                <td><?= $model->title ?></td>
                                <td><?= isset($model->cate->title) ? $model->cate->title : '' ?></td>
                                <td class="col-md-1"><input type="text" class="form-control" value="<?= $model['sort']?>" onblur="rfSort(this)"></td>
                                <td><?= $model->view ?></td>
                                <td>
                                    <?php foreach (Yii::$app->params['recommend'] as $key => $value){ ?>
                                        <?php if(Article::checkPosition($key,$model->position)){ ?><span class="label label-info"><?= $value ?></span><?php } ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?= Url::to(['edit','id'=>$model->id])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <?php echo $model['status'] == -1 ? '<span class="btn btn-primary btn-sm" onclick="rfStatus(this)">启用</span>': '<span class="btn btn-default btn-sm"  onclick="rfStatus(this)">禁用</span>' ;?>
                                    <a href="<?= Url::to(['hide','id'=>$model->id])?>" onclick="rfDelete(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= LinkPager::widget([
                                'pagination'        => $pages,
                                'maxButtonCount'    => 5,
                                'firstPageLabel'    => "首页",
                                'lastPageLabel'     => "尾页",
                                'nextPageLabel'     => "下一页",
                                'prevPageLabel'     => "上一页",
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
