<?php
/* @var $name string */

use yii\helpers\Url;

/* @var $isold boolean */
/* @var $description string */
/* @var $color string */
/* @var $created_at integer */
/* @var $del_url string */
/* @var $update_url string */
/* @var $id integer */


?>



    <div class="card" style="padding: 5px; margin-bottom: 5px; margin-top: 5px">
        <div style="font-size: large; font-weight: bold">

        <a href="<?php echo Url::toRoute([$update_url, 'id' =>  $id]); ?>" style="text-decoration: none">
            <?php echo $name; ?> <?php if ($isold) {echo '(устарел)';} ?>
        </a>
        </div>
        <div style="font-size: small"><?php echo $description; ?></div>
        <div style="font-size: xx-small">Созднан: <?php echo date("Y-m-d H:i:s", $created_at); ?></div>
        <div> <a href="<?php echo Url::toRoute([$del_url, 'id' =>  $id]); ?>"
                 style="text-decoration: none; color:black; position: absolute; bottom: 4px; right: 4px">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg>
            </a></div>
        <?php if($color): ?>
            <div style="position: absolute; top: 4px; right: 4px; background-color: <?php echo $color ;?>; width: 30px; height: 30px; border-radius: 5px"></div>
        <?php endif; ?>
    </div>


