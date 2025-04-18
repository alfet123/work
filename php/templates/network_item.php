
<main class="page-content  page-content-list">

<div class="wrapper">

<section class="network  network-filter">
    <div>Розетка: <span><?=$networkItem['plug'];?></span></div>
    <div>Панель: <span><?=$networkItem['panel'];?></span></div>
    <div>Коммутатор: <span><?=$networkItem['switch'];?></span></div>
    <div>Порт: <span><?=$networkItem['port'];?></span></div>
    <div>Адрес: <span><?=$networkItem['address'];?></span></div>
    <div>Устройство: <span><?=$networkItem['device'];?></span></div>
    <div>Имя: <span><?=$networkItem['name'];?></span></div>
    <hr>
    <div>Место подключения: <span><?=$networkItem['build_name'].', этаж '.$networkItem['floor_name'].', кабинет '.$networkItem['room_number'].' '.$networkItem['room_name'];?></span></div>
    <hr>
    <div>Примечание: <span><?=$networkItem['comment'];?></span></div>
</section>

<section class="network  network-filter">
    <pre><?=print_r($networkItem);?></pre>
</section>

</div>

</main>
