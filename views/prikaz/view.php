<?php
use yii\helpers\Url;


$this->registerJsFile('@web/js/fav.js',
    [
        'position' => $this::POS_END
    ]
);

?>


<?php echo \app\components\BackButtonWidget::widget(['url' => (Url::to(['/prikaz', 'year' => $y, 'month' => $m]))]) ?>


<div style="display: flex; align-items: center;justify-content: space-between">
    <?php echo \app\components\PrikazStatusWidget::widget(['status_name'=>$p->status_name, 'color'=>$p->color]) ?>
    <?php echo \app\components\ForDivisionsWidget::widget(['divisions'=>$divisions, 'checked_ids'=>$checked_ids]) ?>
    <?php echo \app\components\FavIconWidget::widget(['p'=>$p]) ?>

</div>

<?php echo \app\components\PrikazTitle::widget(['p'=>$p]); ?>

<?php if ($ext !== "pdf" || isMobile()) : ?>
    <?php echo \app\components\FileDownloadBtnWidget::widget(['file'=>$p->filename, ]) ?>
<?php else: ?>
    <?php echo \app\components\FileIframePDFWidget::widget(['prikaz_id'=>$p->id, ]) ?>
<?php endif; ?>

<?php echo \app\components\ModifiedPrikazListWidget::widget(['p'=>$p, 'canceled'=>$canceled, 'modified'=>$modified, 'canceling'=>$canceling, 'modifing'=>$modifing, 'update'=>false]) ?>


<style>
    .pdf {
        width:100%;
        height: 500px;



    }



</style>