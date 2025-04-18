
<main class="page-content  page-content-list">

<div class="wrapper">

<section class="svt  svt-filter">
    <div>Устройство: <span><?=$svtItem['type_name'].' '.$svtItem['model_name'];?><?=((empty($svtItem['svt_number']))?'':' ('.$svtItem['svt_number'].')');?></span></div>
    <div>Серийный номер: <span><?=$svtItem['svt_serial'];?></span></div>
    <div>Инвентарный номер: <span><?=$svtItem['svt_inv'];?></span></div>
    <hr>
    <div>Место установки: <span><?=$svtItem['build_name'].', этаж '.$svtItem['floor_name'].', кабинет '.$svtItem['room_number'].' '.$svtItem['room_name'];?></span></div>
    <hr>
    <div>Примечание: <span><?=$svtItem['svt_comment'];?></span></div>
</section>

<section class="svt  svt-filter">
    <pre><?=print_r($svtItem);?></pre>
</section>

</div>

</main>
