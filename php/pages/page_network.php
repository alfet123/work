<?php

if (isset($itemId)) {

	$networkItem = DataBase::instance()->getNetworkById($itemId);

	$title = 'Подключение '.$networkItem['network_id'];

	includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu, 'current' => '']);

	includeTemplate('network_item', ['networkItem' => $networkItem]);

	include 'templates/html_end.php';

} else {

	$title = 'Список сетевых подключений';

	$networkList = DataBase::instance()->getNetworkList();

	includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu, 'current' => '/network']);

	includeTemplate('network_list', ['networkList' => $networkList]);

	includeTemplate('html_end', ['script' => 'network-list']);

}
