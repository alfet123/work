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
    public function getBuildList()
    {
        $build = [];

        $query  = "select * ";
        $query .= "from build ";
        $query .= "order by sort";

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $build[$row['id']] = $row;
            }
            mysqli_free_result($result);
        }

        return $build;
    }

    // Возвращает список этажей в здании
    public function getFloorList($buildId)
    {
        $floor = [];

        $query  = "select * ";
        $query .= "from floor ";
        $query .= "where build_id = '".$buildId."' ";
        $query .= "order by number";

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $floor[$row['id']] = $row;
            }
            mysqli_free_result($result);
        }

        return $floor;
    }

    // Возвращает список кабинетов на этаже
    public function getRoomList($floorId)
    {
        $room = [];

        $query  = "select * ";
        $query .= "from room ";
        $query .= "where floor_id = '".$floorId."' ";
        $query .= "order by sort, number";

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $room[$row['id']] = $row;
            }
            mysqli_free_result($result);
        }

        return $room;
    }

    // Возвращает список типов СВТ
    public function getTypeList()
    {
        $type = [];

        $query  = "select * ";
        $query .= "from type ";
        $query .= "order by sort";

        if ($result = mysqli_query($this->link, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $type[$row['id']] = $row;
            }
            mysqli_free_result($result);
        }

        return $type;
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
            'type_id' => [
                'field' => 'type_id',
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

//echo "<pre><br>";
//echo "getSvtCount() -> ".$query;
//echo "</pre>";

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
        $svt = [];

        $query  = "select * ";
        $query .= "from view_svt_all ";
        $query .= self::whereExpression($svtFilter);
        $query .= self::orderExpression();
        $query .= "limit 25";

//echo "<pre><br>";
//echo "getSvtList() -> ".$query;
//echo "</pre>";

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
            if ($row = mysqli_fetch_assoc($result)) {
                $svt = $row;
            }
            mysqli_free_result($result);
        }

        return $svt;
    }

    // Возвращает все ID из таблицы svt
    public function getSvtId()
    {
        $svtId = [];

        $query  = "select * ";
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
