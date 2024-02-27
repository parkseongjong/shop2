<?php
//수동 class 용 입ㅇ니다.
use \Webmozart\Assert\Assert;
use \ezyang\htmlpurifier;
use \barry\common\Util as barryUtil;
use \barry\common\Token as barryToken;
use \barry\banner\Slide as barrySlide;
use \barry\db\DriverApi as barryDb;
use \barry\encrypt\RsaApi as barryRsa;

require __DIR__ .'/vendor/autoload.php';

$config = \HTMLPurifier_Config::createDefault();
$purifier = new \HTMLPurifier($config);
$util = barryUtil::singletonMethod();
$token = barryToken::singletonMethod();
$db = barryDb::singletonMethod();
$barrydb = $db-> init();
//$barryRsa = new barryRsa;
//$barrySlide = new barrySlide(false,false,false);
/*
 * array(3) { ["signature"]=> string(64) "dc12895061f52dd4c9861478ec2f455b97386ffe77b62df073445d3ab7d72503" ["timestamp"]=> int(1622625825) ["value"]=> int(123) }
 *
 */
//var_dump($util->serverCommunicationBuild('walletadmin',123));
//var_dump($util->serverCommunicationAuth('walletadmin',123,1622626689,'47dee86940ff2f66a3ebcb5440f85c3169160a7cb787cf6d64bea3f3f847638e'));
$temp = [
      'signature' => 'dc12895061f52dd4c9861478ec2f455b97386ffe77b62df073445d3ab7d72503',
      'timestamp' => 1622625825,
      'value' => '123',
];
//$curlReturn = $util -> getCurlApi('http://local_wallet/apis/barry/personalInformation.php',$util->serverCommunicationBuild('walletadmin','11863'));
$curlReturn = $util -> getCurlApi('http://local_wallet/apis/barry/personalInformation.php',$temp);
var_dump($curlReturn);
?>