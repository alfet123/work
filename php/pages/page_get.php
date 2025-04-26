<?php

if (isset($funcName) && isset($itemId)) {

    switch ($funcName) {

        case 'svt':
            $data = DataBase::instance()->getSvtById($itemId);
            break;

        case 'build':
            $data = DataBase::instance()->getBuildList();
            break;

        case 'floor':
            $data = DataBase::instance()->getFloorList($itemId);
            break;
    
        case 'room':
            $data = DataBase::instance()->getRoomList($itemId);
            break;

        case 'type':
            $data = DataBase::instance()->getTypeList();
            break;

        case 'model':
            $data = DataBase::instance()->getModelList($itemId);
            break;
    
        default:
            $data = [];

    }

    echo json_encode($data);

}
