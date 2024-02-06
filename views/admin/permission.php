<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
    <div>
        <a href="<?php echo Url::toRoute('/admin/permissions'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
    </div>
    <p></p>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'name', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => true]])->label('Роль')?>
<?= $form->field($model, 'description', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Описание')?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>