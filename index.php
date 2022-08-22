<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Объём сделок по менеджерам");

require_once(__DIR__ . "/server/filter/Filter.php");
require_once(__DIR__ . "/server/grid/Grid.php");

// ?<--------------------------------------------------------------------------------------------------------------->

$grid_id = $filter_id = 'ManagersDealsReportV2';


?>
<div style="display: flex; flex-direction: column;">
    <div class="filter">
        <?
        // компанент фильтра
        Filter($grid_id, $filter_id);
        ?>
    </div>

    <div class="grid" style="overflow: hidden;">
        <?
        // компанент таблицы
        Grid($grid_id, $filter_id);
        ?>
    </div>
</div>

<script type="module" src="index.js"></script>


<?
// $APPLICATION->AddHeadScript('/local/customB24/reports/ManagersDeals/index.js');

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>