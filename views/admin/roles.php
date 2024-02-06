<?php

use yii\helpers\Url;
?>
<div>
    <a href="<?php echo Url::toRoute('/admin'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
</div>
<h1>Роли</h1>


<div class="row"  style="padding: 8px">
    <?php foreach($rolesBased as $role): ?>
        <div class="col-sm-6 col-md-4" style="border: 1px solid; border-radius: 5px; margin: 5px; position: relative">
            <div class="thumbnail">
                <div class="caption">
                    <h3><?php echo $role->name ?></h3>
                    <p>Описание: <?php echo $role->description ?></p>
                    <?php foreach ($role->permissions as $p): ?>
                   <div>&#8226; <?php  echo $p->name  ?>&#8195;</div>
                <?php endforeach ?>
                    <br>
                    <a href="<?php echo Url::toRoute(["role", 'name'=> $role->name]); ?>" class="btn btn-primary bt" style="position: absolute; bottom: 5px; right: 5px" role="button">Изменить</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <p></p>
</div>
<div>
    <a href="<?php echo Url::toRoute('add-role'); ?>" class="btn btn-danger"><?php echo "Добавить новую роль" ?></a>
</div>

