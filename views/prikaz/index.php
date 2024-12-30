<?php

use app\models\Document;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\DocumentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/* @var $years array */
/* @var $months array */

$this->title = 'Приказы';
//$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/fav.js',
    [
        'position' => $this::POS_END
    ]
);
?>
<div class="document-index">
    <?php echo \app\components\PageTitle::widget([ 'url'=>Url::toRoute('create'),'title' =>'Приказы']) ?>



    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            // return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
            return    \app\components\PrikazOneWidget::widget(['p' => $model, 'btndel' => true, 'btnedit' => true, 'btncancel' => false, 'heart' => true, 'action_id' => 1]) ;
        },
    ]) ?>



</div>

<style>
    .pagination {

    }
    .pagination li {
      background-color: green;
      margin: 2px;
      padding: 4px;
        border-radius: 2px;

    }
    .pagination li a {
        font-size: large;
        color: white;
        text-decoration: none;
    }
    .pagination .active {
        background-color: #0a73bb;
    }



</style>