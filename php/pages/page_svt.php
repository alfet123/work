<?php

if (isset($itemId)) {

	$svtItem = DataBase::instance()->getSvtById($itemId);

	$title = $svtItem['type_name'].' '.$svtItem['model_name'];

	includeTemplate('html_begin', ['title' => $title, 'menu' => $menu, 'current' => '']);

	includeTemplate('svt_item', ['svtItem' => $svtItem]);

	include 'templates/html_end.php';

} else {

	$title = 'Список СВТ';

	// Данные из формы фильтрации
	$svtFilter = getPostData();

//echo "<pre>svtFilter&nbsp;";
//print_r($svtFilter);
//echo "</pre>";

	// Справочники

	// Здания
	$buildList = DataBase::instance()->getBuildList();

	$currentBuildId = "";
	if (isset($svtFilter['build_id'])) {
		$currentBuildId = $svtFilter['build_id'];
	}

//	$floorList = DataBase::instance()->getFloorList($buildSelected);

//	$roomList = DataBase::instance()->getRoomList($floorSelected);

	// Типы СВТ
	$typeList = DataBase::instance()->getTypeList();

	$currentTypeId = "";
	if (isset($svtFilter['type_id'])) {
		$currentTypeId = $svtFilter['type_id'];
	}

	// Количество СВТ
	$svtCount = DataBase::instance()->getSvtCount($svtFilter);

	// Список СВТ
	$svtList = DataBase::instance()->getSvtList($svtFilter);

	includeTemplate('html_begin', ['title' => $title, 'menu' => $menu, 'current' => '/svt']);

	includeTemplate('svt_list', [
		'svtFilter' => $svtFilter,
		'svtCount' => $svtCount,
		'buildList' => $buildList,
		'currentBuildId' => $currentBuildId,
		'typeList' => $typeList,
		'currentTypeId' => $currentTypeId,
		'svtList' => $svtList
	]);

	includeTemplate('html_end', ['script' => 'svt-list']);

}
