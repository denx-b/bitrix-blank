<?
/**
 * Рекурсивная фильтрация массива через htmlspecialcharsbx
 *
 * @param $array
 * @return array
 */
function specialchars_recursive($array) {
    $result = array();
    $values = array();

    foreach($array as $k => $val) {
        $values[ $k ] = $val;
    }

    foreach($values as $k => $val) {
        if (is_array($val))
            $result[ $k ] = specialchars_recursive($val);
        else
            $result[ $k ] = htmlspecialcharsbx( trim($val) );
    }

    return $result;
}
