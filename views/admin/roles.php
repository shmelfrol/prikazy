<?php

use yii\helpers\Url;

?>
<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin')]) ?>
<?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('add-role'),'title' =>'Роли']) ?>

<div class="row " style="padding: 8px">
    <?php foreach ($rolesBased as $role): ?>
        <div class="col-sm-6 col-md-4 card" style=" border-radius: 5px; box-shadow: 5px 5px 5px 1px grey; margin: 5px; position: relative; :hover {
  color: #00B3FF;
}">
            <div class="thumbnail">
                <div class="caption">
                    <div>
                        <h3 style="display: inline"><?php echo $role->name ?></h3>
                        <h3 style="display: inline">
                            <a href="<?php echo Url::toRoute(["role", 'name' => $role->name]); ?>"
                               style="text-decoration: none; color:blue; " role="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </a>
                        </h3>
                    </div>


                    <p>Описание: <?php echo $role->description ?></p>
                    <?php foreach ($role->permissions as $p): ?>
                        <div>&#8226; <?php echo $p->name ?>&#8195;</div>
                    <?php endforeach ?>
                    <br>
                    <a href="<?php echo Url::toRoute(["del-role", 'name' => $role->name]); ?>"
                       style="text-decoration: none; color:black; position: absolute; bottom: 4px; right: 4px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                    </a>


                </div>
            </div>
        </div>
    <?php endforeach ?>
    <p></p>
</div>

<style>
    .card:hover {
        background-color: lightyellow;
    }
</style>
