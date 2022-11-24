<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Объём сделок по менеджерам");

require_once(__DIR__ . "/server/filter/Filter.php");
require_once(__DIR__ . "/server/grid/Grid.php");

// ?<--------------------------------------------------------------------------------------------------------------->

$grid_id = $filter_id = 'ManagersDealsReportV2';


?>
<link href="./style.css?<?= filemtime('./style.css') ?>" rel="stylesheet">


<div style="display: flex; flex-direction: column;">
    <div class="filter">
        <?
        // компонент фильтра
        Filter($grid_id, $filter_id);
        ?>

        <a href="server/download/Excel.php?id=<?= $filter_id ?>" class="ui-btn ui-btn-primary download">скачать</a>
    </div>

    <div class="grid" style="overflow: hidden;">
        <?
        // компонент таблицы
        Grid($grid_id, $filter_id);
        ?>
    </div>
</div>

<script type="module" src="index.js"></script>


<?
// $APPLICATION->AddHeadScript('/local/customB24/reports/ManagersDeals/index.js');

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>