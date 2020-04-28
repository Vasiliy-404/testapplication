<?
function write($text, $isDump = false)
{
    if($isDump)
    {
        var_dump($text);
    }
    else
    {
        echo '<pre>';
        print_r($text);
        echo '</pre>';
    }
}

function strftimeRus($format, $date = FALSE)
{
    if (!$date)
        $timestamp = time();
    
    elseif (!is_numeric($date))
        $timestamp = strtotime($date);
    
    else
        $timestamp = $date;
    
    if (strpos($format, '%B2') === FALSE)
        return strftime($format, $timestamp);
    
    $month_number = date('n', $timestamp);
    
    switch ($month_number)
    {
        case 1: $rus = 'января'; break;
        case 2: $rus = 'февраля'; break;
        case 3: $rus = 'марта'; break;
        case 4: $rus = 'апреля'; break;
        case 5: $rus = 'мая'; break;
        case 6: $rus = 'июня'; break;
        case 7: $rus = 'июля'; break;
        case 8: $rus = 'августа'; break;
        case 9: $rus = 'сентября'; break;
        case 10: $rus = 'октября'; break;
        case 11: $rus = 'ноября'; break;
        case 12: $rus = 'декабря'; break;
        default: break;
    }
    
    $rusformat = str_replace('%B2', $rus, $format);
    return strftime($rusformat, $timestamp);
}

function getDeclinationYear($dayNumber)
{
    $dayNumber = (string)$dayNumber;
    $lastNum = $dayNumber[strlen($dayNumber) - 1];
    $result = false;
    switch ($lastNum)
    {
        case '0': $result = 'лет'; break;
        case '1': $result = 'год'; break;
        case '2': $result = 'года'; break;
        case '3': $result = 'года'; break;
        case '4': $result = 'года'; break;
        case '5': $result = 'лет'; break;
        case '6': $result = 'лет'; break;
        case '7': $result = 'лет'; break;
        case '8': $result = 'лет'; break;
        case '9': $result = 'лет'; break;        
        default: break;
    }
    return $result;
}

function getDaysLeftUntil($birthday)
{
    $month = getMonthLeftUntil($birthday);
    $bd = explode('.', $birthday);
    $bd = mktime(0, 0, 0, $bd[1] - $month, $bd[0], date('Y') + ($bd[1] . $bd[0] <= date('md')));
    $daysUntil = ceil(($bd - time()) / 86400);
    return $daysUntil;
}

function getMonthLeftUntil($birthday)
{
    $bd = explode('.', $birthday);
    $bd = mktime(0, 0, 0, $bd[1], $bd[0], date('Y') + ($bd[1] . $bd[0] <= date('md')));
    $monthUntil = ceil(($bd - time()) / 2592000);
    return $monthUntil - 1;
}

function getDeclinationMonth($monthNumber)
{
    $dayNumber = (string)$monthNumber;
    $lastNum = $dayNumber[strlen($dayNumber) - 1];
    $result = false;
    switch ($lastNum)
    {
        case '0': $result = ''; break;
        case '1': $result = 'месяц'; break;
        case '2': $result = 'месяца'; break;
        case '3': $result = 'месяца'; break;
        case '4': $result = 'месяца'; break;
        case '5': $result = 'месяцев'; break;
        case '6': $result = 'месяцев'; break;
        case '7': $result = 'месяцев'; break;
        case '8': $result = 'месяцев'; break;
        case '9': $result = 'месяцев'; break;        
        default: break;
    }
    return $result;
}

function getDeclinationDay($dayNumber)
{
    $dayNumber = (string)$dayNumber;
    $lastNum = $dayNumber[strlen($dayNumber) - 1];
    $result = false;
    switch ($lastNum)
    {
        case '0': $result = ''; break;
        case '1': $result = 'день'; break;
        case '2': $result = 'дня'; break;
        case '3': $result = 'дня'; break;
        case '4': $result = 'дня'; break;
        case '5': $result = 'дней'; break;
        case '6': $result = 'дней'; break;
        case '7': $result = 'дней'; break;
        case '8': $result = 'дней'; break;
        case '9': $result = 'дней'; break;        
        default: break;
    }
    return $result;
}
?>