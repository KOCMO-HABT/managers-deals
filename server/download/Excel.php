<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');


require_once(__DIR__ . "/../grid/GetData/GetDeal/GetDeal.php");
require_once(__DIR__ . "/../grid/GetData/GetDataAnalysis.php");
require_once(__DIR__ . "/GetColumnsID.php");

// получаем объект опций таблицы
$gridOptions = new CGridOptions($_REQUEST['id']);

$columns = GetColumnsID($gridOptions);

// параметры сортировки лидов
$by = 'INCOME';
$order = 'desc';

$SortParams = $gridOptions->GetSorting()['sort'];

if (count($SortParams) > 0) {
    $by = array_key_first($SortParams);
    $order = $SortParams[$by];
}

// ?<--------------------------------------------------------------------------------------------------------------->

// получаем сделки сгруппированные по ответственным 
$data = GetDeal($_REQUEST['id']);
// подсчитываем статистические значения  
$data = GetDataAnalysis($data);

usort($data, function ($a, $b) use ($by, $order) {
    if ($order == 'asc') return $a[$by] - $b[$by];
    if ($order == 'desc') return $b[$by] - $a[$by];
});

// ?<--------------------------------------------------------------------------------------------------------------->

$tableStructure = [];

// формируем массив структуры таблицы
foreach ($data as $key => $value) $tableStructure[] = [
    'ASSIGNED_BY_ID' => "{$value['ASSIGNED_BY_NAME']} {$value['ASSIGNED_BY_LAST_NAME']}",
    'FAILED' => "{$value['FAILED']} ({$value['FAILED_PERCENT']} %)",
    'SUCCESS' => "{$value['SUCCESS']} ({$value['SUCCESS_PERCENT']} %)",
    'INCOME' => number_format($value['INCOME'], 2, ',', ' '),
    'AVG_PRICE_TOTAL' => number_format($value['AVG_PRICE_TOTAL'], 2, ',', ' '),
    'AVG_PRICE_SUCCESS' => number_format($value['AVG_PRICE_SUCCESS'], 2, ',', ' '),
    'POSSIBLE_SUM' => number_format($value['POSSIBLE_SUM'], 2, ',', ' '),
    'TOTAL' => $value['TOTAL'],
    'IS_WORK' => $value['IS_WORK'],
];

// ?<--------------------------------------------------------------------------------------------------------------->

Header("Content-Type: application/force-download");
Header("Content-Type: application/octet-stream");
Header("Content-Type: application/download");
Header("Content-Disposition: attachment;filename=Объём сделок по менеджерам.xls");
Header("Content-Transfer-Encoding: binary");

?>

<table>
    <thead>
        <tr>
            <? foreach ($columns as $key => $value) { ?>
                <td><?= $value['name'] ?></td>
            <? } ?>
        </tr>
    </thead>

    <tbody>
        <? foreach ($tableStructure as $key => $value) { ?>
            <tr>
                <? foreach ($columns as $key2 => $value2) { ?>
                    <td><?= $value[$value2['id']] ?></td>
                <? } ?>
            </tr>
        <? } ?>
    </tbody>
</table>