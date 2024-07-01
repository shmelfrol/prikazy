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

<div id="prikaz-list">
    <?php foreach ($prikazes as $p): ?>

        <?php echo \app\components\PrikazOneWidget::widget(['p'=>$p, 'btndel'=>$btndel, 'btnedit'=>$btnedit, 'btncancel'=>$btncancel, 'heart'=>$heart, 'action_id'=>$action_id]) ?>
    <?php endforeach; ?>
</div>



