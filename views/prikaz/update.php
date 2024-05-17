<?php


use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$script = <<< JS

var delIcon = document.getElementById("del-file");
var input = document.getElementById("add-file");
var file = document.getElementById("file");
var myFunction = function() {
    
file.remove();
input.hidden=false;
    
}


delIcon.addEventListener('click', myFunction, false);







JS;
$this->registerJS($script);



?>
    <div style="margin-top: 20px">
        <a href="<?php echo Url::to(['/prikaz', 'year'=>$y, 'month'=>$m]) ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
    </div>
    <p></p>


<?php if($error!=""): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<h4><?php if(!empty($p->index->symbol)){ echo $p->numc." ".$p->index->symbol." ".$p->text;} else {echo $p->numc." ".$p->text;}  ; ?></h4>
<?php $form = ActiveForm::begin(['options'=>['enctype'=> 'multipart/form-data']]); ?>


<?= $form->field($model, 'text', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control']])->label('Название')?>
<div hidden="true" id="add-file">
    <?= $form->field($model, 'file')->fileInput(['class'=>'input-prikaz', 'accept'=>'application/pdf'])->label("Выберите новый файл", ['class'=>'input-label']) ?>
</div>

<p></p>



<p></p>
<p></p>



<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'accept'=>["application/pdf"]]) ?>
</div>



<?php ActiveForm::end(); ?>

<?php if($ext !== "pdf") : ?>
<div style="margin-top: 20px; display: inline-block;" id="file" >

    <?= yii\helpers\Html::a('Прикрепленный файл', ['prikaz/download', 'filename' => $file ], [
            'class' => 'btn btn-warning',
        'style' =>[

    ]]) ?>


    <a style="text-decoration: none; color:black;" id="del-file" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             class="bi bi-trash-fill" viewBox="0 0 16 16">
            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg>
    </a>
</div>

<?php else: ?>
<div id="file" style="position: relative">
    <a style="text-decoration: none; color:black; position: absolute; right: 11px; top: -25px" id="del-file" href="#" >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             class="bi bi-trash-fill" viewBox="0 0 16 16">
            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg>
    </a>

  <p></p>

<iframe src="<?php echo Url::toRoute(["read", 'id' => $p->id]); ?>" frameborder="0" class="pdf" ></iframe>

</div>
<?php endif; ?>

<style>
    .pdf {
        width:100%;
        height: 500px;



    }
    .input-prikaz {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .input-label {
        background-color: #0a3622;
        color: white;
        padding: 5px;
        border-radius: 5px;
        cursor: pointer;

    }

    .input-label:hover {
        background-color: red;

    }
</style>

