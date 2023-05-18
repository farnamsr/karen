<?php
function randstr($length = 10) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function fa_number($number){
   if(empty($number))
   return '۰';
   $en = array("0","1","2","3","4","5","6","7","8","9");
   $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
   return str_replace($en, $fa, $number);
}
