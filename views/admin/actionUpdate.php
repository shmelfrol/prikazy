

<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin/actions')]) ?>


<?php $form = ActiveForm::begin(); ?>
<div>

   <div style="display: inline-block">
       <?= $form->field($model, 'status_name', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Статус')?>
   </div>
    <div >
        <?= $form->field($model, 'color', ['labelOptions' => ['class' => 'text-last'],
            'inputOptions' => [
                "class" => 'form-control mycolor',
                'readonly' => false,
                'type'=>'color',
                ]])->label('Цвет')?>
    </div>

</div>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<style>
    .mycolor {
        height: 40px;
        width: 205px;
    }

</style>
