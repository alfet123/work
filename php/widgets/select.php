
<div class="<?=$class;?>">
<div class="form-element-label">
    <label class="svt-filter-label" for="<?=$id;?>"><?=$title;?></label>
    <div class="form-element-clear-btn"></div>
</div>
<select class="svt-filter-select" name="<?=$name;?>" id="<?=$id;?>"<?=count($dataList) ? "" : " disabled";?>>
    <option value="" hidden disabled<?=(empty($dataCurrentId))?" selected":"";?>>&nbsp;</option>
    <?php foreach ($dataList as $key => $value): ?>
        <option value="<?=$value['id'];?>"<?=($value['id']==$dataCurrentId)?" selected":"";?>><?=trim($value['number']." ".$value['name']);?></option>
    <?php endforeach; ?>
</select>
</div>
