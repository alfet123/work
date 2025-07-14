
<div class="form-element">
<div class="form-element-label">
    <label class="svt-filter-label" for="<?=$id;?>"><?=$title;?></label>
    <div class="form-element-clear-btn">
        <!--<div class="clear-btn-line  clear-btn-line-1"></div>
        <div class="clear-btn-line  clear-btn-line-2"></div>-->
    </div>
</div>
<select class="svt-filter-select" name="<?=$name;?>" id="<?=$id;?>"<?=count($dataList) ? "" : " disabled";?>>
    <option value="" hidden disabled<?=(empty($dataCurrentId))?" selected":"";?>>&nbsp;</option>
    <?php foreach ($dataList as $key => $value): ?>
        <option value="<?=$value['id'];?>"<?=($value['id']==$dataCurrentId)?" selected":"";?>><?=trim($value['number']." ".$value['name']);?></option>
    <?php endforeach; ?>
</select>
</div>
