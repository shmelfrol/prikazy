<?php


use yii\helpers\Html;

if($update){
    $script = <<< JS
let btnAddCancel=document.getElementById("btn-add-cancel");
let btnAddEdit=document.getElementById("btn-add-edit");
let btnCloseModal = document.getElementById("btn-cancel");
let btnFindPrikazes = document.getElementById('find_prikazes');
let btnSubmit = document.getElementById('btn-submit');






var openModal = function(e){

    e.preventDefault();
   let modal = document.getElementById("prikaz-modal");
    //modal.style.top=window.scrollY +'px';
   modal.classList.add('active');
   let action_id =   this.getAttribute("name");
   console.log(action_id);
   let btnSubmit = document.getElementById('btn-submit');
   btnSubmit.setAttribute('name', action_id);
    let error_add_action=document.getElementById('error_add_action');
    error_add_action.innerHTML='';
    let div_for_ps = document.getElementById('finded_prikazes');
    div_for_ps.innerHTML='';
}

var closeModal = function(e){
    
 e.preventDefault();
    let modal = document.getElementById("prikaz-modal");
    modal.classList.remove('active');
    
}

var findPrikazes = function(){
    let indx = document.getElementById('droplist');
    let numc = document.getElementById('numc').value;
    let div_for_ps = document.getElementById('finded_prikazes');
    let index_id = indx.options[indx.selectedIndex].value;
    const urlParams = new URLSearchParams(window.location.search);
    let prikaz_id = urlParams.get('id')
    
     let url="/prikaz/get-prikazes?numc="+ numc + "&index_id="+index_id+"&current_p_id="+prikaz_id;
    if(numc!== ''){
         console.log(url)
          $.ajax({
  url: url,
  type: "GET",
  async: false,
  cache: false,
  contentType: "application/json; charset=utf-8", 
  success: function(data, textStatus, jqXHR) {
      var innerHtml = "";
     let res=JSON.parse(data);
    console.log(res);
    if(Array.isArray(res)){
        console.log('массив')
          if(res.length !== 0){
        res.forEach(function(e) {
	innerHtml += '<div class="f-prikazes" >' +
	 '<input type="checkbox" class="custom-checkbox" name="f_prikazes" id="'+e.id+'" /><label for="'+e.id+'">'+' '+e.numc+' '+ e.symbol+' '+e.reldate + ' ' + e.text+'</label></div>';
	div_for_ps.innerHTML=innerHtml;
	
})
    }
    } else{
         console.log('Не массив');
         div_for_ps.innerHTML='';
    }
    
  }
  }) 
              
    }
    
}

var addPrikazes = function(e){
     e.preventDefault();
     let hiddenPrikaz = document.getElementById('prikaz-hidden')
    console.log(hiddenPrikaz)
    
    let prikazes = document.getElementsByName('f_prikazes');
    let ids = [];
        prikazes.forEach(function(e) {
           if (e.checked===true){
               ids.push(e.id);
           }
        })
        console.log(ids)
        
        if(ids.length>0){
           const urlParams = new URLSearchParams(window.location.search);
           let prikaz_id = urlParams.get('id')
           console.log("prikaz_id:  "+prikaz_id)
            
            
            let action_id =   this.getAttribute("name");
           ids.forEach(function(id) {
                let url="/prikaz/modified-prikaz?prikaz_id="+ prikaz_id + "&action_id="+action_id+ "&modified_prikaz_id="+id;
                console.log(url)
             $.ajax({
  url: url,
  type: "GET",
  async: false,
  cache: false,
  contentType: "application/json; charset=utf-8", 
  success: function(data, textStatus, jqXHR) {
     let res=JSON.parse(data);
     let p_hidden = document.getElementById('prikaz-hidden');
     let cancel_list = document.getElementById('cancel-prikazes');
     let mod_list = document.getElementById('mod-prikazes');
      
    
    if(res === 'not'){
        let error_add_action=document.getElementById('error_add_action');
        if (action_id === "2"){
          error_add_action.innerHTML='Приказ уже отменен этим приказом или другим'  
        }
        if (action_id === "1"){
          error_add_action.innerHTML='Приказ уже изменен этим приказом'  
        }
         
        
    }else{
        console.log(res)
     let clone_p=p_hidden.cloneNode(true);
     clone_p.id="";
     clone_p.hidden=false;
     if(action_id === "2"){
        cancel_list.appendChild(clone_p); 
     }
     if(action_id === "1"){
        mod_list.appendChild(clone_p); 
     }
     
     console.log(clone_p);
     var children = clone_p.children;
     
     for(var i = 0; i < children.length; ++i)
    {
   
        console.log(children[i])
        if(children[i].classList.contains('prikaz-numc')){
            children[i].innerHTML=res.numc+" "+res.symbol;
        }
     if(children[i].classList.contains('prikaz-cancel')){
            children[i].href="/prikaz/del-modified?modified_prikaz_id="+res.id+"&prikaz_id="+prikaz_id+"&action_id="+action_id;
        }
     if(children[i].classList.contains('prikaz-image')){
         let img_href = children[i].querySelector('.prikaz-link');
          console.log(img_href);
          img_href.href='http://prikazy/prikaz/view?id='+res.id;
        }
     if(children[i].classList.contains('prikaz-reldate')){
            children[i].innerHTML=res.reldate;
        }
    if(children[i].classList.contains('prikaz-name')){
            children[i].innerHTML=res.text;
        }
     if(children[i].classList.contains('prikaz-status')){
            children[i].innerHTML=res.status;
            children[i].style.backgroundColor = res.color;
        }
    }
       
    }
      
  }
  })     
                
                
               
})
            
     
        }
        
}


btnAddCancel.addEventListener('click', openModal, false);
btnAddEdit.addEventListener('click', openModal, false);
btnCloseModal.addEventListener('click', closeModal, false);
btnFindPrikazes.addEventListener('click', findPrikazes, false);
btnSubmit.addEventListener('click', addPrikazes, false);

JS;
    $this->registerJS($script);
}



$p = new \app\models\PrikazCopy();
$p->numc=111;
$p->index_id=111;
$p->reldate=111;
$p->text=111;
$p->symbol=111;
$p->prikaz_id=111;
$p->color="1111";
$p->status_name="1111";
?>


<?php if($update): ?>
<div class="prikaz-modal" id="prikaz-modal">
    <div id="prikaz_id" name="<?php echo  $p->id ?>"></div>
    <div style="min-height: 50px; width: 100%; vertical-align: middle; ">
        <?php echo Html::dropDownList('droplist', 's', $indexes, [
                "id" => 'droplist',
               "class"=>'droplist-modal'
        ]); ?>
        <?php echo Html::input('index', 'numc', null, ["id" => 'numc',  "class"=>'input-modal']); ?>
        <?php echo Html::button('найти', ['id' => 'find_prikazes',  "class"=>'button-modal']); ?>
    </div>
    <div style="min-height: 100px; width: 100%;" id="finded_prikazes"></div>
    <div id="error_add_action"></div>
    <div style="min-height: 40px; width: 100%;"></div>
    <div style="position: absolute; right: 5px; bottom: 5px; ">
        <div style="margin: 5px; display: inline-block">
            <a href="#" class="btn btn-success" id="btn-cancel">Отмена</a>
        </div>
        <div style="margin: 5px ; display: inline-block">
            <a href="#" class="btn btn-success" id="btn-submit" name="0">Применить</a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php echo \app\components\PrikazOneWidget::widget(['p'=>$p, 'btndel'=>false, 'btnedit'=>false, 'heart'=>false, 'hidden'=>true, 'btncancel'=>true]) ?>

<?php if($update): ?>
<h4 style="margin-top: 20px;">
    Приказ отменяет следующие документы:
    <a href="#" class="btn btn-success" id="btn-add-cancel" name="2">Добавить</a>
</h4>
<div id="cancel-prikazes">
    <?php echo \app\components\PrikazListWidget::widget(['prikazes'=>$canceled, 'btndel'=>false, 'btnedit'=>false, 'btncancel'=>$update? true: false, 'heart'=>false, 'action_id'=>'2']); ?>
</div>
<?php endif; ?>
<?php if(!$update && !empty($canceled)): ?>
    <h4 style="margin-top: 20px;">Приказ отменяет следующие документы: </h4>
    <div id="cancel-prikazes">
        <?php echo \app\components\PrikazListWidget::widget(['prikazes'=>$canceled, 'btndel'=>false, 'btnedit'=>false, 'btncancel'=>$update? true: false, 'heart'=>false, 'action_id'=>'2']); ?>
    </div>
<?php endif; ?>


<?php if($update): ?>
<h4 style="margin-top: 20px">
    Приказ изменяет следующие документы: <a href="#" class="btn btn-success" id="btn-add-edit" name="1">Добавить</a>
</h4>
<div id="mod-prikazes">
    <?php echo \app\components\PrikazListWidget::widget(['prikazes'=>$modified, 'btndel'=>false, 'btnedit'=>false, 'btncancel'=>$update? true: false, 'heart'=>false, 'action_id'=>'2']); ?>
</div>
<?php endif; ?>
<?php if(!$update && !empty($modified)): ?>
    <h4 style="margin-top: 20px">Приказ изменяет следующие документы:</h4>
    <div id="mod-prikazes">
        <?php echo \app\components\PrikazListWidget::widget(['prikazes'=>$modified, 'btndel'=>false, 'btnedit'=>false, 'btncancel'=>$update? true: false, 'heart'=>false, 'action_id'=>'2']); ?>
    </div>
<?php endif; ?>


<?php if(!empty($modifing)): ?>
<h4>Приказ изменён следующими документами:</h4>
<?php echo \app\components\PrikazListWidget::widget(['prikazes'=>$modifing, 'btndel'=>false, 'btnedit'=>false, 'btncancel'=>false, 'heart'=>false, 'action_id'=>'2']); ?>
<?php endif; ?>

<?php if(!empty($canceling)): ?>
<h4>Приказ отменён следующими документами:</h4>
<?php echo \app\components\PrikazListWidget::widget(['prikazes'=>$canceling, 'btndel'=>false, 'btnedit'=>false, 'btncancel'=>false, 'heart'=>false, 'action_id'=>'2']); ?>
<?php endif; ?>


<style>


.input-modal{
    float: left;
    border-radius: 5px;
    height: 40px;
    width: 200px;
}
.droplist-modal{
    float: left;
    border-radius: 5px;
    height: 40px;
    margin-right: 10px;
}

.button-modal{
    float: right;
    border-radius: 5px;
    height: 40px;
    margin-left: auto;
    margin-right: 0;
    padding-right: 20px;
    padding-left: 20px;
}

.prikaz-modal {
    visibility: hidden;
    padding: 10px;
    width: 100%;
    max-width: 900px;
    border-radius: 3px;
    background-color: #e3e3e3;
    position: fixed;
    border: black 1px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 30; /* Должен быть выше чем у подложки*/
    box-shadow: 0 3px 10px -.5px rgba(0, 0, 0, .2);

}

    .prikaz-modal.active {
        opacity: 1;
        visibility: visible;
    }

    .input-prikaz {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .input-label {
        background-color: #e6ffea;
        color: white;
        padding: 5px;
        border-radius: 5px;
        cursor: pointer;

    }

    .input-label:hover {
        background-color: saddlebrown;

    }

    .f-prikazes {
        padding: 5px;
        background-color: white;
        border: grey;
        border-radius: 5px;
        margin: 5px;
        box-shadow: 0 3px 10px -.5px rgba(0, 0, 0, .2);

    }

    .hystmodal__opened {
        position: fixed;
        right: 0;
        left: 0;
        overflow: hidden;
    }


.custom-checkbox {
    position: absolute;
    z-index: -1;
    opacity: 0;

}

.custom-checkbox+label {
    display: inline-flex;
    align-items: center;
    user-select: none;
}

.custom-checkbox+label::before {
    content: '';
    display: inline-block;
    width: 1em;
    height: 1em;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #adb5bd;
    border-radius: 0.25em;
    margin-right: 0.5em;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
}
.custom-checkbox:checked+label::before {
    border-color: #0b76ef;
    background-color: #0b76ef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

/* стили при наведении курсора на checkbox */
.custom-checkbox:not(:disabled):not(:checked)+label:hover::before {
    border-color: #b3d7ff;
}
/* стили для активного состояния чекбокса (при нажатии на него) */
.custom-checkbox:not(:disabled):active+label::before {
    background-color: #b3d7ff;
    border-color: #b3d7ff;
}
/* стили для чекбокса, находящегося в фокусе */
.custom-checkbox:focus+label::before {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
/* стили для чекбокса, находящегося в фокусе и не находящегося в состоянии checked */
.custom-checkbox:focus:not(:checked)+label::before {
    border-color: #80bdff;
}
/* стили для чекбокса, находящегося в состоянии disabled */
.custom-checkbox:disabled+label::before {
    background-color: #e9ecef;
}


</style>