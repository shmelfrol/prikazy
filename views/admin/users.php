<?php
use yii\helpers\Url;

?>
<div style="margin-bottom: 5px">
    <a href="<?php echo Url::toRoute('/admin'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
</div>
<h1>Пользователи</h1>
<div class="table-responsive">
    <table class="table table-bordered">

        <thead>
        <tr>
            <th>№ </th>
            <th>Id</th>
            <th>Login</th>
            <th>Роли</th>
            <th>Статус</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1 ?>
        <?php foreach($users as $u): ?>
        <tr>
            <td style="width: 1%; white-space: nowrap;"><?php echo $i ?></td>
            <td style="width: 1%; white-space: nowrap;"><?php echo $u->id ?></td>
            <td><?php echo $u->username ?></td>

            <td>
                <?php foreach ($u->roles as $r): ?>
                    &#8226; <?php echo $r; ?><br>
                <?php endforeach ?>
            </td>
            <td></td>
            <td style="width: 1%; white-space: nowrap;"> <a href="<?php echo Url::toRoute(["user-update", 'id'=> $u->id]); ?>" class="btn btn-primary"  role="button">Изменить</a></td>
        </tr>
            <?php $i++ ?>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<div style="margin-bottom: 5px">
    <a href="<?php echo Url::toRoute('add-user'); ?>" class="btn btn-danger"><?php echo "Добавить нового пользователя" ?></a>
</div>