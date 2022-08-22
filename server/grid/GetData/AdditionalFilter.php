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


    $arParams['SELECT'] = ['ID'];
    $arFilterUsers = [
        'UF_DEPARTMENT' => $arrDepartment,
    ];

    // получаем сотрудников подраздилений
    $rsUsers = CUser::GetList(false, false, $arFilterUsers, $arParams);
    while ($rsUsersa = $rsUsers->Fetch()) {
        $arrUser[] = $rsUsersa['ID'];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    $arFilter['ASSIGNED_BY_ID'] = $arrUser;

    return $arFilter;
}
