<?php

class DataBase {

    // Дескриптор подключения к базе данных
    private $link;

    // Конструктор
    private function __construct()
    {
        global $DBCONFIG;

        $this->link = mysqli_connect('localhost', 'admin', 'password', 'work');

        if ($this->link) {
            mysqli_query($this->link, "SET NAMES 'utf8'");
            mysqli_query($this->link, "SET CHARACTER SET 'utf8'");
        } else {
            echo "Ошибка подключения к базе данных";
            exit;
        }
    }

    // Деструктор
    public function __destruct()
    {
        mysqli_close($this->link);
    }

    // Получение экземпляра базы данных
    public static function instance()
    {
        static $instance;
        if (!$instance) {
            $instance = new DataBase();
        }
        return $instance;
    }

    // Возвращает информацию о последней ошибке
    public function lastError()
    {
        return mysqli_error($this->link);
    }

/**************/
/***  USER  ***/
/**************/

    // Возвращает информацию об указанном пользователе
    public function getUser($login)
    {
        $user = null;

        $query = "select * from user where login = '".$login."' limit 1";

        if ($result = mysqli_query($this->link, $query)) {
            if ($row = mysqli_fetch_assoc($result)) {
                $user = $row;
            }
            mysqli_free_result($result);
        }

        return $user;
    }

/***************/
/***  Sprav  ***/
/***************/

    // Возвращает список зданий
    public function getBuildList($currentId=null)
    {
        $build = [];

        $query  = "select * ";
        $query .= "from build ";
        $query .= "order by sort";

        if ($result = mysqli_query($this->link, $query)) {
            $key = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $build[$key] = $row;
                $build[$key]['selected'] = '';
                if (isset($currentId) && $currentId == $build[$key]['id']) {
                    $build[$key]['selected'] = ' selected';
                }
                $key++;
            }
            mysqli_free_result($result);
        }

        return $build;
    }

    // Возвращает список этажей в здании
    public function getFloorList($buildId, $currentId=null)
    {
        $floor = [];

        $query  = "select * ";
        $query .= "from floor ";
        $query .= "where build_id = '".$buildId."' ";
        $query .= "order by number";

        if ($result = mysqli_query($this->link, $query)) {
            $key = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $floor[$key] = $row;
                $floor[$key]['selected'] = '';
                if (isset($currentId) && $currentId == $floor[$key]['id']) {
                    $floor[$key]['selected'] = ' selected';
                }
                $key++;
            }
            mysqli_free_result($result);
        }

        return $floor;
    }

    // Возвращает список кабинетов на этаже
    public function getRoomList($floorId, $currentId=null)
    {
        $room = [];

        $query  = "select * ";
        $query .= "from room ";
        $query .= "where floor_id = '".$floorId."' ";
        $query .= "order by sort, number";

        if ($result = mysqli_query($this->link, $query)) {
            $key = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $room[$key] = $row;
                $room[$key]['selected'] = '';
                if (isset($currentId) && $currentId == $room[$key]['id']) {
                    $room[$key]['selected'] = ' selected';
                }
                $key++;
            }
            mysqli_free_result($result);
        }

        return $room;
    }

    // Возвращает список отделений
    public function getDepartList($currentId=null)
    {
        $depart = [];

        $query  = "select * ";
        $query .= "from depart ";
        $query .= "order by name";

        if ($result = mysqli_query($this->link, $query)) {
            $key = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $depart[$key] = $row;
                $depart[$key]['selected'] = '';
                if (isset($currentId) && $currentId == $depart[$key]['id']) {
                    $depart[$key]['selected'] = ' selected';
                }
                $key++;
            }
            mysqli_free_result($result);
        }

        return $depart;
    }

    // Возвращает список статусов
    public function getStatusList($currentId=null)
    {
        $status = [];

        $query  = "select * ";
        $query .= "from status ";
        $query .= "order by id";

        if ($result = mysqli_query($this->link, $query)) {
            $key = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $status[$key] = $row;
                $status[$key]['selected'] = '';
                if (isset($currentId) && $currentId == $status[$key]['id']) {
                    $status[$key]['selected'] = ' selected';
                }
                $key++;
            }
            mysqli_free_result($result);
        }

        return $status;
    }

    // Возвращает список типов СВТ
    public function getTypeList($currentId=null)
    {
        $type = [];

        $query  = "select * ";
        $query .= "from type ";
        $query .= "order by sort";

        if ($result = mysqli_query($this->link, $query)) {
            $key = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $type[$key] = $row;
                $type[$key]['selected'] = '';
                if (isset($currentId) && $currentId == $type[$key]['id']) {
                    $type[$key]['selected'] = ' selected';
                }
                $key++;
            }
            mysqli_free_result($result);
        }

        return $type;
    }

    // Возвращает список моделей СВТ
    public function getModelList($typeId, $currentId=null)
    {
        $model = [];

        $query  = "select * ";
        $query .= "from model ";
        $query .= "where type_id = '".$typeId."' ";
        $query .= "order by name";

        if ($result = mysqli_query($this->link, $query)) {
            $key = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $model[$key] = $row;
                $model[$key]['selected'] = '';
                if (isset($currentId) && $currentId == $model[$key]['id']) {
                    $model[$key]['selected'] = ' selected';
                }
                $key++;
            }
            mysqli_free_result($result);
        }

        return $model;
    }

/*************/
/***  SVT  ***/
/*************/

    // Получить выражение для условий запроса на основе данных фильтра
    private static function whereExpression($filterData)
    {
        $result = "";

        $where = [
            'build_id' => [
                'field' => 'build_id',
                'operator' => 'equal'
            ],
            'floor_id' => [
                'field' => 'floor_id',
                'operator' => 'equal'
            ],
            'room_id' => [
                'field' => 'room_id',
                'operator' => 'equal'
            ],
            'depart_id' => [
                'field' => 'depart_id',
                'operator' => 'equal'
            ],
            'status_id' => [
                'field' => 'status_id',
                'operator' => 'equal'
            ],
            'type_id' => [
                'field' => 'type_id',
                'operator' => 'equal'
            ],
            'model_id' => [
                'field' => 'model_id',
                'operator' => 'equal'
            ],
            'svt_number' => [
                'field' => 'svt_number',
                'operator' => 'like'
            ],
            'svt_serial' => [
                'field' => 'svt_serial',
                'operator' => 'like'
            ],
            'svt_inv' => [
                'field' => 'svt_inv',
                'operator' => 'like'
            ],
            'svt_comment' => [
                'field' => 'svt_comment',
                'operator' => 'like'
            ]
        ];

        $filterItemsCount = 1;
        foreach ($filterData as $key => $value) {
            if (array_key_exists($key, $where)) {
                if ($filterItemsCount == 1) {
                    $result = "where ";
                } elseif ($filterItemsCount > 1) {
                    $result .= "and ";
                }
                $result .= $where[$key]['field'];
                switch ($where[$key]['operator']) {
                    case 'like':
                        $result .= " like '%".$value."%' ";
                        break;
                    case 'equal':
                        $result .= " = '".$value."' ";
                        break;
                    default:
                        $result .= " = '".$value."' ";
                }
                $filterItemsCount++;
            }
        }

        return $result;
    }

    // Получить выражение для сортировки результатов запроса
    private static function orderExpression()
    {
        $orderFieldsDefault = "build_sort, floor_number, room_sort, room_number, type_sort, svt_number, model_name, svt_serial ";

        return "order by ".$orderFieldsDefault;
    }

    // Возвращает количество СВТ
    public function getSvtCount($svtFilter=[])
    {
        $svtCount = 0;

        $query  = "select count(*) as 'count' ";
        $query .= "from view_svt_all ";
        $query .= self::whereExpression($svtFilter);
        $query .= "limit 1";

        if ($result = mysqli_query($this->link, $query)) {
            if ($row = mysqli_fetch_assoc($result)) {
                $svtCount = intval($row['count']);
            }
            mysqli_free_result($result);
        }

        return $svtCount;
    }

    // Возвращает список СВТ
    public function getSvtList($svtFilter=[])
    {
        $offset = 1;
        $limit = $GLOBALS['limit'];

        if (isset($svtFilter['offset']) && is_numeric($svtFilter['offset'])) {
            $offset = intval($svtFilter['offset']);
        }

        if (isset($svtFilter['limit']) && is_numeric($svtFilter['limit'])) {
            $limit = intval($svtFilter['limit']);
        }

        $svt = [];

        $query  = "select * ";
        $query .= "from view_svt_all ";
        $query .= self::whereExpression($svtFilter);
        $query .= self::orderExpression();
        $query .= "limit ".$offset.", ".$limit;

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $svt[$row['svt_id']] = $row;
            }
            mysqli_free_result($result);
        }

        return $svt;
    }

    // Возвращает СВТ по ID
    public function getSvtById($svtId)
    {
        $svt = [];

        $query  = "select * ";
        $query .= "from view_svt_all ";
        $query .= "where svt_id = '".$svtId."' ";
        $query .= "limit 1";

        if ($result = mysqli_query($this->link, $query)) {
            $svt = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
        }

        return $svt;
    }

    // Возвращает все ID из таблицы svt
    public function getSvtId()
    {
        $svtId = [];

        $query  = "select id ";
        $query .= "from svt ";
        $query .= "order by id";

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $svtId[$row['id']] = $row['id'];
            }
            mysqli_free_result($result);
        }

        return $svtId;
    }

    // Обновляет данные по СВТ
    public function updateSvt($id, $data)
    {
        $fields = [
            'modal_room_id' => 'room_id',
            'modal_model_id' => 'model_id',
            'modal_status_id' => 'status_id',
            'modal_svt_number' => 'number',
            'modal_svt_serial' => 'serial',
            'modal_svt_inv' => 'inv',
            'modal_svt_comment' => 'comment'
        ];

        $query  = "update svt ";
        $query .= "set ";
        $i = 0;
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $fields)) {
                continue;
            }
            $query .= ($i > 0 ? ", " : "").$fields[$key]." = '".htmlspecialchars($value)."'";
            $i++;
        }
        $query .= " where id = '".htmlspecialchars($id)."'";

        return ($i > 0) ? mysqli_query($this->link, $query) : false;
    }

/**************/
/***  ROOM  ***/
/**************/

    // Возвращает количество кабинетов
    public function getRoomCount($roomFilter=[])
    {
        $roomCount = 0;

        $query  = "select count(*) as 'count' ";
        $query .= "from view_room_all ";
        $query .= self::whereExpression($roomFilter);
        $query .= "limit 1";

        if ($result = mysqli_query($this->link, $query)) {
            if ($row = mysqli_fetch_assoc($result)) {
                $roomCount = intval($row['count']);
            }
            mysqli_free_result($result);
        }

        return $roomCount;
    }

    // Возвращает все ID из таблицы room
    public function getRoomId()
    {
        $roomId = [];

        $query  = "select id ";
        $query .= "from room ";
        $query .= "order by id";

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $roomId[$row['id']] = $row['id'];
            }
            mysqli_free_result($result);
        }

        return $roomId;
    }

/*****************/
/***  NETWORK  ***/
/*****************/

    // Возвращает список сетевых подключений
    public function getNetworkList()
    {
        $network = [];

        $query  = "select * ";
        $query .= "from view_network_sort ";
        $query .= "limit 100";

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $network[$row['id']] = $row;
            }
            mysqli_free_result($result);
        }

        return $network;
    }

    // Возвращает сетевое подключение по ID
    public function getNetworkById($networkId)
    {
        $network = [];

        $query  = "select * ";
        $query .= "from view_network_all ";
        $query .= "where network_id = '".$networkId."' ";
        $query .= "limit 1";

        if ($result = mysqli_query($this->link, $query)) {
            if ($row = mysqli_fetch_assoc($result)) {
                $network = $row;
            }
            mysqli_free_result($result);
        }

        return $network;
    }

}

?>
