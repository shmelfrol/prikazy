<?php

use yii\helpers\Url;
/* @var $indexes array */
?>
<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin')]) ?>
<?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('add-index'),'title' =>'Индексы приказов']) ?>


<?php foreach ($indexes as $indx): ?>
<?php echo \app\components\CardWidget::widget([
        'name'=>$indx->symbol,
        'isold'=>$indx->isold,
        'description'=>$indx->description,
        'created_at'=>$indx->created_at,
        'id'=>$indx->id,
        'del_url'=>'del-index'

    ]); ?>
<?php endforeach; ?>
