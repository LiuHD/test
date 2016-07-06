<?php
ini_set('display_errors', true);
/**
 * walk out all the combination
 * @param $str
 * @param int $start
 * @param int $len
 * @param string $origin_str
 */
function fun($str, $start = 0, $len = 1, $origin_str = '')
{
    $str_len = strlen($str);
    //起点
    for ($i = $start; $i <= $str_len - 1; $i++) {
        //目标长度
        for ($j = $len; $j + $i <= $str_len && $j > 0; $j++) {
            fun2($str,$i,$j,$origin_str);
            echo '<br>';
        }
        echo '<br>';
    }
}

/**
 * put the character on the certain position of the
 * given string to the original string
 * @param $str
 * @param $i
 * @param $j
 * @param $origin_str
 */
function fun2($str, $i, $j, $origin_str)
{
    $str_len = strlen($str);
    if ($j + $i == $str_len) {
        $origin_str .= substr($str, $i);
        echo $origin_str . ' ';
    }
    elseif ($j >= 2) {
        for ($n = $i + 1; $n < $str_len; $n++) {
            if ($n + $j <= $str_len+1) {
                fun2($str, $n, $j-1, $origin_str.$str[$i]);
            }
        }
    }
    else {
        echo $origin_str . $str[$i] . ' ';
    }
}

fun('abcdef');