<?php


?>
<?php use yii\bootstrap5\LinkPager;
use yii\helpers\Url;


echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/logging')]) ?>
<?php echo \app\components\PageTitle::widget(['title' =>'Системные логи']) ?>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Дата</th>
        <th scope="col">Событие</th>
        <th scope="col">Пользователь</th>
        <th scope="col">Текст</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $l): ?>
    <tr>
        <td scope="row"><?php echo Yii::$app->formatter->asDate($l->date, 'php:d.m.Y');?></td>
        <td scope="row"><?php echo $l->event->name ?></td>
        <td scope="row"><?php echo $l->user->username ?></td>
        <td scope="row"><?php echo $l->text ?></td>

    </tr>

    <?php endforeach; ?>
    </tbody>




</table>


<?= LinkPager::widget([
    'pagination' => $pages,
]); ?>




