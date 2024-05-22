<?php
use yii\helpers\Url;

?>
<?php echo \app\components\BackButtonWidget::widget(['url'=>Url::toRoute('/admin')]) ?>
<?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('add-user'),'title' =>'Пользователи']) ?>


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
