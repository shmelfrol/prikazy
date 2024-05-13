<?php
use yii\helpers\Url;
?>







<div>
    <a href="<?php echo Url::toRoute('/prikaz'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
</div>
<p></p>
<h4><?php if(!empty($p->index->symbol)){ echo $p->numc." ".$p->index->symbol." ".$p->text;} else {echo $p->numc." ".$p->text;}  ; ?></h4>
<iframe src="<?php echo Url::toRoute(["read", 'id' => $p->id]); ?>" frameborder="0" class="pdf" ></iframe>


<style>
    .pdf {
        width:100%;
        height: 500px;



    }



</style>