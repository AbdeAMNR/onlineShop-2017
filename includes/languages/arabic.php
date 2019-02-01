<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 18-May-17
 * Time: 19:39
 * @param $phrase
 * @return mixed
 */

function lang($phrase)
{
    static $lang = array(
        'MESSAGE' => 'مرحبا',
        'ADMIN' => 'المدير',
        '' => '');
    return $lang[$phrase];
}