<?php

if(!isset($title)) {
    $title = 'СВТ';
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/style.css" rel="stylesheet">
    <title><?=$title;?></title>
</head>
<body>

<header class="page-header">

<ul class="menu">
<?php foreach ($menu as $menuLink => $menuText) : ?>
    <li class="menu-item<?=($menuLink==$current)?'  menu-item-current':'';?>"><a class="menu-link" href="<?=$menuLink;?>"><?=$menuText;?></a></li>
<?php endforeach; ?>
</ul>

</header>
