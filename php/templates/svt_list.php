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

    <input hidden readonly type="text" id="page_current" name="page_current" value="<?=$svtPages['current'];?>">

    <div class="form-element">
    <label class="svt-filter-label" for="build_id">Здание</label>
    <select class="svt-filter-select" name="build_id" id="build_id">
        <option value="" hidden disabled<?=(empty($currentBuildId))?" selected":"";?>>&nbsp;</option>
        <?php foreach ($buildList as $key => $value): ?>
            <option value="<?=$value['id'];?>"<?=($value['id']==$currentBuildId)?" selected":"";?>><?=$value['name'];?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-element">
    <label class="svt-filter-label" for="floor_id">Этаж</label>
    <select class="svt-filter-select" name="floor_id" id="floor_id"<?=count($floorList) ? "" : " disabled";?>>
        <option value="" hidden disabled<?=(empty($currentFloorId))?" selected":"";?>>&nbsp;</option>
        <?php foreach ($floorList as $key => $value): ?>
            <option value="<?=$value['id'];?>"<?=($value['id']==$currentFloorId)?" selected":"";?>><?=$value['name'];?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-element">
    <label class="svt-filter-label" for="room_id">Кабинет</label>
    <select class="svt-filter-select" name="room_id" id="room_id"<?=count($roomList) ? "" : " disabled";?>>
        <option value="" hidden disabled<?=(empty($currentRoomId))?" selected":"";?>>&nbsp;</option>
        <?php foreach ($roomList as $key => $value): ?>
            <option value="<?=$value['id'];?>"<?=($value['id']==$currentRoomId)?" selected":"";?>><?=trim($value['number']." ".$value['name']);?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-element">
    <label class="svt-filter-label" for="type_id">Тип</label>
    <select class="svt-filter-select" name="type_id" id="type_id">
        <option value="" hidden disabled<?=(empty($currentTypeId))?" selected":"";?>>&nbsp;</option>
        <?php foreach ($typeList as $key => $value): ?>
            <option value="<?=$value['id'];?>"<?=($value['id']==$currentTypeId)?" selected":"";?>><?=$value['name'];?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-element">
    <label class="svt-filter-label" for="model_id">Модель</label>
    <select class="svt-filter-select" name="model_id" id="model_id"<?=count($modelList) ? "" : " disabled";?>>
        <option value="" hidden disabled<?=(empty($currentModelId))?" selected":"";?>>&nbsp;</option>
        <?php foreach ($modelList as $key => $value): ?>
            <option value="<?=$value['id'];?>"<?=($value['id']==$currentModelId)?" selected":"";?>><?=$value['name'];?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-element">
    <label class="svt-filter-label" for="svt_number">№ ТК</label>
    <input class="svt-filter-text" type="text" size="8" maxlength="8" id="svt_number" name="svt_number" value="<?=$svtFilter['svt_number'];?>">
    </div>

    <div class="form-element">
    <label class="svt-filter-label" for="svt_serial">Серийный номер</label>
    <input class="svt-filter-text" type="text" size="16" maxlength="32" id="svt_serial" name="svt_serial" value="<?=$svtFilter['svt_serial'];?>">
    </div>

    <div class="form-element">
    <label class="svt-filter-label" for="svt_inv">Инвентарный номер</label>
    <input class="svt-filter-text" type="text" size="12" maxlength="16" id="svt_inv" name="svt_inv" value="<?=$svtFilter['svt_inv'];?>">
    </div>

    <div class="form-element">
    <label class="svt-filter-label">&nbsp;</label>
    <button type="submit" id="form_submit" name="form_submit">Найти</button>
    </div>

    <div class="form-element  form-element-last">
    <label class="svt-filter-label">&nbsp;</label>
    <button type="reset" id="form_reset" name="form_reset">Очистить</button>
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
