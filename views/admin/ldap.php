<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
    <div>
        <a href="<?php echo Url::toRoute('/admin'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
    </div>
    <p></p>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'account_suffix', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('account_suffix')?>
<?= $form->field($model, 'hosts', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('hosts')?>
<?= $form->field($model, 'base_dn', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('base_dn')?>
<?= $form->field($model, 'username', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('username')?>
<?= $form->field($model, 'password', ['labelOptions' => ['class' => 'text-last'], 'inputOptions' => ["class" => 'form-control','readonly' => false]])->label('password')?>
<?= $form->field($model, 'turnon')->checkbox([
    'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
]) ?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>