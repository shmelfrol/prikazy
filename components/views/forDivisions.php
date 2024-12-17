<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
$script = <<< JS

let checkboxes=document.getElementsByName('divisions[]')
let btnAddDivisions = document.getElementById('btn-add-divisions')
let btnOpenModalDivisionList = document.getElementById('btn-open-modal-division-list')
let btnCloseModalDivision = document.getElementById('btn-close-modal-division')




var addDivisions = function(e){
    let params = (new URL(document.location)).searchParams;
    let prikaz_id=params.get('id');
     e.preventDefault();
     let ids_devisions=[];
     if(checkboxes.length > 0){
         checkboxes.forEach((e)=>{
            if(e.checked){
                ids_devisions.push(e.value)
            }
         });
        arrStr = encodeURIComponent(JSON.stringify(ids_devisions));
       // console.log(arrStr)
         let url="/prikaz/add-divisions?prikazId="+prikaz_id+"&divisions=" + arrStr;
         $.ajax({
            url: url,
            type: "GET",
            async: false,
            cache: false,
            contentType: "application/json; charset=utf-8",
            success: function(data, textStatus, jqXHR) {
                console.log(data);
                let res=JSON.parse(data);
                console.log(textStatus)
                let hiddenDivision = document.getElementById('division-hidden')
                let division_list = document.getElementById('division-list')
                division_list.innerHTML='';
               console.log(typeof(res));
                if(Object.keys(res).length != 0){
                    for (const key in res) {
                    
                   let clone_p=hiddenDivision.cloneNode(true);    
                    console.log(key + ':', res[key]);
                    clone_p.id="";
                    clone_p.hidden=false;
                    clone_p.innerHTML=key;
                    clone_p.style.backgroundColor=  res[key];
                    console.log(clone_p);
                    division_list.appendChild(clone_p); 
                    
                } 
                }
               
                   
                
                
            }
        })
     }
     let modal = document.getElementById('division-modal');
     modal.hidden=true;
    
}

var openModalDivisionList = function (){
    let modal = document.getElementById('division-modal');
    
    if(modal.hidden){
        modal.hidden=false;
    }else {
        modal.hidden=true;
    }
}



btnAddDivisions.addEventListener('click', addDivisions, false)
btnOpenModalDivisionList.addEventListener('click', openModalDivisionList, false)
btnCloseModalDivision.addEventListener('click', openModalDivisionList, false)

JS;
$this->registerJS($script);
?>




<?php echo \app\components\DivisionWidget::widget(['name'=>'hidden', 'color'=>'null', 'hidden'=>true]); ?>
<div style="display: flex; align-items: center;">
    <div style="display: flex; align-items: center;" id="division-list">
        <?php foreach ($divisions as $d): ?>
            <?php if(in_array($d['id'], $checked_ids)): ?>
                <?php echo \app\components\DivisionWidget::widget(['name'=>$d['short_name'], 'color'=>$d['color']]); ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php if($plus): ?>
    <a href="#"  id="btn-open-modal-division-list" name="1"><div class="plus radius" ></div> </a>
    <?php endif; ?>
</div>

<div class="division-modal" id="division-modal" hidden>
    <div id="error_add_action"></div>
    <div style="text-align: center"><h4>Подразделения</h4></div>
    <div style="min-height: 40px; width: 100%;">


        <?php
        $list = ArrayHelper::map($divisions, 'id', 'name');

        echo Html::checkboxList('divisions', $checked_ids, $list, [
            'item' => function ($index, $label, $name, $checked, $value) {
                $check= $checked ? "checked":'';
                $return = '<br><label>';
                $return .= '<input type="checkbox" name="' . $name . '" value="' . $value . '" ' . $check  . ' id="check-' . $index . '" />';
                $return .= '<span>' . ucwords($label) . '</span>';
                $return .= '</label>';
                return $return;
            },
        ]); ?>
    </div>

    <div style="position: absolute; right: 5px; bottom: 5px; ">
        <div style="margin: 5px; display: inline-block">
            <a href="#" class="btn btn-danger" id="btn-close-modal-division">Отмена</a>
        </div>
        <div style="margin: 5px ; display: inline-block">
            <a href="#" class="btn btn-success" id="btn-add-divisions" name="0">Применить</a>
        </div>
    </div>
</div>


<style>
    .division-modal {
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
        box-shadow: 1px 3px 10px -.5px rgba(0, 0, 0, .2);
    }



    .plus {
        display:inline-block;
        width:30px;
        height:30px;
        background:
                linear-gradient(#fff,#fff),
                linear-gradient(#fff,#fff),
                #0a53bd;
        background-position:center;
        background-size: 50% 2px,2px 50%; /*thickness = 2px, length = 50% (25px)*/
        background-repeat:no-repeat;
        margin: 5px;
    }

    .plus:hover {
        display:inline-block;
        width:30px;
        height:30px;
        background:
                linear-gradient(#1c1c1c, #1c1c1c),
                linear-gradient(#1c1c1c, #1c1c1c),
                #765fff;
        background-position:center;
        background-size: 50% 2px,2px 50%; /*thickness = 2px, length = 50% (25px)*/
        background-repeat:no-repeat;
        margin: 5px;
    }

    .radius {
        border-radius:50%;
    }


</style>
