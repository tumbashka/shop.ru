<?php

function debug($data, $die = false)
{
    echo '<pre>' . PHP_EOL . print_r($data, true) . '</pre>';
    if ($die) {
        die();
    }
}

function h(string $str)
{
    return htmlspecialchars($str);
}

function redirect($url = false)
{
    if ($url) {
        $redirect = $url;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    header('Location: ' . $redirect);
    die();
}

function base_url(): string
{
    return PATH . '/' . (\tumba\App::$appReg->getProperty('lang') ? \tumba\App::$appReg->getProperty('lang') . '/' : '');
}

/**
 * @param string $key Key of GET array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
function get($key, $type = 'i')
{
    $param = $key;
    $$param = $_GET[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

/**
 * @param string $key Key of POST array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
function post($key, $type = 's')
{
    $param = $key;
    $$param = $_POST[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

function echoLang($key)
{
    echo \tumba\Language::get($key);
}

function getLang($key)
{
    return \tumba\Language::get($key);
}

function get_cart_icon($id)
{
    if (!empty($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart'])) {
        return '<i class="fa fa-luggage-cart"></i>';
    } else {
        return '<i class="fa fa-shopping-cart"></i>';
    }
}

function num2word($num, $words)
{
    $num = $num % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
        case 1:
        {
            return ($words[0]);
        }
        case 2:
        case 3:
        case 4:
        {
            return ($words[1]);
        }
        default:
        {
            return ($words[2]);
        }
    }
}

function sessionFormData($fieldName): string
{
    if (isset($_SESSION['form_data'][$fieldName])) {
        return h($_SESSION['form_data'][$fieldName]);
    } else {
        return "";
    }
}
