<?php

//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require_once 'lib/database.php';

require 'lib/config.php';
require 'lib/functions.php';

$addressParts = getAddressParts();

// 0 - PageName
if (isset($addressParts[0]) && !empty($addressParts[0])) {
    $appPageName = htmlspecialchars($addressParts[0]);
}

// 1 - ItemId или FuncName
if (isset($addressParts[1]) && !empty($addressParts[1])) {
    if (is_numeric($addressParts[1])) {
        $appItemId = intval($addressParts[1]);
    } else {
        $appFuncName = htmlspecialchars($addressParts[1]);
    }
}

$appCurrentId = null;

// 2 - [1=FuncName] ItemId
if (isset($appFuncName) && !empty($appFuncName) && isset($addressParts[2]) && is_numeric($addressParts[2])) {
    $appItemId = intval($addressParts[2]);
    // 3 - [1=FuncName] [2=ItemId] CurrentId
    if (isset($addressParts[3]) && is_numeric($addressParts[3])) {
        $appCurrentId = intval($addressParts[3]);
    }
}

if (isset($appPageName)) {

    if (array_key_exists($appPageName, $appPages)){

        require $appPagesPath.'/'.$appPages[$appPageName].'.php';

    } else {

        require $appPagesPath.'/'.$appPageError.'.php';

    }

} else {

    require $appPagesPath.'/'.$appPageDefault.'.php';

}
