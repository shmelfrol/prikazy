<?php
/* @var $actions array */

use yii\helpers\Url;

?>
<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin')]) ?>
<?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('add-action'),'title' =>'Стаусы приказов']) ?>

<table >

    <?php foreach ($actions as $a): ?>
        <tr>
            <td style="padding: 5px"><h4><?php echo $a->id  ?></h4></td>
            <td style="padding: 5px"><h4><?php echo $a->status_name  ?></h4></td>
            <td style="padding: 5px"><div style="background-color: <?php echo $a->color; ?>; width: 30px; height: 30px; border-radius: 5px"></div></td>
            <td style="padding-bottom: 10%"><?php echo \app\components\PencilWidget::widget(['url'=>'action-update', 'params'=>['id'=>$a->id]]) ?></td>

        </tr>
    <?php endforeach; ?>

</table>

