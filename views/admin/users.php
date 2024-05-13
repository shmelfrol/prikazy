<?php
use yii\helpers\Url;

?>
<div style="margin-top: 20px">
    <a href="<?php echo Url::toRoute('/admin'); ?>" class="btn btn-success">&#8592; <?php echo "Назад" ?></a>
</div>
<div style="margin-top: 15px; margin-bottom: 15px">
    <h1 style="font-weight: bold; font-size: 25px; float: left; margin-right: 10px">Пользователи</h1>
    <div>
        <a href="<?php echo Url::toRoute('add-user'); ?>"
           style="font-size: 20px; text-decoration: none; text-align: center;  background-color: #0a73bb; color: white; padding-bottom: 8px; padding-top: 5px; padding-left: 10px; padding-right: 10px; border-radius: 5px"><?php echo "+" ?></a>
    </div>
</div>

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
            <td style="width: 1%; white-space: nowrap;">
                <a href="<?php echo Url::toRoute(["user-update", 'id'=> $u->id]); ?>" style="text-decoration: none; margin-right: 10px"  role="button">	&#9998;</a>
                <a href="<?php echo Url::toRoute(["del-user", 'id'=> $u->id]); ?>" style="text-decoration: none"  role="button">	&#10060;</a>
            </td>
        </tr>
            <?php $i++ ?>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
