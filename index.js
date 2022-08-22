
/*
 * устанавливаем дефолтное значение периуда "текущий месяц" 
 */
let filter = BX.Main.filterManager.getById('ManagersDealsReportV2'); // id фильтра
let values = filter.getFilterFieldsValues();


if (values['PERIOD_datesel'] === '' || values['PERIOD_datesel'] === 'NONE') {
    values['PERIOD_datesel'] = 'CURRENT_MONTH';
}

filter.getApi().setFields(values);
// filter.getApi().apply();


BX.addCustomEvent("BX.Main.Filter:apply", async (filterID, eventName, eventParams, secureParams) => {
    // console.log(filterID);
    // console.log(eventName);
    // console.log(eventParams);
    // console.log(secureParams);

    let values = eventParams.getFilterFieldsValues();


    if (values['PERIOD_datesel'] === '' || values['PERIOD_datesel'] === 'NONE') {
        values['PERIOD_datesel'] = 'CURRENT_MONTH';
    }


    eventParams.getApi().setFields(values);
    // filter.getApi().apply();

});