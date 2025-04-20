<?php

$tableNetwork = [
    'build_name' => 'Здание',
    'floor_name' => 'Этаж',
    'depart_name' => 'Отделение',
    'room_number' => 'Кабинет',
    'plug' => 'Розетка',
    'panel' => 'Панель',
    'switch' => 'Коммутатор',
    'port' => 'Порт',
    'address' => 'Адрес',
    'device' => 'Устройство',
    'name' => 'Имя',
    'comment' => 'Примечание'
];

?>

<main class="page-content  page-content-list">

<div class="wrapper">

<section class="network  network-filter">
    Фильтры для списка сетевых подключений
</section>

<section class="network  network-list">

<table class="table-network">

    <tr class="tr-head">
    <?php foreach ($tableNetwork as $key => $value): ?>
        <th><?=$value;?></th>
    <?php endforeach; ?>
    </tr>

<?php foreach ($networkList as $network): ?>
    <tr class="tr-item" id="<?=$network['id'];?>">
    <?php foreach ($tableNetwork as $key => $value): ?>
        <td><?=$network[$key];?></td>
    <?php endforeach; ?>
    </tr>
<?php endforeach; ?>

</table>

</section>

</div>

</main>
