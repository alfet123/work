<?php
$clearBtnClass = "form-element-clear-btn";
if (empty($dataCurrentId)) {
   $clearBtnClass .= "  hidden";
}
?>

<div class="<?=$class;?>">
<div class="form-element-label">
    <label class="svt-filter-label" for="<?=$id;?>"><?=$title;?></label>
    <div class="<?=$clearBtnClass;?>"></div>
</div>
<select class="svt-filter-select" name="<?=$name;?>" id="<?=$id;?>"<?=count($dataList) ? "" : " disabled";?>>
    <option value="" hidden disabled<?=(empty($dataCurrentId))?" selected":"";?>>&nbsp;</option>
    <?php foreach ($dataList as $key => $value): ?>
        <?php $valueName = $value['name']; ?>
        <?php if ($id == 'room_id'): ?>
            <?php $valueName = trim($value['number']." ".$value['name']); ?>
        <?php endif; ?>
        <option value="<?=$value['id'];?>"<?=($value['id']==$dataCurrentId)?" selected":"";?>><?=$valueName;?></option>
    <?php endforeach; ?>
</select>
</div>
