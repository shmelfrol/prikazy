<?php
use yii\helpers\Url;
?>







<div style="margin-top: 20px">
    <a href="<?php echo Yii::$app->request->referrer; ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
</div>
<p></p>


<h4><?php if(!empty($p->index->symbol)){ echo $p->numc." ".$p->index->symbol." ".$p->text;} else {echo $p->numc." ".$p->text;}  ; ?></h4>
<?php if($ext !== "pdf") : ?>
    <div style="margin-top: 20px; display: inline-block;" id="file" >

        <?= yii\helpers\Html::a('Прикрепленный файл', ['prikaz/download', 'filename' => $p->filename ], [
            'class' => 'btn btn-warning',
            'style' =>[

            ]]) ?>
    </div>

<?php else: ?>
    <div id="file" style="position: relative">

        <iframe src="<?php echo Url::toRoute(["read", 'id' => $p->id]); ?>" frameborder="0" class="pdf" ></iframe>
    </div>
<?php endif; ?>



<style>
    .pdf {
        width:100%;
        height: 500px;



    }



</style>