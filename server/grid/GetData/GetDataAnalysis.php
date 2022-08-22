<?

/*
 * подсчитываем статестические значения  
 */
function GetDataAnalysis($data)
{
    foreach ($data as $key => $value) {
        // "Доход от выигранных сделок"
        $income = array_sum(array_map(function ($elem) {
            return $elem['OPPORTUNITY'];
        }, $value['SUCCESS']));

        $data[$key]['INCOME']  = $income === null ? 0 : round($income, 2);

        // ?<--------------------------------------------------------------------------------------------------------------->

        // "Средний чек" средняя сумма сделок созданых и закрытытх в данном периоде
        if ($income) {
            $data[$key]['AVG_PRICE_SUCCESS'] =  round($income / count($value['SUCCESS']), 2);
        } else {
            $data[$key]['AVG_PRICE_SUCCESS'] = 0;
        }

        // ?<--------------------------------------------------------------------------------------------------------------->

        // "Средняя сумма" сделок созданные в данном периоде
        $avg_price = array_sum(array_map(function ($elem) {
            return $elem['OPPORTUNITY'];
        }, $value['TOTAL']));

        $data[$key]['AVG_PRICE_TOTAL'] =  round($avg_price / count($value['TOTAL']), 2);

        // ?<--------------------------------------------------------------------------------------------------------------->

        // "Возможная сумма" сумма созданых сделок за периуд
        $data[$key]['POSSIBLE_SUM'] = $avg_price;

        // ?<--------------------------------------------------------------------------------------------------------------->

        // подсчитываем количества
        $data[$key]['TOTAL'] = count($value['TOTAL']);
        $data[$key]['IS_WORK'] = count($value['IS_WORK']);

        // вычисляем % у закрытых сделок
        $data[$key]['SUCCESS'] = round((count($value['SUCCESS']) * 100) / $data[$key]['TOTAL'], 2);
        $data[$key]['FAILED'] = round((count($value['FAILED']) * 100) / $data[$key]['TOTAL'], 2);
    }

    return $data;
}
