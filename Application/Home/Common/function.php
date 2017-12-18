<?php
function mbs_substr($str, $length, $tail = '...')
{
    $len = mb_strlen($str, 'utf-8');//获取字符串的长度
    if ($len > $length) {
        return mb_substr($str, 0, $length, 'utf-8') . $tail;
    } else {
        return $str;
    }
} 

