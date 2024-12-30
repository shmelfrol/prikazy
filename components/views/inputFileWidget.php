<?php

$this->registerCssFile('@web/css/input_file.css', [
]);


$this->registerJsFile('@web/js/input_file.js',
[
'position' => $this::POS_END
]
);


/* @var $hidden boolean */
?>

<div <?= $r= $hidden ? 'hidden' : null ?> id="add-file">
    <?= $form->field($model, 'file')
        ->fileInput(['class' => 'input-prikaz', 'accept' => 'application/pdf'])
        ->label("<div style='display: inline-block;'>Выберите новый файл</div><div style='display: inline-block;'><img src='/images/upload_white.png' style='width: 30px; height: 25px' /> </div>", ['class' => 'input-file-label']) ?>
    <div id="uploadedfile"></div>
</div>