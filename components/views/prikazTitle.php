<?php

$reldate = Yii::$app->formatter->asDate($p->reldate, 'php:d.m.Y');
$number = !empty($p->index->symbol) ? $p->numc . " " . $p->index->symbol . " " : $p->numc . " ";

?>
<div style="margin-bottom: 10px">

    <div style="background-color: <?php echo $p->status->color ?>; border-radius: 5px; padding: 5px; color: white; display: block; font-size: small">
        <?= $p->status->status_name ?>
    </div>

    <div style="display: inline-block">
        <h4><?php echo $reldate.' Приказ №'.$number."".$p->text ?></h4>
    </div>

</div>


