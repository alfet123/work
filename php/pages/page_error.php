<?php

$title = 'Ошибка';

includeTemplate('html_begin', ['title' => $title, 'menu' => $menu]);

includeTemplate('error', ['text' => 'Невозможно отобразить страницу']);

include 'templates/html_end.php';
