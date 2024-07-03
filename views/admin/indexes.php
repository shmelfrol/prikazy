<?php

use yii\helpers\Url;

?>
<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin')]) ?>
<?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('add-index'),'title' =>'Индексы приказов']) ?>


<?php foreach ($indexes as $indx): ?>
    <div class="card" style="padding: 5px; margin-bottom: 5px; margin-top: 5px">
        <div style="font-size: large; font-weight: bold"><?php echo $indx->symbol; ?> <?php if ($indx->isold) {echo '(устарел)';} ?></div>
        <div style="font-size: small"><?php echo $indx->description; ?></div>
        <div style="font-size: xx-small">Созднан: <?php echo date("Y-m-d H:i:s", $indx->created_at); ?></div>
       <div> <a href="<?php echo Url::toRoute(["del-index", 'id' =>  $indx->id]); ?>"
                style="text-decoration: none; color:black; position: absolute; bottom: 4px; right: 4px">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-trash-fill" viewBox="0 0 16 16">
                   <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
               </svg>
           </a></div>
    </div>
<?php endforeach; ?>
