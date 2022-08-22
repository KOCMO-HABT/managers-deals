<?

// получаем список лидов
require_once(__DIR__ . "/GetData/GetData.php");
// получаем столбцы дял таблицы
require_once(__DIR__ . "/GetColumns.php");

/*
 * иницеализируем таблицу 
 */
function Grid($grid_id, $filter_id)
{
    /*
    * получаем:
    * $list - список строк дял таблицы
    * $total - количество всех элементов
    */
    [$list, $total] = GetData($grid_id, $filter_id);

    $columns = GetColumns();

    // ?<--------------------------------------------------------------------------------------------------------------->

    global $APPLICATION;

    $APPLICATION->IncludeComponent(
        "bitrix:main.ui.grid",
        ".default",
        array(
            "GRID_ID" => $grid_id,
            "COLUMNS" => $columns,
            "ROWS" => $list,
            "SHOW_ROW_CHECKBOXES" => false,
            // "NAV_OBJECT" => $nav,
            // "SEF_MODE" => "Y",
            "SHOW_COUNT" => "N",
            "AJAX_MODE" => "Y",
            "AJAX_ID" => \CAjax::getComponentID("bitrix:main.ui.grid", ".default", ""),
            "PAGE_SIZES" => array(
                ["NAME" => "20", "VALUE" => "20"],
                ["NAME" => "50", "VALUE" => "50"],
                ["NAME" => "100", "VALUE" => "100"],
            ),
            "AJAX_OPTION_JUMP" => "N",
            "SHOW_CHECK_ALL_CHECKBOXES" => false,
            "SHOW_ROW_ACTIONS_MENU" => false,
            "SHOW_GRID_SETTINGS_MENU" => true,
            "SHOW_NAVIGATION_PANEL" => true,
            "SHOW_PAGINATION" => true,
            "SHOW_SELECTED_COUNTER" => false,
            "SHOW_TOTAL_COUNTER" => true,
            "TOTAL_ROWS_COUNT" => $total,
            "SHOW_PAGESIZE" => true,
            "SHOW_ACTION_PANEL" => true,
            "ALLOW_COLUMNS_SORT" => true,
            "ALLOW_COLUMNS_RESIZE" => true,
            "ALLOW_HORIZONTAL_SCROLL" => true,
            "ALLOW_SORT" => true,
            "ALLOW_PIN_HEADER" => true,
            "AJAX_OPTION_HISTORY" => "N",
            "COMPONENT_TEMPLATE" => ".default",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "DYNAMIC_WITH_STUB",
        ),
        false
    );
}
