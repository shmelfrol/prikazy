<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $prikazes array */

?>



<?php echo \app\components\PageTitle::widget([ 'title' =>'Избранное']) ?>

<?php echo \app\components\PrikazListWidget::widget(['prikazes'=>$prikazes, 'btndel'=>false, 'btnedit'=>false]); ?>


