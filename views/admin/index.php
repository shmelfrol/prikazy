<?php

use yii\helpers\Url;
?>
<?php echo \app\components\PageTitle::widget([ 'title' =>'Админ панель']) ?>
<?php foreach($urls as $url): ?>
    <a href="<?php echo Url::toRoute($url->url); ?>" style="text-decoration: none; color: white">

<div style="padding: 20px; margin: 10px; border-radius: 5px; font-size: 25px; background-color: #1d6892; font-weight: bold">
    <img src="<?php echo $url->img ?>" width="64" height="64">
   <?php echo $url->name ?>
</div>
    </a>
<?php endforeach ?>
