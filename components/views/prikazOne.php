<?php

use yii\helpers\Url;

/* @var $prikazes array */
/* @var  $hidden  boolean*/
/* @var  $btndel  boolean*/
/* @var  $btncancel  boolean*/
/* @var  $btnedit  boolean*/
/* @var  $heart  boolean*/
/* @var  $action_id  integer*/




?>
    <div class="prikaz-box" <?php  echo $hidden ? 'hidden id="prikaz-hidden"': ''; ?>>
        <div class="prikaz-image">
            <a class="prikaz-link" href="<?php echo Url::toRoute(["view", 'id' => $p->id]); ?>"><img src="/images/prikaz.svg" width="64" height="64" alt="prikaz logo"></a>
        </div>
        <div class="prikaz-numc"><?php echo $p->numc; ?> <?php echo $p->symbol; ?></div>
        <div class="prikaz-reldate"><?php echo Yii::$app->formatter->asDate($p->reldate, 'php:d.m.Y'); ?></div>
        <div style="display: inline-block;" >
            <div class="prikaz-name name"><?php echo $p->text; ?></div>
        </div>

        <?php if($btndel === true):?>
        <?php if(Yii::$app->user->can('prikaz del') === true): ?>
            <a class="prikaz-del"
               href="<?php echo Url::toRoute(["del", 'id' => $p->id]); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg>
            </a>
        <?php endif; ?>
        <?php endif; ?>
        <?php if($btncancel === true):?>
            <a class="prikaz-cancel"
               href="<?php echo Url::toRoute(["del-modified", 'modified_prikaz_id' => $p->id, 'prikaz_id' => $p->id, 'action_id'=>$action_id]); ?>">&#10006;</a>
        <?php endif; ?>


         <?php if($btnedit === true):?>
        <?php if(Yii::$app->user->can('prikaz create') === true): ?>
             <div style="position: absolute; right: 8px; bottom: 5px;">
                 <?php echo \app\components\PencilWidget::widget(['url'=>'update', 'params'=>['id'=>$p->id]]) ?>
             </div>
        <?php endif; ?>
         <?php endif; ?>
        <div class="prikaz-status-div" >
            <?php echo \app\components\PrikazStatusWidget::widget(['status_name'=>$p->status_name, 'small'=>true, 'color'=>$p->color]) ?>

        </div>
        <?php if($heart): ?>
        <div style="position: absolute; bottom: 5px;left: 102px;">
            <?php echo \app\components\FavIconWidget::widget(['p'=>$p]) ?>
        </div>
        <?php endif; ?>
        <div style="position: absolute; bottom: 5px;left: 256px;">
            <?php foreach ($divisions as $d): ?>
              <?php echo \app\components\DivisionWidget::widget(['name'=>$d['name'], 'color'=>$d['color'], 'small'=>true]); ?>
            <?php endforeach; ?>
        </div>



    </div>

<!--"/images/heart.png" : "/images/heart2.png"-->


<style>
    .prikaz-status-div {
        position: absolute;
        bottom: 5px;
        left: 154px;
    }




    .prikaz-box {
        display: flex;
        align-items: center;
        padding: 10px;
        box-shadow: 5px 5px 5px 1px grey;
        margin-bottom: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.175);
        position: relative
    }
    .prikaz-image {
        display: inline-block;
        text-align: center
    }
    .prikaz-numc {
        display: inline-block;
        text-align: center;
        font-size: large;
        font-weight: bold;
        width: 80px;
    }
    .prikaz-reldate {
        display: inline-block;
        text-align: left;
        font-size: large;
        font-weight: bold;
        padding-right: 10px;
    }

    .prikaz-del{
        text-decoration: none;
        color:black;
        position: absolute;
        right: 8px;
        top: 5px;
    }
    .prikaz-cancel{
        text-decoration: none;
        color:black;
        position: absolute;
        right: 16px;
        bottom: 25px;
    }



    .shadow {
        box-shadow: 5px 5px 5px 1px grey
    }

    .name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 600px;
        align-items: ;

    }

    @media (max-width: 1000px) {
        .name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;

        }
    }

    @media (max-width: 770px) {
        .name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 230px;

        }
    }

    @media (max-width: 530px) {
        .name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;

        }

        @media (max-width: 466px) {
            .name {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 180px;

            }
        }

</style>