<?php
include_once('./_common.php');
$params = array_merge($_GET, $_POST);
switch ($params['scope']) {
    default:
        {
            fn_ajax_output(['code' => 403, 'message' => 'Invalid access, does not contain scope.']);
            break;
        }
    case 'search':
        {
            $params = $_POST;
            empty($params['value']) === true && fn_ajax_output(['code' => 400, 'message' => 'The value required.']);
            $params['page'] < 1 && ($params['page'] = 1);

            $keyword = fn_sql_quote($params['value'] . '%');
            $where = "al_district LIKE {$keyword} AND al_status = 'active'";

            $sql = "SELECT count(0) FROM {$g5['tb_agent_list']} WHERE {$where}";
            $totals = fn_sql_row($sql);

            [$limit, $pages] = fn_sql_build_limit($params['page'], $totals);

            $sql = "SELECT al_idx, al_label FROM {$g5['tb_agent_list']} WHERE {$where} {$limit}";
            ($rows = fn_sql_fetch_all($sql)) === false && fn_ajax_output(['code' => 500, 'message' => 'An error has occurred with database.']);

            $result = [
                'code' => 200,
                'page' => $params['page'],
                'pages' => $pages,
                'totals' => (int)$totals,
                'item' => null
            ];

            foreach ($rows as $row) {
                $result['item'][] = ['id' => $row['al_idx'], 'title' => $row['al_label']];
            }
            fn_ajax_output($result);
            break;
        }
}
