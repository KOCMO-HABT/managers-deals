<?

/*
 * узнаём пренадлежит ли данная дата временному периуду
 */
function inPeriod($data, $PeriodFrom, $PeriodTo)
{
    if ($data !== null) {
        // переводим время в Unix формат
        $PeriodFrom = +date_format(date_create($PeriodFrom), 'U');
        $PeriodTo = +date_format(date_create($PeriodTo), 'U');
        $data = +date_format(date_create($data), 'U');

        if ($data >= $PeriodFrom && $data <= $PeriodTo) return true;
    }

    return false;
}
