<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\nurse\Nurse */

$this->title = 'Create Nurse';
$this->params['breadcrumbs'][] = ['label' => 'Nurses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nurse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
