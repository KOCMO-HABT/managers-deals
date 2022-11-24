<?

require_once(__DIR__ . "/../grid/GetColumns.php");


/*
 * получаем id столбцов 
 */
function GetColumnsID($gridOptions)
{

    // получаем пользовательский порядок колонок таблицы
    $columnsID = $gridOptions->GetVisibleColumns();

    $columns = GetColumns();

    if (count($columnsID) === 0) {
        foreach ($columns as $key => $value) if ($value['default']) $columnsID[] = [
            'id' => $value['id'],
            'name' => $value['name']
        ];
    } else {
        foreach ($columnsID as $key => &$value) foreach ($columns as $key2 => $value2) {
            if ($value === $value2['id']) {
                $value = [
                    'id' => $value,
                    'name' => $value2['name']
                ];
            }
        }
    }

    return $columnsID;
}
