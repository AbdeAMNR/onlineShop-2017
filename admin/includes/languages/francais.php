<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 18-May-17
 * Time: 19:33
 * @param $phrase
 * @return mixed
 */
function lang($phrase)
{
    static $lang = array(
        'MESSAGE' => 'salut',
        'ADMIN' => 'Administrateur',
        '' => '');
    return $lang[$phrase];
}