<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$script = <<< JS

var elements = document.getElementsByClassName("heart");

var myFunction = function() {
    var id = this.getAttribute("id");
    var src = this.getAttribute("src");
    let heart = document.getElementById(id);
    if(src==="/images/heart2.png"){
        console.log(id)
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

<div style="margin-top: 15px; margin-bottom: 15px; padding-bottom: 20px;">
    <h1 style="font-weight: bold; font-size: 25px; float: left; margin-right: 10px">Избранное</h1>


</div>


<?php foreach ($prikazes as $p): ?>
    <div class="shadow" style="padding: 5px; margin-bottom: 5px; margin-top: 5px; border-radius: 5px; border: 1px solid; position: relative">
        <div style="display: inline-block; text-align: center"><a href="<?php echo Url::toRoute(["view", 'id' => $p->id]); ?>"><img src="/images/kubstu.png" width="64" height="64"></a></div>
        <div style="display: inline-block; text-align: center; font-size: large; font-weight: bold;  width: 100px; "><?php echo $p->numc; ?> <?php echo $p->symbol; ?></div>
        <div style="display: inline-block; text-align: center; font-size: medium; " class="name"><?php echo $p->text; ?></div>
        <a style="text-decoration: none; color:black; position: absolute; right: 4px"
           href="<?php echo Url::toRoute(["del", 'id' => $p->id]); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
            </svg>
        </a>
        <p style="text-decoration: none; color:black; font-size: small; position: absolute; bottom: -15px;left: 177px; ">
            <?php echo Yii::$app->formatter->asDate($p->reldate,'php:d.m.Y');?></p>
        <div style="text-decoration: none; color:black; font-size: small; position: absolute; bottom: 7px;left: 115px; " xmlns="http://www.w3.org/2000/svg">
            <img  class="heart" id="<?php echo $p->id; ?>" src="<?php echo $p->prikaz_id ? "/images/heart.png": "/images/heart2.png"; ?>" width="20" height="20"></div>



    </div>

<?php endforeach; ?>

<style>
    .shadow {
        box-shadow:
                0 0 0 1px rgb(255, 255, 255),
                0.3em 0.3em 1em rgba(0, 0, 0, 0.3);
    }
    .name {

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 600px;

    }
    @media (max-width: 900px) {
        .name {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;

        }


    }

</style>
