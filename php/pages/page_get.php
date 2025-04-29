<?php

if (isset($appFuncName) && isset($appItemId)) {

    switch ($appFuncName) {

        case 'svt':
            $data = DataBase::instance()->getSvtById($appItemId);
            break;

        case 'build':
            $data = DataBase::instance()->getBuildList($appCurrentId);
            break;

        case 'floor':
            $data = DataBase::instance()->getFloorList($appItemId, $appCurrentId);
            break;
    
        case 'room':
            $data = DataBase::instance()->getRoomList($appItemId, $appCurrentId);
            break;

        case 'type':
            $data = DataBase::instance()->getTypeList($appCurrentId);
            break;

        case 'model':
            $data = DataBase::instance()->getModelList($appItemId, $appCurrentId);
            break;
    
        default:
            $data = [];

    }

    echo json_encode($data);

}
