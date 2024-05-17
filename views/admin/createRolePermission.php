<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

    <div style="margin-top: 20px">
        <a href="<?php echo Url::toRoute('/admin/permissions'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
    </div>
    <p></p>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>