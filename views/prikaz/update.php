<?php

use yii\helpers\ArrayHelper;
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

delIcon.addEventListener('click', myFunction, false);


JS;
$this->registerJS($script);


?>

<?php echo \app\components\BackButtonWidget::widget(['url' => (Url::to(['/prikaz', 'year' => $y, 'month' => $m]))]) ?>

<?php if ($error != ""): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<div style="display: flex; align-items: center;justify-content: space-between">
   <?php echo \app\components\PrikazStatusWidget::widget(['status_name'=>$p->status_name, 'color'=>$p->color]) ?>
   <?php echo \app\components\ForDivisionsWidget::widget(['divisions'=>$divisions, 'checked_ids'=>$checked_ids, 'plus'=>true]) ?>
   <?php echo \app\components\FavIconWidget::widget(['p'=>$p]) ?>

</div>

<?php echo \app\components\PrikazTitle::widget(['p'=>$p]); ?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'text', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control']])->label('Название') ?>
<?php echo \app\components\InputFileWidget::widget(['model'=>$model, 'form'=>$form, 'hidden'=>true]) ?>
<p></p>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'accept' => ["application/pdf"]]) ?>
</div>


<?php ActiveForm::end(); ?>

<?php if ($ext !== "pdf" || isMobile()) : ?>
    <?php echo \app\components\FileDownloadBtnWidget::widget(['file'=>$file, 'trashIcon'=>true]) ?>
<?php else: ?>
    <?php echo \app\components\FileIframePDFWidget::widget(['prikaz_id'=>$p->id, 'trashIcon'=>true]) ?>
<?php endif; ?>






<?php echo \app\components\ModifiedPrikazListWidget::widget(['p'=>$p, 'indexes'=>$items, 'canceled'=>$canceled, 'modified'=>$modified, 'canceling'=>$canceling, 'modifing'=>$modifing, 'update'=>true]) ?>

<?php if (Yii::$app->user->can('admin') === true): ?>
    <?php if ($p->edit_info !== null) : ?>

        <h4>История изменений:</h4>
        <div style="padding: 5px; border-radius: 5px; background-color: wheat"><?php echo $p->edit_info; ?></div>
    <?php endif; ?>
<?php endif; ?>
<?php echo $_SERVER["HTTP_USER_AGENT"] ?>


<style>
    .pdf {
        width: 100%;
        height: 500px;
    }


</style>

