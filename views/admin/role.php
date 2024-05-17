<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>


    <div style="margin-top: 20px">
        <a href="<?php echo Url::toRoute('/admin/roles'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
    </div>

<?php




?>




<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'name', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => true]])->label('Роль')?>
<?= $form->field($model, 'description', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('Описание')?>
<?= $form->field($model, 'permissions')->checkboxList($perms)->label("Разрешения") ?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>