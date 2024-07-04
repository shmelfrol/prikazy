<?php

$reldate = Yii::$app->formatter->asDate($p->reldate, 'php:d.m.Y');
$number = !empty($p->index->symbol) ? $p->numc . " " . $p->index->symbol . " " : $p->numc . " ";

?>
<div style="margin-bottom: 10px">

    <div style="background-color: <?php echo $p->status->color ?>; border-radius: 5px; padding: 5px 8px 5px 8px; color: white; display: flex;  justify-content: space-between; font-size: small">
        <div ><?= $p->status->status_name ?></div><div> <img class="heart" id="<?php echo $p->id; ?>" alt="heart" src="<?php echo $p->prikaz_id ? "/images/star.png" : "/images/star2.png"; ?>" width="20" height="20" /></div>
    </div>

    <div style="display: inline-block">
        <h4><?php echo $reldate.' Приказ №'.$number."".$p->text ?></h4>
    </div>

</div>


