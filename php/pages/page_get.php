<?php

if (isset($funcName) && isset($itemId)) {

    switch ($funcName) {

        case 'floor':
            $selectList = DataBase::instance()->getFloorList($itemId);
            break;

        case 'room':
            $selectList = DataBase::instance()->getRoomList($itemId);
            break;

        case 'model':
            $selectList = DataBase::instance()->getModelList($itemId);
            break;
                                        
        default:
            $selectList = [];

    }

    echo json_encode($selectList);

}
