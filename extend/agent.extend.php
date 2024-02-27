<?php
/**
 *
 * User: Lee, Namdu
 * Date: 2022-06-02
 * Time: 오전 10:44
 */
//
defined('_GNUBOARD_') or exit; // 개별 페이지 접근 불가;
/**
 * JSON 형태로 저장된 지역정보 파일을 읽어와 되돌림
 * @param bool $assoc 리턴값을 배열로 처리할 지 여부
 * @return bool|string
 */
function getDistrictStringify($assoc = false)
{
    static $_stringify;
    empty($_stringify) === true && ($_stringify = file_get_contents(__DIR__ . '/district.config.json'));
    return $assoc !== false ? json_decode($_stringify, true) : $_stringify;
}

// ------------------------------------------------------------------------------

/**
 * @param null $code
 * @return array|mixed
 */
function getDistrictState($code = null)
{
    $state = [
        "11" => "서울특별시",
        "21" => "부산광역시",
        "22" => "대구광역시",
        "23" => "인천광역시",
        "24" => "광주광역시",
        "25" => "대전광역시",
        "26" => "울산광역시",
        "29" => "세종특별자치시",
        "31" => "경기도",
        "32" => "강원도",
        "33" => "충청북도",
        "34" => "충청남도",
        "35" => "전라북도",
        "36" => "전라남도",
        "37" => "경상북도",
        "38" => "경상남도",
        "39" => "제주특별자치도"
    ];
    return is_null($code) ? $state : $state[$code];
}

// ------------------------------------------------------------------------------

/**
 * @param null $code
 * @return array|mixed
 */
function getDistrictStateAbbr($code)
{
    $state = [
        "11" => "서울",
        "21" => "부산",
        "22" => "대구",
        "23" => "인천",
        "24" => "광주",
        "25" => "대전",
        "26" => "울산",
        "29" => "세종",
        "31" => "경기",
        "32" => "강원",
        "33" => "충북",
        "34" => "충남",
        "35" => "전북",
        "36" => "전남",
        "37" => "경북",
        "38" => "경남",
        "39" => "제주"
    ];
    return is_null($code) ? $state : $state[$code];
}


// ------------------------------------------------------------------------------

function getAgentToArray($state = null) {

    global $g5;
    static $_entries;

    if(isset($_entries) !== true) {
        $rows = fn_sql_fetch_all("SELECT ag_code, ag_name FROM {$g5['tb_agents']} WHERE ag_status='active'");
        foreach($rows as $row ){
            $state_code = substr($row['ag_code'], 0, 2);
            $_entries[$state_code][$row['ag_code']] = $row['ag_name'];
        };
    }
    return $state ? $_entries[$state] : $_entries;
}


// ------------------------------------------------------------------------------

/**
 * 지역 코드를 시/도, 구/군, 읍/면/동 의 각각의 법정코드로 배열화함.
 * @param $code 2 + 3 + 2(7자리 구성)
 * @return array
 */
function getDistrictNameByCode($code)
{
    $length = strlen($code);
    if (empty($code) === true || $length < 2) return [];
    $state = substr($code, 0, 2);
    $depth = [getDistrictState($state), getAgentToArray($state)[$code]];
    return $depth;
}

// ------------------------------------------------------------------------------

/**
 * 대리점 정보 - PK값으로 가져옴
 * @param $code
 * @return array|null
 */
function getAgentByCode($code)
{
    global $g5;

    $sql = "SELECT * FROM {$g5['tb_agents']} WHERE ag_code=" . fn_sql_quote($code) . ' LIMIT 1';
    $row = sql_fetch($sql);
    return $row;
}

// ------------------------------------------------------------------------------

/**
 * 대리점 정보 - PK값으로 가져옴
 * @param $idx
 * @return array|null
 */
function getAgentByPk($idx)
{
    global $g5;

    $sql = "SELECT * FROM {$g5['tb_agents']} WHERE ag_id=" . fn_sql_quote($idx) . ' LIMIT 1';
    $row = sql_fetch($sql);
    return $row;
}

// ------------------------------------------------------------------------------

/**
 * 대리점 포인트 지급/차감
 * @param string $agent_code 대상 대리점 테이블 PK
 * @param int $point 지급/차감 포인트. 차감시 Minus(-) 기호
 * @param int $src_id 지급/차감 원인 테이블 PK
 * @param string $note 메모
 * @param string $src_type 지급/차감 원인
 * @param string|null $dateTime 지급 날짜
 * @return bool|int         True: 중복, False: DB 오류, Int: DB 등록
 */
function addAgentPoint($agent_code, $point, $src_id, $note = '', $src_type = 'ORDER', $dateTime = null)
{
    global $g5;

    $point = (int)$point;

    $_agent_code = fn_sql_quote($agent_code);
    $_src_type = fn_sql_quote($src_type);
    $_src_id = fn_sql_quote($src_id);
    $_note = fn_sql_quote($note);
    $_date_time = $dateTime ? fn_sql_quote($dateTime) : 'NOW()';

    //$sql = "SELECT ap_point FROM {$g5['tb_agent_point']} WHERE ap_src_type={$_src_type} AND ap_src_id={$_src_id} AND ap_agent={$_agent_code}";
    // 이미 지급됨
    if ($point == existAgentPointHistory($agent_code, $src_id, $src_type)) {
        return true;
    }

    $sql = "
        INSERT INTO
            {$g5['tb_agent_point']}
        SET 
            ap_agent = {$_agent_code}
            , ap_src_type = {$_src_type}
            , ap_src_id = {$_src_id}
            , ap_point = {$point}
            , ap_note = {$_note}
            , ap_created_at = {$_date_time}

    ";
    // DB 오류
    if (!sql_query($sql)) {
        return false;
    }

    // 누적 합계 처리
    $sql = "UPDATE {$g5['tb_agents']} SET ag_accrue = ag_accrue + '{$point}' WHERE ag_code = ".$_agent_code;
    sql_query($sql);

    return sql_insert_id();
}

// ------------------------------------------------------------------------------

function existAgentPointHistory($agent_code, $src_id, $src_type = 'ORDER')
{
    global $g5;

    $_agent_code = fn_sql_quote($agent_code);
    $_src_type = fn_sql_quote($src_type);
    $_src_id = fn_sql_quote($src_id);


    $sql = "SELECT ap_point FROM {$g5['tb_agent_point']} WHERE ap_src_type={$_src_type} AND ap_src_id={$_src_id} AND ap_agent={$_agent_code}";
    return fn_sql_row($sql);
}