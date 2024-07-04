<?php
use yii\helpers\Url;


$this->registerJsFile('@web/js/fav.js',
    [
        'position' => $this::POS_END
    ]
);

?>


<?php echo \app\components\BackButtonWidget::widget(['url' => (Url::to(['/prikaz', 'year' => $y, 'month' => $m]))]) ?>




<?php echo \app\components\PrikazTitle::widget(['p'=>$p]); ?>

<?php if($ext !== "pdf") : ?>
    <div style="margin-top: 20px; display: inline-block;" id="file" >

        <?= yii\helpers\Html::a('Прикрепленный файл', ['prikaz/download', 'filename' => $p->filename ], [
            'class' => 'btn btn-warning',
            'style' =>[]
        ]) ?>
    </div>

<?php else: ?>
    <div id="file" style="position: relative">

        <iframe src="<?php echo Url::toRoute(["read", 'id' => $p->id]); ?>" frameborder="0" class="pdf" ></iframe>
    </div>
<?php endif; ?>

<?php echo \app\components\ModifiedPrikazListWidget::widget(['p'=>$p, 'canceled'=>$canceled, 'modified'=>$modified, 'canceling'=>$canceling, 'modifing'=>$modifing, 'update'=>false]) ?>


<style>
    .pdf {
        width:100%;
        height: 500px;



    }



</style>