<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('@web/js/fav.js',
    [
        'position' => $this::POS_END
    ]
);


$script = <<< JS
let input=document.getElementById("prikazcreateform-file");



var delIcon = document.getElementById("del-file");
var inputdiv = document.getElementById("add-file");
var file = document.getElementById("file");
var myFunction = function() {
file.remove();
inputdiv.hidden=false;
}


let params = (new URL(document.location)).searchParams;
console.log(params.get('id'));
delIcon.addEventListener('click', myFunction, false);

JS;
$this->registerJS($script);


?>

<?php echo \app\components\BackButtonWidget::widget(['url' => (Url::to(['/prikaz', 'year' => $y, 'month' => $m]))]) ?>
<div style="padding: 5px; background-color: white; border: grey; border-radius: 5px; margin: 5px"></div>
<?php if ($error != ""): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<?php echo \app\components\PrikazTitle::widget(['p'=>$p]); ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'text', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control']])->label('Название') ?>
<?php echo \app\components\InputFileWidget::widget(['model'=>$model, 'form'=>$form, 'hidden'=>true]) ?>
<p></p>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'accept' => ["application/pdf"]]) ?>
</div>


<?php ActiveForm::end(); ?>

<?php if ($ext !== "pdf") : ?>
    <div style="margin-top: 20px; display: inline-block;" id="file">

        <?= yii\helpers\Html::a('Прикрепленный файл', ['prikaz/download', 'filename' => $file], [
            'class' => 'btn btn-warning',
            'style' => [

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
        <a style="text-decoration: none; color:black; position: absolute; right: 11px; top: -25px" id="del-file"
           href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
            </svg>
        </a>

        <p></p>

        <iframe src="<?php echo Url::toRoute(["read", 'id' => $p->id]); ?>" frameborder="0" class="pdf"></iframe>

    </div>
<?php endif; ?>



<?php echo \app\components\ModifiedPrikazListWidget::widget(['p'=>$p, 'indexes'=>$items, 'canceled'=>$canceled, 'modified'=>$modified, 'canceling'=>$canceling, 'modifing'=>$modifing, 'update'=>true]) ?>

<?php if (Yii::$app->user->can('admin') === true): ?>
    <?php if ($p->edit_info !== null) : ?>

        <h4>История изменений:</h4>
        <div style="padding: 5px; border-radius: 5px; background-color: wheat"><?php echo $p->edit_info; ?></div>
    <?php endif; ?>
<?php endif; ?>


<style>
    .pdf {
        width: 100%;
        height: 500px;
    }


</style>

