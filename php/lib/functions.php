<?php

// функция возвращет сегменты запроса из адресной строки
function getAddressParts()
{
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($url, '/'));

    return $segments;
}

// функция извлекает не пустые данные из POST-запроса
function getPostData()
{
    $data = [];

    if (isset($_POST)) {
        foreach ($_POST as $key => $value) {
            if (strlen(trim($value))) {
                $data[$key] = htmlspecialchars($value);
            }

        }
    }

    return $data;
}

// функция обеспечивает защиту от XSS
function dataFiltering($data)
{
    if (is_array($data)) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = dataFiltering($value);
        }
    } elseif (is_object($data)) {
        foreach ($data as $key => $value) {
            $data->$key = dataFiltering($value);
        }
        return $data;
    } else {
        $result = htmlspecialchars($data);
    }

    return $result;
}

// функция выводит шаблон из заданного файла
function includeTemplate($template, $data = [])
{
    $file = $GLOBALS['appTemplatesPath'].'/'.$template.'.php';

    $result = "";

    if (file_exists($file)) {
        $data = dataFiltering($data);
        extract($data);
        ob_start();
        include($file);
        $result = ob_get_clean();
    }

    echo $result;
}
