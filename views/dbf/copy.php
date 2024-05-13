<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


$script = <<< JS



$('#clickButton1').on('click', function() {
  

  var prikazes=[];
  $.ajax({
  url: "old",
  type: "GET",
  data: "okk",
  async: false,
  cache: false,
  contentType: "application/json; charset=utf-8", 
  success: function(data, textStatus, jqXHR) {
      prikazes=JSON.parse(data);
      
      alert("Выполнен")
      if (Array.isArray(prikazes)){
          console.log("ARRRAAAAY!!!")
          console.log(prikazes.length)
      }else {
          console.log(typeof prikazes)
      }
  
  }
  })
  console.log("111111111111111111111111111")
  let i=0
     for(let i=0; i<= prikazes.length; i++ ){
         
   //console.log(prikazes[i])
   let url="create?id=" + prikazes[i]
   $.ajax({
  url: url,
  type: "GET",
  async: false,
  cache: false,
  contentType: "application/json; charset=utf-8", 
  success: function(data, textStatus, jqXHR) {
     let res=JSON.parse(data);
     if(res!=='yes'){
         console.log(res)
     }
     
  }
  })
   
         
         
     }

  
})

JS;
$this->registerJS($script);

?>





<?= Html::submitButton('publish', ['class' => 'btn btn-success save-post', 'id' => 'clickButton1']) ?>