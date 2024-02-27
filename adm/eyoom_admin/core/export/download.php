<?php
ini_set('memory_limit','-1');
ini_set('output_buffering', 'Off');
ini_set('zlib.output_compression', 'Off');

session_write_close();

$param = array_merge($_GET, $_POST);
array_walk($param, function (&$value, &$key) {
    $value = clean_xss_tags($value);
});

$export_file = G5_DATA_PATH . "/export/{$param['id']}";

empty($param['id']) === true && alert('Missing file id.');
file_exists($export_file) !== true && alert('File not found.');

// Clean output buffer
ob_implicit_flush(true);
ob_get_level() !== 0 && @ob_end_clean() === false && ob_clean();


[$prefix, $mtime] = explode('.', $param['id']);
$subtitle = ['orderlist'=>'주문목록', 'memberlist'=>'회원목록', 'agents'=>'대리점포인트목록'][$prefix].'-'.date('Ymd.Hi').'.xls';

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"{$subtitle}\"");
header("Cache-Control: max-age=0");
readfile($export_file);
@unlink($export_file);