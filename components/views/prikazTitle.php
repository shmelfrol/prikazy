<?php

$reldate = Yii::$app->formatter->asDate($p->reldate, 'php:d.m.Y');
$number = !empty($p->index->symbol) ? $p->numc . " " . $p->index->symbol . " " : $p->numc . " ";

?>
<div style="margin-bottom: 3px">
    <div style="display: inline-block">
        <h4><?php echo $reldate.' Приказ №'.$number."".$p->text ?></h4>
    </div>

</div>


