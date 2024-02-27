<?php

namespace barry\admin;

use \Webmozart\Assert\Assert;
use \ezyang\htmlpurifier;
use \barry\common\Util as barryUtil;
use \barry\db\DriverApi as barryDb;
use \InvalidArgumentException;
use \Exception;

class Goods{

    private $data = false;
    private $memberId = false;
    private $logger = false;

    public function __construct($postData, $logger){
        $this->data = $postData;
        $this->logger = $logger;
    }

    //cybertron admin/main 갯수 뿌려주는 메소드
    public function goodsPublishCount(){

        try{
            $config = \HTMLPurifier_Config::createDefault();
            $purifier = new \HTMLPurifier($config);
            $util = barryUtil::singletonMethod();
            $db = barryDb::singletonMethod();
            $barrydb = $db-> init();


            //정상 상품 개수
            $publishStatus = 0;
            $deleteStatus = "Y";

            $query = $tempTeble = $tempWhere = '';
            $queryDelN = $tempTebleDelN = $tempWhereDelN = '';

            $tempParams = $tempParamsDelN = array();

            $oldItemTable = array('Shop', 'market', 'estate', 'car');
            //전체 카테고리 빌드
            foreach ($oldItemTable as $key => $value) {
                //정상 상품 미승인
                if($key == 0){
                    $tempWhere = (' WHERE it_publish = ? AND del_yn = ? ');
                    array_push($tempParams,$publishStatus,$deleteStatus);
                    $query = ('SELECT * FROM g5_write_'.$value.' '.$tempWhere);

                }
                else{
                    $tempWhere = (' WHERE it_publish = ? AND del_yn = ?');
                    array_push($tempParams,$publishStatus,$deleteStatus);

                    $query .=('union all 
                                (
                                    SELECT *
                                    FROM g5_write_'.$value.' '.$tempWhere.'
                                )
                    ');
                }
            }

            //삭제된 상품의 개수
            $publishStatus = 0;
            $deleteStatus = "N";

            foreach ($oldItemTable as $key => $value) {
                //삭제 상품 미승인
                if($key == 0){
                    $tempTebleDelN = (' WHERE it_publish = ? AND del_yn = ?');
                    array_push($tempParamsDelN,$publishStatus,$deleteStatus);

                    $queryDelN = ('SELECT * FROM g5_write_'.$value.' '.$tempTebleDelN.' ');

                }
                else{
                    $tempTebleDelN = (' WHERE it_publish = ? AND del_yn = ?');
                    array_push($tempParamsDelN,$publishStatus,$deleteStatus);

                    $queryDelN .=('union all 
                                (
                                    SELECT *
                                    FROM g5_write_'.$value.' '.$tempTebleDelN.'
                                )
                    ');
                }
            }

            $tempTeble = $query;
            $tempTebleDelN = $queryDelN;

            try {
                //rows 제한 잡히기 전에 전체 rows 리턴
                $goodsInfoTotalCount = $barrydb->executeQuery($tempTeble, $tempParams)->rowCount();
                $goodsInfoTotalCountDelN = $barrydb->executeQuery($tempTebleDelN, $tempParamsDelN)->rowCount();
            }
            catch (Exception $e){
                //존재하지 않는 table을 검색 했을 때는 error 로그만 남겨준다.
                $this->logger->error('goods select error/code'.$e->getCode().'/'.'msg'.$e->getMessage());
            }
            unset($tempTeble, $tempTebleDelN, $tempParams, $tempParamsDelN, $oldItemTable);

            $returnArray = array(
                'countDelY' => $goodsInfoTotalCount,
                'countDelN' => $goodsInfoTotalCountDelN,
            );

            $this->logger->alert('미승인 상품을 정상적으로 불러왔습니다.');
            return array('code' => 200, 'data' => $returnArray);
        }
        catch (InvalidArgumentException $e){
            //유효성 체크에 실패하면 false로 보내준다.
            $this->logger->error('미승인 상품을 variable valid error');
            $this->logger->error($e->getMessage());
            return array('code'=>9999, 'msg'=>$e->getMessage());
        }
        catch (Exception $e){
            //var_dump($e->getMessage());
            return array('code'=>$e->getCode(), 'msg'=>$e->getMessage());
        }
    }

    public function getMultiItem(){
        try{
            $config = \HTMLPurifier_Config::createDefault();
            $purifier = new \HTMLPurifier($config);
            $util = barryUtil::singletonMethod();
            $db = barryDb::singletonMethod();
            $barrydb = $db-> init();

            $targetPostData = array(
                'page' => 'integer',
                'numRows' => 'integer',
                'orderKey' => 'string',
                'orderDir' => 'string',
                'searchKeyword' => 'string',
                'publishStatus' => 'stringNotEmpty',
                'deleteStatus' => 'stringNotEmpty',
                'table' => 'stringNotEmpty',
            );
            $filterData = array();
            foreach($this->data as $key => $value){
                if(array_key_exists($key,$targetPostData)){
                    if($key == 'searchKeyword' && $value === false){
                        //서치 키워드가 없을 때는 그대로 false 처리
                        $filterData['searchKeyword'] = $value;
                    }
                    else{
                        Assert::{$targetPostData[$key]}($value,'valid error: '.$key.' valid type: '.$targetPostData[$key]);
                        $filterData[$purifier->purify($key)] = $purifier->purify($value);
                    }

                }
            }
            unset($this->data,$targetPostData);// Plain data는 unset 합니다.
            $this->logger->info('필터 데이터:',$filterData);

            if($filterData['deleteStatus'] == 'Y'){
                $deleteStatus = 'Y';
            }
            else if($filterData['deleteStatus'] == 'N'){
                $deleteStatus = 'N';
            }
            else{
                $this->logger->error('getMultiItem valid fail!');
                throw new Exception('잘못 된 데이터가 유입 되었습니다.', 9999);
            }

            if($filterData['publishStatus'] == 'publish'){
                $publishStatus = 1;
            }
            else if($filterData['publishStatus'] == 'unpublish'){
                $publishStatus = 0;
            }
            else if($filterData['publishStatus'] == 'reject'){
                $publishStatus = 90;
            }
            else{
                $this->logger->error('getMultiItem valid fail!');
                throw new Exception('잘못 된 데이터가 유입 되었습니다.', 9999);
            }

            // getMultiItem 빌드
            $query = $tempTeble = $tempWhere = '';
            $tempParams = array();
            $oldItemTable = array('Shop', 'market', 'estate', 'car');
            //전체 카테고리 빌드
            if($filterData['table'] == 'all-category'){
                foreach ($oldItemTable as $key => $value) {
                    if($key == 0){
                        if (!empty($filterData['publishStatus'])) {
                            $tempWhere = (' WHERE it_publish = ?');
                            array_push($tempParams,$publishStatus);
                        }

                        if (!empty($filterData['deleteStatus'])) {
                            $tempWhere .= (' AND del_yn = ?');
                            array_push($tempParams,$deleteStatus);
                        }

                        if (!empty($filterData['searchKeyword'])) {
                            $tempWhere .= (' AND wr_subject like ?');
                            array_push($tempParams,'%'.$filterData['searchKeyword'].'%');
                        }

                        $query = ('SELECT * FROM g5_write_'.$value.' '.$tempWhere);

                    }
                    else{
                        if (!empty($filterData['publishStatus'])) {
                            $tempWhere = (' WHERE it_publish = ?');
                            array_push($tempParams,$publishStatus);
                        }

                        if (!empty($filterData['deleteStatus'])) {
                            $tempWhere .= (' AND del_yn = ?');
                            array_push($tempParams,$deleteStatus);
                        }

                        if (!empty($filterData['searchKeyword'])) {
                            $tempWhere .= (' AND wr_subject like ?');
                            array_push($tempParams,'%'.$filterData['searchKeyword'].'%');
                        }

                        $query .=('union all 
                                    (
                                        SELECT *
                                        FROM g5_write_'.$value.' '.$tempWhere.'
                                    )
                        ');
                    }
                }

                $tempTeble = $query;
                if (!empty($filterData['orderKey']) && !empty($filterData['orderDir'])) {
                    $tempTeble .= (' ORDER BY ? ?, wr_id desc');
                    array_push($tempParams,$filterData['orderKey']);
                    array_push($tempParams,$filterData['orderDir']);
                }
                else{
                    $tempTeble .= (' ORDER BY ? ?');
                    array_push($tempParams,'wr_id');
                    array_push($tempParams,'desc');
                }
//                var_dump($tempTeble);
//                var_dump($tempParams);

                try {
                    //rows 제한 잡히기 전에 전체 rows 리턴
                    $goodsInfoTotalCount = $barrydb->executeQuery($tempTeble, $tempParams)->rowCount();

                    //inline execute PDO 제한으로 , linit 절에서는 bind를 지원하지 못함.
                    $tempTeble .= (' LIMIT '.(int)($filterData['page']-1)*$filterData['numRows'].', '.(int)$filterData['numRows']);

                    $goodsInfo = $barrydb->executeQuery($tempTeble, $tempParams)->fetchAll();
                }
                catch (Exception $e){
                    //존재하지 않는 table을 검색 했을 때는 error 로그만 남겨준다.
                    $this->logger->error('goods select error/code'.$e->getCode().'/'.'msg'.$e->getMessage());
                }
                unset($temp, $tempTeble, $oldItemTable);
            }//단일 카테고리 빌드
            else{
                if(in_array($filterData['table'],$oldItemTable)){
                    //단일 테이블은 쿼리빌더로...
                    $goodsInfoQueryBuilder = $barrydb->createQueryBuilder();
                    $goodsInfoQueryBuilder
                        ->select('*')
                        ->from('g5_write_'.$filterData['table']);
                    if (!empty($filterData['publishStatus'])) {
                        $goodsInfoQueryBuilder
                            ->andWhere('it_publish = ?')
                            ->setParameter(0, $publishStatus);
                    }
                    if (!empty($filterData['deleteStatus'])) {
                        $goodsInfoQueryBuilder
                            ->andWhere('del_yn = ?')
                            ->setParameter(1, $deleteStatus);
                    }
                    if (!empty($filterData['searchKeyword'])) {
                        $goodsInfoQueryBuilder
                            ->andWhere('wr_subject like ?')
                            ->setParameter(1, '%' . $filterData['searchKeyword'] . '%');
                    }
                    if (!empty($filterData['orderKey']) && !empty($filterData['orderDir'])) {
                        $goodsInfoQueryBuilder
                            ->addOrderBy($filterData['orderKey'], $filterData['orderDir']);
                    }
                    else{
                        $goodsInfoQueryBuilder
                            ->orderBy('wr_id', 'desc');
                    }

                    //rows 제한 잡히기 전에 전체 rows 리턴
                    $goodsInfoTotalCount = $goodsInfoQueryBuilder->execute()->rowCount();

                    $goodsInfo = $goodsInfoQueryBuilder
                        ->setFirstResult(($filterData['page'] - 1) * $filterData['numRows'])
                        ->setMaxResults($filterData['numRows'])
                        ->execute()->fetchAll();

                    unset($goodsInfoQueryBuilder);

                }
                else{
                    $this->logger->error('getMultiItem select error');
                    throw new Exception('유효한 table 값이 아닙니다.', 9999);
                }
            }

            if (!$goodsInfo) {
                $this->logger->error('getMultiItem select error');
                throw new Exception('상품 정보를 불러오지 못하였습니다.', 9999);
            }

            //선택 옵션이 있는 경우에는 선택 옵션 값도 넘겨 줘야 함...
            foreach ($goodsInfo as $key => $value){
                if($value['it_option_subject']){
                    $goodsInfoOption = $barrydb->createQueryBuilder()
                        ->select('A.wr_id, A.it_me_table, B.*')
                        ->from('g5_write_'.$value['it_me_table'],'A')
                        ->innerJoin('A','g5_shop_item_option','B','A.wr_id = B.it_id')
                        ->where('A.wr_id = ?')
                        ->andWhere('B.io_me_table = ?')
                        ->setParameter(0,$value['wr_id'])
                        ->setParameter(1,$value['it_me_table'])
                        ->execute()->fetchAll();

                    $goodsInfo[$key]['optionInfo'] = $goodsInfoOption;
                }
                else{
                    $goodsInfo[$key]['optionInfo'] = false;
                }
            }
            //이미지 경로 build,
            foreach ($goodsInfo as $key => $value){
                $goodsImgInfo = $barrydb->createQueryBuilder()
                    ->select('*')
                    ->from('g5_board_file')
                    ->where('wr_id = ?')
                    ->andWhere('bo_table = ?')
                    ->setParameter(0, $value['wr_id'])
                    ->setParameter(1, $value['it_me_table'])
                    ->execute()->fetchAll();
                if(!$goodsImgInfo){
                    $goodsInfo[$key]['imgUrl'] = false;
                }
                else{
                    $tempArray = array();
                    foreach ($goodsImgInfo as $key2 => $value2){
                        array_push($tempArray, 'https://barrybarries.kr/data/file/'.$value['it_me_table'].'/'.$value2['bf_file']);
                    }
                    $goodsInfo[$key]['imgUrl'] = $tempArray;
                    unset($tempArray);
                }
            }


//            var_dump($goodsInfoTotalCount);

            //count는 전체 카운트를..
            $returnArray = array(
                'count' => $goodsInfoTotalCount,
                'list' => $goodsInfo,
            );

            $this->logger->alert('getMultiItem를 정상적으로 불러왔습니다.');
            return array('code' => 200, 'data' => $returnArray);
        }
        catch (InvalidArgumentException $e){
            //유효성 체크에 실패하면 false로 보내준다.
            $this->logger->error('admin getMultiItem를 variable valid error');
            $this->logger->error($e->getMessage());
            return array('code'=>9999, 'msg'=>$e->getMessage());
        }
        catch (Exception $e){
            //var_dump($e->getMessage());
            return array('code'=>$e->getCode(), 'msg'=>$e->getMessage());
        }
    }

    public function getSingleItem(){
        try{
            $config = \HTMLPurifier_Config::createDefault();
            $purifier = new \HTMLPurifier($config);
            $util = barryUtil::singletonMethod();
            $db = barryDb::singletonMethod();
            $barrydb = $db-> init();

            $targetPostData = array(
                'table' => 'stringNotEmpty',
                'id' => 'integer',
            );
            $filterData = array();
            foreach($this->data as $key => $value){
                if(array_key_exists($key,$targetPostData)){
                    Assert::{$targetPostData[$key]}($value,'valid error: '.$key.' valid type: '.$targetPostData[$key]);
                    $filterData[$purifier->purify($key)] = $purifier->purify($value);
                }
            }

            unset($this->data,$targetPostData);// Plain data는 unset 합니다.
            $this->logger->info('필터 데이터:',$filterData);


            // getSingleItem 빌드
            $goodsInfoQueryBuilder = $barrydb->createQueryBuilder();
            $goodsInfoQueryBuilder
                ->select('*')
                ->from('g5_write_'.$filterData['table'])
                ->where('wr_id = ?')
                ->setParameter(0,  $filterData['id'] );

            //rows 제한 잡히기 전에 전체 rows 리턴
            $goodsInfoTotalCount = $goodsInfoQueryBuilder->execute()->rowCount();

            $goodsInfo = $goodsInfoQueryBuilder
                ->execute()->fetch();

            unset($goodsInfoQueryBuilder);

            if (!$goodsInfo) {
                $this->logger->error('getSingleItem select error');
                throw new Exception('상품 정보를 불러오지 못하였습니다.', 9999);
            }

            //이미지 경로 build,
            $goodsInfoQueryBuilder = $barrydb->createQueryBuilder();
            $goodsImgInfo = $goodsInfoQueryBuilder
                ->select('*')
                ->from('g5_board_file')
                ->where('wr_id like ?')
                ->andWhere('bo_table like ?')
                ->setParameter(0,  $filterData['id'] )
                ->setParameter(1,  $filterData['table'] )
                ->execute()->fetchAll();
            if(!$goodsImgInfo){
                $goodsInfo['imgUrl'] = false;
            }
            else{
                $tempArray = array();
                foreach ($goodsImgInfo as $key => $value){
                    array_push($tempArray, 'http://barrybarries.kr/data/file/'.$filterData['table'].'/'.$value['bf_file']);
                }
                $goodsInfo['imgUrl'] = $tempArray;
                unset($tempArray);
            }

            $returnArray = array(
                'count' => $goodsInfoTotalCount,
                'list' => $goodsInfo,
            );

            $this->logger->alert('getSingleItem를 정상적으로 불러왔습니다.');
            return array('code' => 200, 'data' => $returnArray);
        }
        catch (InvalidArgumentException $e){
            //유효성 체크에 실패하면 false로 보내준다.
            $this->logger->error('admin getSingleItem variable valid error');
            $this->logger->error($e->getMessage());
            return array('code'=>9999, 'msg'=>$e->getMessage());
        }
        catch (Exception $e){
            //var_dump($e->getMessage());
            return array('code'=>$e->getCode(), 'msg'=>$e->getMessage());
        }
    }


    //승인 처리
    public function publishItem(){
        try{
            $config = \HTMLPurifier_Config::createDefault();
            $purifier = new \HTMLPurifier($config);
            $util = barryUtil::singletonMethod();
            $db = barryDb::singletonMethod();
            $barrydb = $db-> init();

            $targetPostData = array(
                'table' => 'stringNotEmpty',
                'id' => 'integer',
            );
            $filterData = array();
            foreach($this->data as $key => $value){
                if(array_key_exists($key,$targetPostData)){
                    Assert::{$targetPostData[$key]}($value,'valid error: '.$key.' valid type: '.$targetPostData[$key]);
                    $filterData[$purifier->purify($key)] = $purifier->purify($value);
                }
            }

            unset($this->data,$targetPostData);// Plain data는 unset 합니다.
            $this->logger->info('필터 데이터:',$filterData);

            // item 빌드
            $goodsInfo = $barrydb->createQueryBuilder()
                ->select('*')
                ->from('g5_write_'.$filterData['table'])
                ->where('wr_id = ?')
                ->andWhere('it_publish = 1')
                ->setParameter(0,  $filterData['id'] )
                ->execute()->fetch();
            if ($goodsInfo) {
                $this->logger->error('publishItem select error');
                throw new Exception('이미 승인 처리 되었습니다. 상품 정보를 불러오지 못하였습니다.', 9999);
            }

            $updateProc = $barrydb->createQueryBuilder()
                ->update('g5_write_'.$filterData['table'])
                ->set('it_publish', 1)
                ->set('it_publish_updatetime' , '?')
                ->where('wr_id = ?')
                ->setParameter(0,$util->getDateSql())
                ->setParameter(1,$filterData['id'])
                ->execute();
            if(!$updateProc){
                $this->logger->error('cpublishItem update proc fail');
                throw new Exception('상품 승인 작업을 실패 하였습니다.',9999);
            }
            $returnArray = array(
                'publishCode' => 200,
                'publishMsg' => '상품 승인 처리가 완료 되었습니다.',
            );
            $this->logger->alert('publishItem 완료!'.$filterData['id'].$filterData['table']);
            return array('code' => 200, 'data' => $returnArray);

        }
        catch (InvalidArgumentException $e){
            //유효성 체크에 실패하면 false로 보내준다.
            $this->logger->error('admin publishItem variable valid error');
            $this->logger->error($e->getMessage());
            return array('code'=>9999, 'msg'=>$e->getMessage());
        }
        catch (Exception $e){
            //var_dump($e->getMessage());
            return array('code'=>$e->getCode(), 'msg'=>$e->getMessage());
        }
    }

    public function unpublishItem(){
        try{
            $config = \HTMLPurifier_Config::createDefault();
            $purifier = new \HTMLPurifier($config);
            $util = barryUtil::singletonMethod();
            $db = barryDb::singletonMethod();
            $barrydb = $db-> init();

            $targetPostData = array(
                'table' => 'stringNotEmpty',
                'id' => 'integer',
            );
            $filterData = array();
            foreach($this->data as $key => $value){
                if(array_key_exists($key,$targetPostData)){
                    Assert::{$targetPostData[$key]}($value,'valid error: '.$key.' valid type: '.$targetPostData[$key]);
                    $filterData[$purifier->purify($key)] = $purifier->purify($value);
                }
            }

            unset($this->data,$targetPostData);// Plain data는 unset 합니다.
            $this->logger->info('필터 데이터:',$filterData);

            // item 빌드
            $goodsInfo = $barrydb->createQueryBuilder()
                ->select('*')
                ->from('g5_write_'.$filterData['table'])
                ->where('wr_id = ?')
                ->andWhere('it_publish = 0')
                ->setParameter(0,  $filterData['id'] )
                ->execute()->fetch();
            if ($goodsInfo) {
                $this->logger->error('unpublishItem select error');var_dump($goodsInfo);
                throw new Exception('이미 미승인 처리 되었습니다. 상품 정보를 불러오지 못하였습니다.', 9999);
            }

            $updateProc = $barrydb->createQueryBuilder()
                ->update('g5_write_'.$filterData['table'])
                ->set('it_publish', 0)
                ->set('it_publish_updatetime' , '?')
                ->where('wr_id = ?')
                ->setParameter(0,$util->getDateSql())
                ->setParameter(1,$filterData['id'])
                ->execute();
            if(!$updateProc){
                $this->logger->error('cpublishItem update proc fail');
                throw new Exception('상품 미승인 작업을 실패 하였습니다.',9999);
            }
            $returnArray = array(
                'publishCode' => 200,
                'publishMsg' => '상품 미승인 처리가 완료 되었습니다.',
            );
            $this->logger->alert('unpublishItem 완료!'.$filterData['id'].$filterData['table']);
            return array('code' => 200, 'data' => $returnArray);

        }
        catch (InvalidArgumentException $e){
            //유효성 체크에 실패하면 false로 보내준다.
            $this->logger->error('admin unpublishItem variable valid error');
            $this->logger->error($e->getMessage());
            return array('code'=>9999, 'msg'=>$e->getMessage());
        }
        catch (Exception $e){
            //var_dump($e->getMessage());
            return array('code'=>$e->getCode(), 'msg'=>$e->getMessage());
        }
    }

    public function reject(){
        try{
            $config = \HTMLPurifier_Config::createDefault();
            $purifier = new \HTMLPurifier($config);
            $util = barryUtil::singletonMethod();
            $db = barryDb::singletonMethod();
            $barrydb = $db-> init();

            $targetPostData = array(
                'table' => 'stringNotEmpty',
                'id' => 'integer',
                'type' => 'stringNotEmpty',
                'reason' => 'string',
            );
            $filterData = array();
            foreach($this->data as $key => $value){
                if(array_key_exists($key,$targetPostData)){
                    Assert::{$targetPostData[$key]}($value,'valid error: '.$key.' valid type: '.$targetPostData[$key]);
                    $filterData[$purifier->purify($key)] = $purifier->purify($value);
                }
            }
            unset($this->data,$targetPostData);// Plain data는 unset 합니다.
            $this->logger->info('필터 데이터:',$filterData);

            // item 빌드
            $goodsInfo = $barrydb->createQueryBuilder()
                ->select('*')
                ->from('g5_write_'.$filterData['table'])
                ->where('wr_id = ?')
                ->andWhere('it_publish = 90')
                ->setParameter(0,  $filterData['id'] )
                ->execute()->fetch();
            if ($goodsInfo) {
                $this->logger->error('reject select error');
                throw new Exception('이미 반려 처리 되었거나 상품 정보를 불러오지 못하였습니다.', 9999);
            }

            $updateProc = $barrydb->createQueryBuilder()
                ->update('g5_write_'.$filterData['table'])
                ->set('it_publish', 90)
                ->set('it_publish_updatetime' , '?')
                ->set('it_publish_msg' , '?')
                ->where('wr_id = ?')
                ->setParameter(0,$util->getDateSql())
                ->setParameter(1,$filterData['reason'])
                ->setParameter(2,$filterData['id'])
                ->execute();
            if(!$updateProc){
                $this->logger->error('reject update proc fail');
                throw new Exception('상품 반려 작업을 실패 하였습니다.',9999);
            }
            $returnArray = array(
                'publishCode' => 200,
                'publishMsg' => '상품 반려 처리가 완료 되었습니다.',
            );
            $this->logger->alert('reject 완료!'.$filterData['id'].$filterData['table']);
            return array('code' => 200, 'data' => $returnArray);

        }
        catch (InvalidArgumentException $e){
            //유효성 체크에 실패하면 false로 보내준다.
            $this->logger->error('admin reject variable valid error');
            $this->logger->error($e->getMessage());
            return array('code'=>9999, 'msg'=>$e->getMessage());
        }
        catch (Exception $e){
            //var_dump($e->getMessage());
            return array('code'=>$e->getCode(), 'msg'=>$e->getMessage());
        }
    }
}

?>