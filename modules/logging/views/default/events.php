<?php
use yii\helpers\Url;
?>



<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/logging')]) ?>
<?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('add-event'),'title' =>'События логирования']) ?>

<?php foreach($events as $e): ?>

<div style="background-color: grey; padding: 5px; margin: 10px; border-radius: 5px; color: white; width: 300px; font-size: medium"><?php echo $e->name ?></div>


<?php endforeach ?>
