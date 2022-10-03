<?

/*
 * возвращаем столбцы которые будут выводится в таблицы 
 */
function GetColumns()
{

    $columns = [
        ['id' => 'ASSIGNED_BY_ID', 'name' => 'Ответственный', 'sort' => 'ASSIGNED_BY_ID', 'default' => true],
        ['id' => 'TOTAL', 'name' => 'Кол-во сделок', 'sort' => 'TOTAL', 'default' => true],
        ['id' => 'IS_WORK', 'name' => 'Сделок в работе', 'sort' => 'IS_WORK', 'default' => true],
        ['id' => 'SUCCESS', 'name' => 'Выиграно', 'sort' => 'SUCCESS', 'default' => true],
        ['id' => 'FAILED', 'name' => 'Проиграно', 'sort' => 'FAILED', 'default' => true],
        ['id' => 'AVG_PRICE_TOTAL', 'name' => 'Средняя сумма сделки', 'sort' => 'AVG_PRICE_TOTAL', 'default' => true],
        ['id' => 'AVG_PRICE_SUCCESS', 'name' => 'Средний чек', 'sort' => 'AVG_PRICE_SUCCESS', 'default' => true],
        ['id' => 'POSSIBLE_SUM', 'name' => 'Возможная сумма', 'sort' => 'POSSIBLE_SUM', 'default' => true],
        ['id' => 'INCOME', 'name' => 'Доход от выигранных сделок', 'sort' => 'INCOME', 'default' => true],
    ];


    return $columns;
}
