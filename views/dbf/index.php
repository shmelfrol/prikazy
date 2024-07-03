<table class="table">
    <tr>
        <th width="80">номер</th>
        <th width="80">index_id</th>
        <th width="80">Дата</th>
        <th width="80">Дата</th>
        <th width="70">тип даты</th>
        <th width="70">Номер</th>
        <th width="70">Индекс</th>
        <th>Заглавие</th>
        <th width="70">file</th>
        <th width="70">file</th>
    </tr>
    <?php $i=1; ?>
    <?php foreach ($prikazes as $p): ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $p->index_id; ?></td>
        <td width="180"><?php echo Yii::$app->formatter->asDate(strtotime($p->reldate), 'yyyy-MM-dd'); ?></td>
        <td width="180"><?php echo $p->reldate; ?></td>
        <td width="80"><?php echo gettype($p->reldate); ?></td>
        <td width="70"><?php echo $p->numc; ?></td>
        <td width="70"><?php echo $p->nums; ?></td>
        <td><?php echo $p->text; ?></td>
        <td><?php echo $p->ext ?></td>
        <td><?php echo $p->filename; ?></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
</table>




