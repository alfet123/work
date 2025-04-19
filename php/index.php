<?php

//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require_once 'lib/database.php';

require 'lib/config.php';
require 'lib/functions.php';

$addressParts = getAddressParts();

if (isset($addressParts[0]) && !empty($addressParts[0])) {
    $pageName = htmlspecialchars($addressParts[0]);
}

if (isset($addressParts[1]) && !empty($addressParts[1])) {
    if (is_numeric($addressParts[1])) {
        $itemId = intval($addressParts[1]);
    } else {
        $funcName = htmlspecialchars($addressParts[1]);
    }
}

if (isset($pageName)) {

    if (array_key_exists($pageName, $appPages)){

        require $appPagesPath.'/'.$appPages[$pageName].'.php';

    } else {

        require $appPagesPath.'/'.$appPageError.'.php';

    }

} else {

    require $appPagesPath.'/'.$appPageDefault.'.php';

}
