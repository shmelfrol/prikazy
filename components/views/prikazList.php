<?php

use yii\helpers\Url;

/* @var $prikazes array */

$this->registerJsFile('@web/js/fav.js',
    [
        'position' => $this::POS_END
    ]
);


?>

<div id="prikaz-list">
    <?php foreach ($prikazes as $p): ?>

        <?php echo \app\components\PrikazOneWidget::widget(['p'=>$p, 'btndel'=>$btndel, 'btnedit'=>$btnedit, 'btncancel'=>$btncancel, 'heart'=>$heart, 'action_id'=>$action_id]) ?>
    <?php endforeach; ?>
</div>



