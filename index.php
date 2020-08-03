<?php


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Create connection
$connect = mysqli_connect('localhost', 'mysql', 'mysql', 'exchange');

if ($connect == false){
    echo 'Не удается подключиться к БД';
    echo mysqli_connect_error;
    exit();
}


?>
    <form action="button.php" method="post">
        <select name="Exchange[]" multiple form">
        <option value='USD'>Доллар</option>
        <option value='EUR'>Евро</option>
        <option value='UAH'>10 украинских гривен</option>
        <option value='KGS'>100 кргизских сомов</option>
        <option value='AUD'>Австралийский доллар</option>
        <option value='AZN'>Азербайджанский манат</option>
        </select>
        <button type="submit" name="CHeck">Обновить и отобразить данные для выбранных валют</button>

        <button type="submit" name="Release">Проверить курсы</button>
</form>









