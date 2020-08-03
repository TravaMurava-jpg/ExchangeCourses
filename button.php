<?php

$connect = mysqli_connect('localhost', 'mysql', 'mysql', 'exchange');

if ($connect == false){
    echo 'Не удается подключиться к БД';
    echo mysqli_connect_error;
    exit();
}



function get_currency($currency_code, $format) {

$date = date('d/m/Y'); // Текущая дата
$cache_time_out = '3600'; // Время жизни кэша в секундах

$file_currency_cache = __DIR__.'/XML_daily.asp';

if(!is_file($file_currency_cache) || filemtime($file_currency_cache) < (time() - $cache_time_out)) {

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.cbr.ru/scripts/XML_daily.asp?date_req='.$date);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

$out = curl_exec($ch);

curl_close($ch);

file_put_contents($file_currency_cache, $out);

}

$content_currency = simplexml_load_file($file_currency_cache);

return number_format(str_replace(',', '.', $content_currency->xpath('Valute[CharCode="'.$currency_code.'"]')[0]->Value), $format);

}

if(!is_file($file_currency_cache) || filemtime($file_currency_cache) < (time() - $cache_time_out)) {
    $result = mysqli_query($connect, "SELECT * FROM `currencies`");

    while (($value = mysqli_fetch_assoc($result))) {
        $i=0;
        $j = $array['Exchange'][$i];
        $H = $i + 1;
        mysqli_query($connect, "UPDATE `currencies` SET `BuyValue` = $new WHERE `currencies`.`id` = $H");
        $i=$i+1;
    }
}
echo '<pre>';
if(isset($_POST['CHeck'])) {


    $array = $_POST;
    for ($i = 0; $i < count($array['Exchange']); $i++) {
        $j = $array['Exchange'][$i];
        $new = get_currency("$j", 3);
        echo '<li>' . $j . " = " . $new . '</li>' ;
        echo '<br>';
        $result = mysqli_query($connect, "SELECT * FROM `currencies`");
        $H = $i+1;
        mysqli_query($connect, "UPDATE `currencies` SET `BuyValue` = $new WHERE `currencies`.`id` = $H");
    }


} elseif(isset($_POST['Release'])) {
    $array = $_POST;
    $i = 0;
    $result = mysqli_query($connect, "SELECT * FROM `currencies`");
    while (($value = mysqli_fetch_assoc($result))) {
        if ($array['Exchange'][$i] == $value['ValueType']) {
            echo '<li>' . $value['ValueType'] . " = " . $value['BuyValue'] . '</li>';
            $i = $i+1;
        }
    }
}
?>
