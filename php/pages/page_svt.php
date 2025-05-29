<?php

if (isset($appItemId)) {

    $svtItem = DataBase::instance()->getSvtById($appItemId);

    $title = $svtItem['type_name'].' '.$svtItem['model_name'];

    includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu, 'current' => '']);

    includeTemplate('svt_item', ['svtItem' => $svtItem]);

    include 'templates/html_end.php';

} else {

    $title = 'Список СВТ';

    // Данные из формы фильтрации
    $svtFilter = getPostData();

    // Выбранный ID из выпадающих списков
    $currentBuildId = (isset($svtFilter['build_id'])) ? $svtFilter['build_id'] : "";
    $currentFloorId = (isset($svtFilter['floor_id'])) ? $svtFilter['floor_id'] : "";
    $currentRoomId = (isset($svtFilter['room_id'])) ? $svtFilter['room_id'] : "";
    $currentTypeId = (isset($svtFilter['type_id'])) ? $svtFilter['type_id'] : "";
    $currentModelId = (isset($svtFilter['model_id'])) ? $svtFilter['model_id'] : "";

    // Справочники
    $buildList = DataBase::instance()->getBuildList();
    $floorList = DataBase::instance()->getFloorList($currentBuildId);
    $roomList = DataBase::instance()->getRoomList($currentFloorId);
    $typeList = DataBase::instance()->getTypeList();
    $modelList = DataBase::instance()->getModelList($currentTypeId);

    // Количество СВТ
    $svtCount = DataBase::instance()->getSvtCount($svtFilter);

    // Страницы
    $pagesCount = ceil($svtCount / $limit);
    $pageCurrent = ($svtCount > 0) ? 1 : 0;
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
    $svtPages['showFrom'] = ($svtCount > 0) ? $offset + 1 : 0;
    $svtPages['showTo'] = $offset + count($svtList);

    includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu, 'current' => '/svt']);

    includeTemplate('svt_list', [
        'svtList' => $svtList,
        'svtFilter' => $svtFilter,
        'svtCount' => $svtCount,
        'svtPages' => $svtPages,
        'buildList' => $buildList,
        'currentBuildId' => $currentBuildId,
        'floorList' => $floorList,
        'currentFloorId' => $currentFloorId,
        'roomList' => $roomList,
        'currentRoomId' => $currentRoomId,
        'typeList' => $typeList,
        'currentTypeId' => $currentTypeId,
        'modelList' => $modelList,
        'currentModelId' => $currentModelId
    ]);

    includeTemplate('html_end', ['script' => 'svt-list']);

}
