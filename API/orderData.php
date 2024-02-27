<?php
//수동 DB 수정용 입니다. 실서비스용 절대 아님.
if($_SERVER['REMOTE_ADDR'] != '211.44.188.4'){
    exit();
}
use \Webmozart\Assert\Assert;
use \ezyang\htmlpurifier;
use \barry\common\Util as barryUtil;
use \barry\order\Util as barryOrderUtil;
use \barry\db\DriverApi as barryDb;
use \barry\encrypt\RsaApi as barryRsa;

require __DIR__ .'/vendor/autoload.php';

$config = \HTMLPurifier_Config::createDefault();
$purifier = new \HTMLPurifier($config);
$util = barryUtil::singletonMethod();
$db = barryDb::singletonMethod();
$orderUtil = barryOrderUtil::singletonMethod();
$barrydb = $db-> init();
$barryRsa = new barryRsa;

$item = $barrydb->createQueryBuilder()
    ->select('*')
    ->from('g5_write_Shop')
//    ->where('wr_id = ?')
//    ->setParameter(0,551)
//    ->setFirstResult(0)
//    ->setMaxResults(2)
    ->execute()->fetchAll();

echo (count($item));

//wr1 -> TP3
//wr2 -> MC
//wr10 -> KRW
// wr1 and wr2 -> TP3MC

var_dump($item[0]['wr_1']);
var_dump($item[0]['wr_2']);
var_dump($item[0]['wr_10']);
var_dump((int)$item[0]['wr_1']);
var_dump((int)$item[0]['wr_2']);
var_dump((int)$item[0]['wr_10']);

foreach ($item as $key => $value){
    $updateProc = $barrydb->createQueryBuilder()
        ->update('g5_write_Shop')
        ->set('wr_price_type', '?')
        ->where('wr_id = ?');
        if((int)$value['wr_1'] == 0 && (int)$value['wr_2'] > 0 && empty($value['wr_10'])){
            $updateProc->setParameter(0, 'MC');
            echo('aa');

            var_dump((int)$value['wr_1']);
            var_dump(empty($value['wr_1']));
            var_dump((int)$value['wr_2']);
            var_dump(!empty($value['wr_2']));
            var_dump(empty($value['wr_10']));
        }
        else if((int)$value['wr_2'] == 0 && (int)$value['wr_1'] > 0 && empty($value['wr_10'])){
            $updateProc->setParameter(0, 'TP3');
            echo('bb');
        }
        else if((int)$value['wr_10'] > 0){
            $updateProc->setParameter(0, 'KRW');
            echo('cc');
        }
        else if((int)$value['wr_1'] > 0 && (int)$value['wr_2'] > 0){
            $updateProc->setParameter(0, 'TP3MC');
            echo('dd');
        }
        else{
            $updateProc->setParameter(0, 'none');
            echo('ff');
        }
        $updateProc->setParameter(1, $value['wr_id'])
        ->execute();

}

?>