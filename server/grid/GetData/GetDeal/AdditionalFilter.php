<?


/*
 * дополняем фильтр для поиска 
 */
function AdditionalFilter($arFilter, $paramsFilter)
{

    $arrUser = $arrDepartment = [];

    // распределяем id пользоватлей и отделов по массивам
    foreach ($paramsFilter['ASSIGNED_BY_ID'] as $key => $value) {
        $value = json_decode($value, true);

        if ($value[0] === 'user') $arrUser[] = $value[1];
        if ($value[0] === 'fired-user') $arrUser[] = $value[1];
        if ($value[0] === 'department') $arrDepartment[] = $value[1];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    if ($arrDepartment) {
        $arSelect = ['ID', 'LEFT_MARGIN', 'IBLOCK_ID', 'RIGHT_MARGIN', 'DEPTH_LEVEL'];

        // получаем все дочернии подразделения выбранных подраздилений
        $rsParentSection = CIBlockSection::GetList(['left_margin' => 'asc'], ['ID' => $arrDepartment], false,  $arSelect);
        while ($arParentSection = $rsParentSection->GetNext()) {
            // выбераем потомков
            $arFilter2 = [
                'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                'ACTIVE' => 'Y',
                '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],
                '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],
                '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']
            ];
            $rsSect = CIBlockSection::GetList(['left_margin' => 'asc'], $arFilter2, false, $arSelect);
            while ($arSect = $rsSect->GetNext()) {
                $arrDepartment[] = $arSect['ID'];
            }
        }

        // удоляем дубли 
        $arrDepartment = array_values(array_unique($arrDepartment));

        // ?<--------------------------------------------------------------------------------------------------------------->

        $arParams['SELECT'] = ['ID'];
        $arFilterUsers = [
            'UF_DEPARTMENT' => $arrDepartment,
        ];

        // получаем сотрудников подраздилений
        $rsUsers = CUser::GetList(false, false, $arFilterUsers, $arParams);
        while ($rsUsersa = $rsUsers->Fetch()) {
            $arrUser[] = $rsUsersa['ID'];
        }
    }
    // ?<--------------------------------------------------------------------------------------------------------------->

    $arFilter['ASSIGNED_BY_ID'] = $arrUser;

    return $arFilter;
}
