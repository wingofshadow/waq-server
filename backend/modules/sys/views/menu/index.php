<?php
use yii\helpers\Url;

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = ['label' => '系统', 'url' => ['/sys/system/index']];
$this->params['breadcrumbs'][] = ['label' =>  $this->title];

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <?php foreach ($menuType as $key => $title){ ?>
                        <li class="<?php if($type == $key ){ echo 'active' ;}?>"><a href="<?= Url::to(['index','type'=> $key])?>"> <?php echo $title ?></a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="ibox-tools">
                                    <a class="btn btn-primary btn-xs" href="<?= Url::to(['edit','type'=>$type])?>" data-toggle='modal' data-target='#ajaxModal'>
                                        <i class="fa fa-plus"></i>  创建菜单
                                    </a>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th width="50">折叠</th>
                                            <th>标题</th>
                                            <th>路由</th>
                                            <th>图标</th>
                                            <th>排序</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?= $this->render('tree', [
                                            'models' => $models,
                                            'type' => $type,
                                            'parent_title' =>"无",
                                            'pid' => 0,
                                        ])?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
