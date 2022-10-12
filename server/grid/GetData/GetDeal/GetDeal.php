<?

require_once(__DIR__ . "/AdditionalFilter.php");
require_once(__DIR__ . "/inPeriod.php");


use Bitrix\Main\Ui\Filter\Options as FilterOptions;

/*
 * получаем сделки рзсортированые по ответсвенным  
 */

function GetDeal($filter_id)
{
    $res = [];

    // получаем настройки фильтра
    $filter_options = new FilterOptions($filter_id);
    $paramsFilter = $filter_options->getFilter();

    $periodFrom = isset($paramsFilter['PERIOD_from']) ? $paramsFilter['PERIOD_from'] : date('01.m.Y 00:00:00');
    $periodTo = isset($paramsFilter['PERIOD_to']) ? $paramsFilter['PERIOD_to'] : date('t.m.Y 23:59:59');

    // ?<--------------------------------------------------------------------------------------------------------------->

    $arSelect = [
        'STAGE_SEMANTIC_ID', 'ASSIGNED_BY_ID', 'ASSIGNED_BY_NAME', 'ASSIGNED_BY_LAST_NAME', 'OPPORTUNITY', 'CLOSEDATE',
        'DATE_CREATE', 'ID'
    ];

    $arFilter = [
        '=IS_RECURRING' => 'N',
        '>=DATE_CREATE' => $periodFrom,
        '<=DATE_CREATE' => $periodTo,
    ];

    // дополняем фильтр ответсвенными
    if ($paramsFilter['ASSIGNED_BY_ID']) $arFilter = AdditionalFilter($arFilter, $paramsFilter);

    // получаем сделки созданные за данынй периуд
    $Element = CCrmDeal::GetListEx([], $arFilter, false, false, $arSelect);
    while ($arFields = $Element->GetNext()) {
        // $res[$arFields['ASSIGNED_BY_ID']]['data'][] = $arFields;

        if ($arFields['STAGE_SEMANTIC_ID'] !== '') {
            $res[$arFields['ASSIGNED_BY_ID']]['ASSIGNED_BY_ID'] = $arFields['ASSIGNED_BY_ID'];
            $res[$arFields['ASSIGNED_BY_ID']]['ASSIGNED_BY_NAME'] = $arFields['ASSIGNED_BY_NAME'];
            $res[$arFields['ASSIGNED_BY_ID']]['ASSIGNED_BY_LAST_NAME'] = $arFields['ASSIGNED_BY_LAST_NAME'];
        }

        // "Количество сделок" созданных за периуд
        $res[$arFields['ASSIGNED_BY_ID']]['TOTAL'][] = $arFields;

        // успешные сделки закрытые в данном периоде
        if ($arFields['STAGE_SEMANTIC_ID'] === 'S' && inPeriod($arFields['CLOSEDATE'], $periodFrom, $periodTo)) {
            $res[$arFields['ASSIGNED_BY_ID']]['SUCCESS'][] = $arFields;
        }

        // проваленные сделки закрытые в данном периоде
        if ($arFields['STAGE_SEMANTIC_ID'] === 'F' && inPeriod($arFields['CLOSEDATE'], $periodFrom, $periodTo)) {
            $res[$arFields['ASSIGNED_BY_ID']]['FAILED'][] = $arFields;
        }

        // если сделка находитмся в работе то обнуляем поле "дата закрытия"/"предположительная дата закрытия"
        if ($arFields['STAGE_SEMANTIC_ID'] === 'P') $arFields['CLOSEDATE'] = null;

        // "сделки в работе" (сделки которые были созданы и не закрыты в данном периоде)
        if (inPeriod($arFields['DATE_CREATE'], $periodFrom, $periodTo) && !inPeriod($arFields['CLOSEDATE'], $periodFrom, $periodTo)) {
            $res[$arFields['ASSIGNED_BY_ID']]['IS_WORK'][] = $arFields;
        }
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    sort($res);

    // ?<--------------------------------------------------------------------------------------------------------------->

    return $res;
}
