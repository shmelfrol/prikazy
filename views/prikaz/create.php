<?php


use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $prikazes array */
/* @var  $hidden  boolean*/
/* @var  $btndel  boolean*/
/* @var  $btncancel  boolean*/
/* @var  $btnedit  boolean*/



$script = <<< JS
let input=document.getElementById("prikazcreateform-file");


var inputFunction = function(){
    let countFiles = '';
    let filename = '';
    let fileNameDiv= document.getElementById("uploadedfile");
        if (this.files && this.files.length >= 1)
          countFiles = this.files.length;
        filename = this.files[0].name;
        fileNameDiv.textContent=filename;
}


input.addEventListener('change', inputFunction, false);





JS;
$this->registerJS($script);



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

<?//= $form->field($model, 'file')->fileInput() ?>

<div id="add-file">
    <?= $form->field($model, 'file')->fileInput(['class'=>'input-prikaz', 'accept'=>'application/pdf'])->label("<div style='display: inline-block;'>Выберите новый файл</div><div style='display: inline-block;'><img src='/images/upload_white.png' style='width: 40px; height: 25px' /> </div>", ['class'=>'input-label']) ?>
    <div id="uploadedfile"></div>
</div>





<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>



<?php ActiveForm::end(); ?>

<style>

    .input-prikaz {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .input-label {
        background-color: #157347;
        color: white;
        padding: 5px;
        border-radius: 5px;
        cursor: pointer;

    }

    .input-label:hover {
        background-color:saddlebrown;

    }
</style>
