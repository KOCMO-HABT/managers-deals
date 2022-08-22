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
        ['id' => 'SUCCESS', 'name' => 'Выиграно', 'sort' => 'IS_WORK', 'default' => true],
        ['id' => 'FAILED', 'name' => 'Проиграно', 'sort' => 'IS_WORK', 'default' => true],
        ['id' => 'AVG_PRICE_TOTAL', 'name' => 'Средняя сумма сделки', 'sort' => 'IS_WORK', 'default' => true],
        ['id' => 'AVG_PRICE_SUCCESS', 'name' => 'Средний чек', 'sort' => 'IS_WORK', 'default' => true],
        ['id' => 'POSSIBLE_SUM', 'name' => 'Возможная сумма', 'sort' => 'IS_WORK', 'default' => true],
        ['id' => 'INCOME', 'name' => 'Доход от выигранных сделок', 'sort' => 'IS_WORK', 'default' => true],
    ];


    return $columns;
}
