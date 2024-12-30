<?php
use yii\helpers\Url;

?>

<div id="file" style="position: relative">
    <?php if($trashIcon): ?>
    <div style="position: absolute; right: 11px; top: -25px" >
        <?php echo \app\components\TrashIconWidget::widget([]); ?>
    </div>
    <?php endif; ?>
    <p></p>
    <iframe src="<?php echo Url::toRoute(["read", 'id' => $prikaz_id]); ?>" frameborder="0" class="pdf" ></iframe>
</div>
