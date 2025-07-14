<?php

$tableSvt = [
    'build_name' => 'Здание',
    'floor_name' => 'Этаж',
    'depart_name' => 'Отделение',
    'room_number' => 'Кабинет',
    'type_name' => 'Тип',
    'svt_number' => '№ ТК',
    'model_name' => 'Модель',
    'svt_serial' => 'Серийный номер',
    'svt_inv' => 'Инвентарный номер',
    'svt_comment' => 'Примечание'
];

?>

<main class="page-content  page-content-list">

<div class="wrapper">

<section class="svt  svt-filter">
<!--<form action="/svt" method="post" id="svt_filter">-->
<form class="svt-filter-form" action="/" method="post" id="svt_filter">

    <div class="svt-filter-section">

        <input hidden readonly type="text" id="page_current" name="page_current" value="<?=$svtPages['current'];?>">

        <?php includeWidget('select', [
            'id' => 'build_id',
            'name' => 'build_id',
            'title' => 'Здание',
            'dataList' => $buildList,
            'dataCurrentId' => $currentBuildId
        ]); ?>

       <?php includeWidget('select', [
            'id' => 'floor_id',
            'name' => 'floor_id',
            'title' => 'Этаж',
            'dataList' => $floorList,
            'dataCurrentId' => $currentFloorId
        ]); ?>

        <?php includeWidget('select', [
            'id' => 'room_id',
            'name' => 'room_id',
            'title' => 'Кабинет',
            'dataList' => $roomList,
            'dataCurrentId' => $currentRoomId
        ]); ?>

        <?php includeWidget('select', [
            'id' => 'depart_id',
            'name' => 'depart_id',
            'title' => 'Отделение',
            'dataList' => $departList,
            'dataCurrentId' => $currentDepartId
        ]); ?>

        <?php includeWidget('select', [
            'id' => 'status_id',
            'name' => 'status_id',
            'title' => 'Статус',
            'dataList' => $statusList,
            'dataCurrentId' => $currentStatusId
        ]); ?>

        <?php includeWidget('input', [
            'id' => 'svt_comment',
            'name' => 'svt_comment',
            'title' => 'Примечание',
            'size' => '32',
            'maxlength' => '64',
            'value' => $svtFilter['svt_comment']
        ]); ?>

    </div>

    <div class="svt-filter-section">

        <?php includeWidget('select', [
            'id' => 'type_id',
            'name' => 'type_id',
            'title' => 'Тип',
            'dataList' => $typeList,
            'dataCurrentId' => $currentTypeId
        ]); ?>

        <?php includeWidget('select', [
            'id' => 'model_id',
            'name' => 'model_id',
            'title' => 'Модель',
            'dataList' => $modelList,
            'dataCurrentId' => $currentModelId
        ]); ?>

        <?php includeWidget('input', [
            'id' => 'svt_number',
            'name' => 'svt_number',
            'title' => '№ ТК',
            'size' => '8',
            'maxlength' => '8',
            'value' => $svtFilter['svt_number']
        ]); ?>

        <?php includeWidget('input', [
            'id' => 'svt_serial',
            'name' => 'svt_serial',
            'title' => 'Серийный номер',
            'size' => '16',
            'maxlength' => '32',
            'value' => $svtFilter['svt_serial']
        ]); ?>

        <?php includeWidget('input', [
            'id' => 'svt_inv',
            'name' => 'svt_inv',
            'title' => 'Инвентарный номер',
            'size' => '12',
            'maxlength' => '16',
            'value' => $svtFilter['svt_inv']
        ]); ?>

        <?php includeWidget('button', [
            'class' => 'form-element',
            'type' => 'submit',
            'id' => 'form_submit',
            'name' => 'form_submit',
            'title' => 'Найти'
        ]); ?>

        <?php includeWidget('button', [
            'class' => 'form-element  form-element-last',
            'type' => 'reset',
            'id' => 'form_reset',
            'name' => 'form_reset',
            'title' => 'Очистить'
        ]); ?>

    </div>

</form>
</section>

<section class="svt  svt-list">

<table class="table-svt">

    <tr class="tr-head">
    <?php foreach ($tableSvt as $key => $value): ?>
        <th><?=$value;?></th>
    <?php endforeach; ?>
    </tr>

<?php if ($svtCount > 0): ?>

<?php foreach ($svtList as $svt): ?>
    <tr class="tr-item<?=(empty($svt['status_class']))?"":" ".$svt['status_class'];?>" id="<?=$svt['svt_id'];?>">
    <?php foreach ($tableSvt as $key => $value): ?>
        <td><?=($key == 'room_number') ? trim($svt['room_number']." ".$svt['room_name']) : $svt[$key];?></td>
    <?php endforeach; ?>
    </tr>
<?php endforeach; ?>

<?php else: ?>

    <tr class="empty-result"><td colspan="<?=count($tableSvt);?>">Нет записей для данных условий отбора.</td></tr>

<?php endif; ?>

</table>

</section>

<section class="svt  svt-pages">

    <div class="svt-pages-buttons">
        <button type="button" id="page_first"<?=($svtPages['current'] < 2) ? ' disabled' : ' value="1"';?>>Первая</button>
        <button type="button" id="page_prev"<?=($svtPages['current'] < 2) ? ' disabled' : ' value="'.$svtPages['prev'].'"';?>>Назад</button>
        <div class="svt-pages-count"><?=$svtPages['current'];?>&nbsp;&nbsp;/&nbsp;&nbsp;<?=$svtPages['total'];?></div>
        <button type="button" id="page_next"<?=($svtPages['current'] == $svtPages['total']) ? ' disabled' : ' value="'.$svtPages['next'].'"';?>>Вперед</button>
        <button type="button" id="page_last"<?=($svtPages['current'] == $svtPages['total']) ? ' disabled' : ' value="'.$svtPages['total'].'"';?>>Последняя</button>
    </div>

    <div class="svt-pages-info">
        <?=$svtPages['showFrom'];?>&nbsp;...&nbsp;<?=$svtPages['showTo'];?>&nbsp;&nbsp;/&nbsp;&nbsp;<?=$svtCount;?>
    </div>

</section>

</div>

</main>
