<?


require_once(__DIR__ . "/GetDeal.php");
require_once(__DIR__ . "/GetDataAnalysis.php");


\Bitrix\Main\Loader::includeModule('crm');


use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\Ui\Filter\Options as FilterOptions;


function GetData($grid_id, $filter_id)
{

    // получаем настройки фильтра
    $filter_options = new FilterOptions($filter_id);
    $paramsFilter = $filter_options->getFilter();

    // ?<--------------------------------------------------------------------------------------------------------------->

    $list = [];

    // параметры сортировки лидов
    $by = isset($_GET['by']) ? $_GET['by'] : 'INCOME';
    $order = isset($_GET['order']) ? $_GET['order'] : 'desc';

    // ?<--------------------------------------------------------------------------------------------------------------->

    // получаем сделки сгруперованные по ответсвенным 
    $data = GetDeal($filter_id);

    // подсчитываем статестические значения  
    $data = GetDataAnalysis($data);

    foreach ($data as $key => $value) {
        $list[] = [
            'id' => $value['ASSIGNED_BY_ID'],
            'data' => $value,
            'columns' => [
                'ASSIGNED_BY_ID' => '<a href="/company/personal/user/' . $value['ASSIGNED_BY_ID'] . '/">' . $value['ASSIGNED_BY_NAME'] . ' ' . $value['ASSIGNED_BY_LAST_NAME'] . '</a>',
                'FAILED' => "{$value['FAILED']} ({$value['FAILED_PERCENT']} %)",
                'SUCCESS' => "{$value['SUCCESS']} ({$value['SUCCESS_PERCENT']} %)",
                'INCOME' => number_format($value['INCOME'], 2, ',', ' '),
                'AVG_PRICE_TOTAL' => number_format($value['AVG_PRICE_TOTAL'], 2, ',', ' '),
                'AVG_PRICE_SUCCESS' => number_format($value['AVG_PRICE_SUCCESS'], 2, ',', ' '),
                'POSSIBLE_SUM' => number_format($value['POSSIBLE_SUM'], 2, ',', ' '),
            ]
        ];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    // сортировка списка элементов
    usort($list, function ($a, $b) use ($by, $order) {
        if ($order == 'asc') return $a['data'][$by] - $b['data'][$by];
        if ($order == 'desc') return $b['data'][$by] - $a['data'][$by];
    });

    // ?<--------------------------------------------------------------------------------------------------------------->

    $total = count($list);



    return [$list, $total];
}
