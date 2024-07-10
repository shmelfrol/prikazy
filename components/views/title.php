<?php
?>


<div style="margin-top: 20px; margin-bottom: 15px">
    <h1 style="font-weight: bold; font-size: 25px; <?php if($url){echo 'float: left;' ;}?> margin-right: 10px"><?php echo $title?></h1>
    <?php if(Yii::$app->user->can('prikaz create') === true): ?>
 <?php if($url):?>
    <div>
        <a href="<?php echo $url ?>"
           style="font-size: 20px; text-decoration: none; text-align: center;  background-color: #0a73bb; color: white; padding-bottom: 8px; padding-top: 5px; padding-left: 10px; padding-right: 10px; border-radius: 5px"><?php echo "+" ?></a>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>



