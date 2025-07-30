<?php

$testName = 'url'; // default template value

if (isset($appFuncName)) {
    $testName = $appFuncName;
}

switch ($testName) {
    case 'url':
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($url, '/'));
        $method = $_SERVER['REQUEST_METHOD'];
        $title = 'Тестовая страница';
        includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu]);
        includeTemplate('test_url', ['url' => $url, 'segments' => $segments, 'method' => $method]);
        break;

    case 'free_svt_id':
        $svtCount = DataBase::instance()->getSvtCount();
        $svtId = DataBase::instance()->getSvtId();
        $idFree = [];
        for ($i = 1; $i <= $svtCount; $i++) {
            if (!array_key_exists($i, $svtId)) {
                $idFree[] = $i;
            }
        }
        $title = 'Свободные ID в таблице svt';
        includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu]);
        includeTemplate('test_info', ['infoHead' => $title, 'infoData' => $idFree]);
        break;

    case 'free_room_id':
        $roomCount = DataBase::instance()->getRoomCount();
        $roomId = DataBase::instance()->getRoomId();
        $idFree = [];
        for ($i = 1; $i <= $roomCount; $i++) {
            if (!array_key_exists($i, $roomId)) {
                $idFree[] = $i;
            }
        }
        $title = 'Свободные ID  в таблице room';
        includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu]);
        includeTemplate('test_info', ['infoHead' => $title, 'infoData' => $idFree]);
        break;

    default:
        $title = 'Ошибка';
        includeTemplate('html_begin', ['title' => $title, 'menu' => $appMenu]);
        includeTemplate('error', ['text' => 'Невозможно отобразить страницу']);
}

include 'templates/html_end.php';
