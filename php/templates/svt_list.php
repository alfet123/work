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
<form action="/svt" method="post" id="svt-filter">

    <!--<div class="form-element">
    <pre style="font-size: 10px; background-color: lightgray;">
        <?=print_r($_POST);?>
    </pre>
    </div>-->

    <div class="form-element">
    <label>svtCount</label>
    <div><?=$svtCount;?></div>
    </div>

    <div class="form-element">
    <label for="build_id">Здание</label>
    <select name="build_id" id="build_id">
        <option value="" hidden disabled<?=(empty($currentBuildId))?" selected":"";?>>&nbsp;</option>
        <?php foreach ($buildList as $key => $value): ?>
            <option value="<?=$key;?>"<?=($key==$currentBuildId)?" selected":"";?>><?=$value['name'];?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-element">
    <label for="type_id">Тип</label>
    <select name="type_id" id="type_id">
        <option value="" hidden disabled<?=(empty($currentTypeId))?" selected":"";?>>&nbsp;</option>
        <?php foreach ($typeList as $key => $value): ?>
            <option value="<?=$key;?>"<?=($key==$currentTypeId)?" selected":"";?>><?=$value['name'];?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-element">
    <label for="svt_number">№ ТК</label>
    <input type="text" size="4" maxlength="8" id="svt_number" name="svt_number" value="<?=$svtFilter['svt_number'];?>">
    </div>

    <div class="form-element">
    <label for="svt_serial">Серийный номер</label>
    <input type="text" size="16" maxlength="32" id="svt_serial" name="svt_serial" value="<?=$svtFilter['svt_serial'];?>">
    </div>

    <div class="form-element">
    <label for="svt_inv">Инвентарный номер</label>
    <input type="text" size="12" maxlength="16" id="svt_inv" name="svt_inv" value="<?=$svtFilter['svt_inv'];?>">
    </div>

    <div class="form-element">
    <label>&nbsp;</label>
    <button type="submit">Найти</button>
    </div>

    <div>
    <label>&nbsp;</label>
    <button type="reset">Очистить</button>
    </div>

</form>
</section>

<section class="svt  svt-list">

<table class="table-svt">

    <tr class="tr-head">
        <th class="svt-id">ID</th>
    <?php foreach ($tableSvt as $key => $value): ?>
        <th><?=$value;?></th>
    <?php endforeach; ?>
    </tr>

<?php foreach ($svtList as $svt): ?>
    <tr class="tr-item<?=(empty($svt['status_class']))?"":" ".$svt['status_class'];?>" id="<?=$svt['svt_id'];?>">
        <td class="svt-id"><a href="/svt/<?=$svt['svt_id'];?>"><?=$svt['svt_id'];?></a></td>
    <?php foreach ($tableSvt as $key => $value): ?>
        <td><?=$svt[$key];?></td>
    <?php endforeach; ?>
    </tr>
<?php endforeach; ?>

</table>

</section>

</div>

</main>
