<?php

use common\helpers\DateHelper;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '人员管理';
$this->params['breadcrumbs'][] = $this->title;
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
                            <label class="col-xs-12 col-sm-2 col-md-2 control-label">姓名</label>

                            <div class="col-sm-8 col-xs-12 input-group m-b">
                                <input type="text" class="form-control" name="keyword" value="<?= $keyword ?>"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                                </span>
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
                    <h5>人员列表</h5>

                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href="<?= Url::to(['edit']) ?>">
                            <i class="fa fa-plus"></i> 添加人员
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>姓名</th>
                            <th>等级</th>
                            <th>年龄</th>
                            <th>籍贯</th>
                            <th>描述</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($models as $model) { ?>
                            <tr id="<?= $model->id ?>">
                                <td class="feed-element">
                                    <img src="<?= $model->portrait ?>" class="img-circle">
                                </td>
                                <td><?= $model->name ?></td>
                                <td><?= $model->level ?></td>
                                <td><?= $model->age ?></td>
                                <td><?= $model->province->areaname ?></td>
                                <td><?= $model->desc ?></td>
                                <td><?= DateHelper::getStr($model->create_time) ?></td>
                                <td>
                                    <a href="<?= Url::to(['edit', 'id' => $model->id]) ?>"><span
                                            class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <a href="<?= Url::to(['delete', 'id' => $model->id]) ?>"
                                       onclick="rfDelete(this);return false;"><span
                                            class="btn btn-warning btn-sm">删除</span></a>&nbsp
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= LinkPager::widget([
                                'pagination' => $pages,
                                'maxButtonCount' => 5,
                                'firstPageLabel' => "首页",
                                'lastPageLabel' => "尾页",
                                'nextPageLabel' => "下一页",
                                'prevPageLabel' => "上一页",
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
