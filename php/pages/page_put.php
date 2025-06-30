<?php

$input = file_get_contents('php://input');
$data = json_decode($input, true);

switch ($appFuncName) {

    case 'svt':
        $result = DataBase::instance()->updateSvt($appItemId, $data);
        break;

}

echo json_encode([
    'table' => $appFuncName,
    'id' => $appItemId,
    'data_is_updated' => $result
]);
