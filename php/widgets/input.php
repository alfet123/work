<?php
$clearBtnClass = "form-element-clear-btn";
if (empty($value)) {
   $clearBtnClass .= "  hidden";
}
?>

<div class="<?=$class;?>">
<div class="form-element-label">
    <label class="svt-filter-label" for="<?=$id;?>"><?=$title;?></label>
    <div class="<?=$clearBtnClass;?>"></div>
</div>
<input class="svt-filter-text" type="text" size="<?=$size;?>" maxlength="<?=$maxlength;?>" id="<?=$id;?>" name="<?=$name;?>" value="<?=$value;?>">
</div>
