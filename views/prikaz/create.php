<?php


use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $prikazes array */
/* @var  $hidden  boolean*/
/* @var  $btndel  boolean*/
/* @var  $btncancel  boolean*/
/* @var  $btnedit  boolean*/






?>



<?php echo \app\components\BackButtonWidget::widget([]) ?>

<?php if($error!=""): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>


<?php $form = ActiveForm::begin(['options'=>['enctype'=> 'multipart/form-data']]); ?>


<?= $form->field($model, 'numc', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control']])->label('Номер')?>
<?php echo $form->field($model, 'index_id')->dropDownList($items)->label('Индекс'); ?>
<?= $form->field($model, 'reldate')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy',
        'value'=>date('d-m-Y'),
    ]
])->label('Дата');
?>

<?= $form->field($model, 'text', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control']])->label('Название')?>

<?php echo \app\components\InputFileWidget::widget(['model'=>$model, 'form'=>$form]) ?>







<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>



<?php ActiveForm::end(); ?>


