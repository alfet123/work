<?php

if (isset($itemId)) {

	$svtItem = DataBase::instance()->getSvtById($itemId);

	$title = $svtItem['type_name'].' '.$svtItem['model_name'];

	includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu, 'current' => '']);

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

	// Страницы
	$pagesCount = ceil($svtCount / $limit);
	$pageCurrent = 1;
	if (isset($svtFilter['page_current']) && intval($svtFilter['page_current']) <= $pagesCount) {
		$pageCurrent = intval($svtFilter['page_current']);
	}
	$offset = 0;
	if ($pageCurrent > 1) {
		$offset = ($pageCurrent - 1) * $limit;
	}

	// Номера страниц для кнопок пагинации
	$svtPages['total'] = $pagesCount;
	$svtPages['current'] = $pageCurrent;
	$svtPages['prev'] = $pageCurrent - 1;
	$svtPages['next'] = $pageCurrent + 1;

	// offset и limit для запроса
	$svtFilter['offset'] = $offset;
	$svtFilter['limit'] = $limit;

	// Список СВТ
	$svtList = DataBase::instance()->getSvtList($svtFilter);

	// Начальный и конечный порядковый номер отображаемых строк
	$svtPages['showFrom'] = $offset + 1;
	$svtPages['showTo'] = $offset + count($svtList);

	includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu, 'current' => '/svt']);

	includeTemplate('svt_list', [
		'svtList' => $svtList,
		'svtFilter' => $svtFilter,
		'svtCount' => $svtCount,
		'svtPages' => $svtPages,
		'buildList' => $buildList,
		'currentBuildId' => $currentBuildId,
		'typeList' => $typeList,
		'currentTypeId' => $currentTypeId
	]);

	includeTemplate('html_end', ['script' => 'svt-list']);

}
