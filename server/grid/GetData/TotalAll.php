<?

/*
 * подсчёт итога по каждому столбику 
 */
function TotalAll(&$data)
{
    // массив итоговой строки
    $rowTotal = [
        // Кол-во сделок
        'TOTAL' => 0,
        // Сделок в работе
        'IS_WORK' => 0,
        // Выиграно
        'SUCCESS' => 0,
        // Проиграно
        'FAILED' => 0,
        // Средняя сумма сделки
        'AVG_PRICE_TOTAL' => 0,
        // Средний чек
        'AVG_PRICE_SUCCESS' => 0,
        // Возможная сумма
        'POSSIBLE_SUM' => 0,
        // Доход от выигранных сделок
        'INCOME' => 0,
    ];

    // ?<--------------------------------------------------------------------------------------------------------------->

    // сумируем значения из каждого столбца
    foreach ($data as $key => &$value) {
        $rowTotal['TOTAL'] += $value['data']['TOTAL'];
        $rowTotal['IS_WORK'] += $value['data']['IS_WORK'];
        $rowTotal['SUCCESS'] += $value['data']['SUCCESS'];
        $rowTotal['FAILED'] += $value['data']['FAILED'];
        $rowTotal['AVG_PRICE_TOTAL'] += $value['data']['AVG_PRICE_TOTAL'];
        $rowTotal['AVG_PRICE_SUCCESS'] += $value['data']['AVG_PRICE_SUCCESS'];
        $rowTotal['POSSIBLE_SUM'] += $value['data']['POSSIBLE_SUM'];
        $rowTotal['INCOME'] += $value['data']['INCOME'];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    // вычисляем % от общего количества у закрытых сделок
    $rowTotal['SUCCESS_PERCENT'] = round(($rowTotal['SUCCESS'] * 100) / $rowTotal['TOTAL'], 2);
    $rowTotal['FAILED_PERCENT'] = round(($rowTotal['FAILED'] * 100) / $rowTotal['TOTAL'], 2);

    // ?<--------------------------------------------------------------------------------------------------------------->

    // добовляем в общий массив элементов
    $data[] = [
        'id' => 0,
        'data' => $rowTotal,
        'columns' => [
            'ASSIGNED_BY_ID' => 'Итог:',
            'FAILED' => "{$rowTotal['FAILED']} ({$rowTotal['FAILED_PERCENT']} %)",
            'SUCCESS' => "{$rowTotal['SUCCESS']} ({$rowTotal['SUCCESS_PERCENT']} %)",
            'INCOME' => number_format($rowTotal['INCOME'], 2, ',', ' '),
            'AVG_PRICE_TOTAL' => number_format($rowTotal['AVG_PRICE_TOTAL'], 2, ',', ' '),
            'AVG_PRICE_SUCCESS' => number_format($rowTotal['AVG_PRICE_SUCCESS'], 2, ',', ' '),
            'POSSIBLE_SUM' => number_format($rowTotal['POSSIBLE_SUM'], 2, ',', ' '),
        ]
    ];
}
