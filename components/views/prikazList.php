<?php

use yii\helpers\Url;

/* @var $prikazes array */

$script = <<< JS

var elements = document.getElementsByClassName("heart");

var myFunction = function() {
    var id = this.getAttribute("id");
    var src = this.getAttribute("src");
    let heart = document.getElementById(id);
    if(src==="/images/heart2.png"){
       let url="/prikaz/favorite?id=" + id
   $.ajax({
  url: url,
  type: "GET",
  async: false,
  cache: false,
  contentType: "application/json; charset=utf-8", 
  success: function(data, textStatus, jqXHR) {
     let res=JSON.parse(data);
     if(res==='ok'){
         console.log("ok")
        heart.src="/images/heart.png"
     }
  }
  })
    }
    
    
     if(src==="/images/heart.png"){
          let url="/prikaz/delfav?id=" + id
   $.ajax({
  url: url,
  type: "GET",
  async: false,
  cache: false,
  contentType: "application/json; charset=utf-8", 
  success: function(data, textStatus, jqXHR) {
     let res=JSON.parse(data);
     if(res==='ok'){
         heart.src="/images/heart2.png"
     }
  }
  }) 
         
        
        
        
    }
   
};

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}


JS;
$this->registerJS($script);


?>


<?php foreach ($prikazes as $p): ?>
    <div style="padding: 5px; box-shadow: 5px 5px 5px 1px grey; margin-bottom: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid rgba(0, 0, 0, 0.175); position: relative">
        <div style="display: inline-block; text-align: center"><a
                href="<?php echo Url::toRoute(["view", 'id' => $p->id]); ?>"><img src="/images/kubstu.png"
                                                                                  width="64" height="64"></a></div>
        <div style="display: inline-block; text-align: center; font-size: large; font-weight: bold;  width: 100px; "><?php echo $p->numc; ?> <?php echo $p->symbol; ?></div>
        <div style="display: inline-block; text-align: center; font-size: medium; "
             class="name"><?php echo $p->text; ?></div>
        <?php if($btndel === true):?>
        <?php if(Yii::$app->user->can('prikaz del') === true): ?>
            <a style="text-decoration: none; color:black; position: absolute; right: 4px"
               href="<?php echo Url::toRoute(["del", 'id' => $p->id]); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg>
            </a>
        <?php endif; ?>
        <?php endif; ?>
         <?php if($btnedit === true):?>
        <?php if(Yii::$app->user->can('prikaz create') === true): ?>
            <a style="text-decoration: none; color:black; position: absolute; right: 4px; bottom: 7px;"
               href="<?php echo Url::toRoute(["update", 'id' => $p->id]); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-pencil-fill" viewBox="0 0 16 16">
                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                </svg>
            </a>
        <?php endif; ?>
         <?php endif; ?>
        <p style="text-decoration: none; color:black; font-size: small; position: absolute; bottom: -15px;left: 177px; ">
            <?php echo Yii::$app->formatter->asDate($p->reldate, 'php:d.m.Y'); ?>
        </p>
        <div style="text-decoration: none; color:black; font-size: small; position: absolute; bottom: 7px;left: 115px; "
             xmlns="http://www.w3.org/2000/svg">
            <img class="heart" id="<?php echo $p->id; ?>"
                 src="<?php echo $p->prikaz_id ? "/images/heart.png" : "/images/heart2.png"; ?>" width="20" height="20">
        </div>


    </div>

<?php endforeach; ?>


<style>
    .shadow {
        box-shadow: 5px 5px 5px 1px grey
    }

    .name {

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 600px;

    }

    @media (max-width: 1000px) {
        .name {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;

        }
    }

    @media (max-width: 530px) {
        .name {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;

        }

        @media (max-width: 466px) {
            .name {
                display: inline-block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 180px;

            }
        }

</style>