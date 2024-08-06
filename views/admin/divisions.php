<?php

use yii\helpers\Url;

?>
<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin')]) ?>
<?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('add-division'),'title' =>'Подразделения']) ?>


<?php foreach ($divisions as $d): ?>
    <?php echo \app\components\CardWidget::widget([
        'name'=>$d->short_name,
        'isold'=>$d->is_old,
        'description'=>$d->name,
        'created_at'=>$d->created_at,
        'id'=>$d->id,
        'del_url'=>'del-division',
        'update_url'=>'update-division',
        'color'=>$d->color

    ]); ?>
<?php endforeach; ?>
