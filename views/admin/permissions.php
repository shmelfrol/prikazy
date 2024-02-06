<?php

use yii\helpers\Url;
?>

<div>
    <a href="<?php echo Url::toRoute('/admin'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
</div>
<p></p>
<h1>Разрешения</h1>

<div class="row" style="padding: 8px">
    <?php foreach($perms as $perm): ?>
        <div class="col-sm-6 col-md-4" style="border: 1px solid; border-radius: 5px; margin: 5px; position: relative">
            <div class="thumbnail">
                <div class="caption">
                    <h3><?php echo $perm->name ?></h3>
                    <p>Описание: <?php echo $perm->description ?></p>
                    <br>
                    <a href="<?php echo Url::toRoute(["permission", 'name'=> $perm->name]); ?>" class="btn btn-primary bt" style="position: absolute; bottom: 5px; right: 5px" role="button">Изменить</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <p></p>
</div>
<div>
    <a href="<?php echo Url::toRoute('add-permission'); ?>" class="btn btn-danger"><?php echo "Добавить новое разрешение" ?></a>
</div>