<?php
/**
 * Created by PhpStorm.
 * User: DEVPER
 * Date: 2022-06-09
 * Time: 오전 3:39
 */

$Agent = ['States' => getDistrictState()];
empty($member['mb_1']) !== true && ($member['agent'] = getDistrictNameByCode($member['mb_1']));
empty($member['mb_recommend']) !== true && ($member['mentor'] = sql_fetch("SELECT mb_id, mb_nick, mb_hp, mb_name FROM {$g5['member_table']} WHERE mb_id=" . fn_sql_quote($member['mb_recommend'])));