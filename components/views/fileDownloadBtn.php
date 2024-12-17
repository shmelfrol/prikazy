<?php
?>


<div style="margin-top: 20px; display: inline-block;" id="file">

    <?= yii\helpers\Html::a('Файл приказа', ['prikaz/download', 'filename' => $file], [
        'class' => 'btn btn-warning',
        'style' => [
        ]]) ?>
    <?php if($trashIcon): ?>
    <?php echo \app\components\TrashIconWidget::widget([]); ?>
    <?php endif; ?>
</div>
