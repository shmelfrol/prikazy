<?php

use yii\helpers\Url;
?>
<?php foreach($urls as $key=>$val): ?>
    <a href="<?php echo Url::toRoute($key); ?>" style="text-decoration: none; color: white">
<div style="padding: 20px; margin: 10px; border-radius: 5px; font-size: 20px; background-color: #0a58ca;">
   <?php echo $val ?>
</div>
    </a>
<?php endforeach ?>
