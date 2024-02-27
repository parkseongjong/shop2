<?php
/**
 * page file : /theme/THEME_NAME/page/manual.html.php
 */
if (!defined('_EYOOM_')) exit;
add_stylesheet('<link rel="stylesheet" href="'.EYOOM_THEME_URL.'/plugins/magnific-popup/magnific-popup.min.css" type="text/css" media="screen">',0);
?>
<style>
.theme-manual > .row {margin:0}
.theme-manual p, .theme-manual li {color:#333}
/* 타이틀 */
.theme-manual h3 {position:relative;font-size:20px;line-height:26px;font-weight:bold;border-bottom:1px solid #656565;padding:0 0 10px 15px;margin:0 0 10px}
.theme-manual h3 .title-bar {position:absolute;top:0;left:0;display:inline-block;width:5px;height:26px;background:#6284F3}
/* 탭 네비 */
.theme-manual .tab-std .tab-nav-left {border-right:0 none;padding:0}
.theme-manual .nav li a {background:#eee}
.theme-manual .nav li.active a {font-weight:700;color:#fff;background:#ababab}
/* 탭 콘텐츠 */
.theme-manual .tab-std .tab-content-right {padding:0;border:2px solid #ababab}
.theme-manual .tab-std .tab-content {padding:15px}
/* 테마 다운로드 */
/* 테마 설치 */
.install-step {margin-bottom:30px}
.install-step {padding:15px;background:#f8f8f8;box-shadow:0 0 1px rgba(0,0,0,0.35)}
.install-step h5 {line-height:45px;margin:0 0 10px;font-size:16px;position:relative}
.install-step h5 small {display:inline-block;height:45px;padding:7px 9px;margin-right:10px;background:#314b52;color:#fff;font-size:11px;text-align:center;text-transform:uppercase;vertical-align:middle}
.install-step h5 small span {font-size:18px;display:block;margin-top:2px}
.install-step p {line-height:24px;color:#707070;margin:10px 0 0;padding-left:30px;position:relative;word-break:keep-all}
.install-step p span {display:inline-block;position:absolute;left:0;top:0;width:24px;height:24px;line-height:24px;text-align:center;margin-right:5px;color:#fff;background:#FA3008;border-radius:100% !important}
.full-img {box-shadow:0 0 1px rgba(0,0,0,0.8);max-width:600px;margin:0 auto}
@media (min-width:1200px){
    .theme-step-1 , .theme-step-2 {height:520px}
    .theme-step-3 , .theme-step-4 {height:350px}
    .theme-step-5 , .theme-step-6 {height:690px}
}
/* 테마 설명과 설정 */
.theme-setup ul li {position:relative;margin-bottom:10px;padding-left:20px}
.theme-setup ul li i {position:absolute;left:0;top:3px;color:#ccc}
.theme-setup ul li ul li {margin:5px 0 0;padding:0}
/* 테마 편집모드 */
.theme-editmode h5 {margin:0 0 10px;font-weight:700;font-size:14px}
.theme-editmode .theme-list > li {position:relative;margin-bottom:20px}
.theme-editmode .theme-list .img-responsive {padding:10px;margin-bottom:10px;border:1px solid #ddd}
/* 테마 패치내역 */
.patch-list h5 {margin:0 0 10px;padding:5px 10px;font-size:14px;border-left:2px solid #999;background:#eee;color:#c0392b}
.patch-list li {position:relative;padding-left:10px}
.patch-list li span {position:absolute;left:0;top:0}
@media (max-width:991px){
    .theme-manual .tab-std .tab-nav-left {padding:0 !important;margin-bottom:10px}
}
</style>
<div class="theme-manual">
    <div class="row tab-std tab-std-default">
        <div class="col-md-2 tab-nav-left">
            <?php /* 탭 네비 */ ?>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#tab-bg-default-1" data-toggle="tab">테마 다운로드</a></li>
                <li><a href="#tab-bg-default-2" data-toggle="tab">테마 설치</a></li>
                <li><a href="#tab-bg-default-3" data-toggle="tab">테마 설명과 설정</a></li>
                <li><a href="#tab-bg-default-4" data-toggle="tab">테마 메인과 편집모드</a></li>
                <li><a href="#tab-bg-default-5" data-toggle="tab">테마 패치내역</a></li>
            </ul>
        </div>

        <?php /* 탭 콘텐츠 */ ?>
        <div class="col-md-10 tab-content-right">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab-bg-default-1">
                    <?php /* 테마 다운로드 */ ?>
                    <div class="theme-download">
                        <h3><span class="title-bar"></span> 테마 다운로드와 테마 키 확인(이윰넷에서 구매한 경우)</h3>
                        <p class="margin-bottom-30">이윰넷에서 <strong>유료 테마</strong>를 스킨상점에서 구매하며 구매가 완료됐다면 <strong>마이페이지 &gt; 다운로드 관리 &gt; <span class="color-red">테마관리</span></strong>에서 테마키 확인 및 다운로드가 가능합니다.</p>
                        <div class="margin-bottom-50">
                            <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_manage.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_manage.jpg" alt="image" class="img-responsive"></a>
                        </div>

                        <h3><span class="title-bar"></span> 테마 다운로드와 주문번호 확인(sir.kr 콘텐츠몰에서 구매한 경우)</h3>
                        <p class="margin-bottom-30">sir.kr 콘텐츠몰에서 구매를 한 경우 sir.kr에서 테마 다운로드를 받을 수 있으며 주문번호를 확인합니다.<br>주문번호는 테마 설치시 입력 사항 입니다.</p>
                    </div>
                </div>
                <div class="tab-pane fade in" id="tab-bg-default-2">
                    <?php /* 테마 설치 */ ?>
                    <div class="theme-install">
                        <div class="install-box">
                            <div class="sub-page-title" id="install_theme">
                                <h3><span class="title-bar"></span> 유료 테마 설치</h3>
                                <p class="margin-bottom-30">영카트5 + 빌더 + 베이직테마가 설치된 상태에서 구매한 <strong class="color-orange">유료 테마 설치</strong> 과정입니다.</p>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="install-step theme-step-1">
                                        <h5><small>step <span>01</span></small> 다운로드 파일 확인 및 압축 풀기</h5>
                                        <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img01.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img01.jpg" alt="image" class="img-responsive"></a>
                                        <p><span>1</span> 압축 프로그램을 통해 해당 파일 압축을 풉니다.</p>
                                        <p><span class="bg-yellow"><i class="fa fa-exclamation"></i></span> <strong class="color-red font-size-20">[ 중요! ]</strong></p>
                                        <p><i><strong class="color-black font-size-14">'<strong class="color-red">알집</strong>'으로 압축해제시 파일이 정상적으로 해제가 안될 수 있으며, 정상설치가 되지 않아 에러가 발생합니다.<br>반드시 '<strong class="color-red">7-zip, 반디집</strong>' 등을 사용해 압축 해제하시기 바랍니다.</strong></i></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="install-step theme-step-2">
                                        <h5><small>step <span>02</span></small> 폴더와 파일 리스트</h5>
                                        <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img02.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img02.jpg" alt="image" class="img-responsive"></a>
                                        <p><span style="background:#FF4549"><i class="fa fa-info"></i></span> 디자인된 테마와 데모 사이트 콘텐츠 설정등의 파일 목록 입니다.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="install-step theme-step-3">
                                        <h5><small>step <span>03</span></small> ftp 프로그램을 통해 테마 업로드</h5>
                                        <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img03.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img03.jpg" alt="image" class="img-responsive"></a>
                                        <p><span>1</span> ftp 프로그램(파일질라, 알ftp등)을 통해 서버로 파일 업로드 합니다.</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="install-step theme-step-4">
                                        <h5><small>step <span>04</span></small> 테마설치하기</h5>
                                        <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img04.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img04.jpg" alt="image" class="img-responsive"></a>
                                        <p><span>1</span> 사이트 '<strong>관리자 모드 &gt; 테마설정관리 &gt; 테마관리</strong>' 로 이동해 업로드한 테마의 '<strong class="color-red">테마설치하기</strong>' 버튼을 클릭합니다.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="install-step theme-step-5">
                                        <h5><small>step <span>05</span></small> 테마키 또는 상품주문번호 입력하기</h5>
                                        <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img05.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img05.jpg" alt="image" class="img-responsive"></a>
                                        <p><span>1</span> 이윰 라이선스를 확인 후 동의 체크합니다.</p>
                                        <p><span>2</span> 구매한 테마키 또는 상품주문번호를 입력 후 '설치하기'를 클릭합니다.<br>(<strong class="color-red">이윰넷</strong>에서 구매한 경우 <strong class="color-red">테마키</strong>를 <strong class="color-blue">sir.kr 콘텐츠몰</strong>에서 구매한 경우 <strong class="color-blue">상품주문번호</strong>를 입력)</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="install-step theme-step-6">
                                        <h5><small>step <span>06</span></small> tmp폴더 삭제</h5>
                                        <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img06.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img06.jpg" alt="image" class="img-responsive"></a>
                                        <p><span>1</span> 테마설치 완료후 업로드한 <strong class="color-red">tmp폴더</strong>를 삭제합니다.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="install-step theme-step-7">
                                        <h5><small>step <span>07</span></small> 최초 메인 페이지</h5>
                                        <a class="image-popup-vertical-fit" href="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img07.jpg"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/install_theme_img07.jpg" alt="image" class="img-responsive"></a>

                                        <p><span>1</span> 설치된 테마를 <strong>홈페이지테마적용</strong>을 하면 해당 테마가 출력되며 우측 <strong>미리보기</strong>를 클릭하면 해당 테마를 미리 볼 수 있습니다.</p>
                                        <p><span>2</span> 관리자 로그인 후 <strong class="color-red">편집모드</strong>를 활성화 시키면 화면상에서 로고, 메뉴, EB슬라이더, EB콘텐츠, EB최신글 등의 설정을 불러와 설정할 수 있습니다.</p>
                                        <p><span><i class="fa fa-info"></i></span> <strong>[중요]</strong> 최초 설치 후 관리자로 로그인해 <strong class="color-red">관리자 모드 &lt; 환경설정 &lt; 기본환경설정</strong>에 접속해 <strong class="color-red">확인</strong>을 한번 클릭하기 바랍니다.<br>(모바일 관련 함수 설정을 위함이며 그래야 모바일에서 정상적인 레이아웃 출력됩니다.)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="tab-bg-default-3">
                    <?php /* 테마 설명과 설정 */ ?>
                    <div class="theme-setup">
                        <h3><span class="title-bar"></span> 테마 설명</h3>
                        <ul class="list-unstyled margin-bottom-30">
                            <li><i class="fas fa-minus"></i> 쇼핑몰 테마이며 쇼핑몰 레이아웃과 커뮤니티 레이아웃과 스타일은 동일합니다.<br>출력 파일은 서로 다르며 <a href="https://eyoom.net/page/?pid=eb4_theme_skin" target="_blank" class="color-red">테마구조</a>를 참고하기 바랍니다.</li>
                            <li><i class="fas fa-minus"></i> <span class="color-red">설치시 상품 등록은 지원하지 않기에 데모사이트와 같이 상품 출력 된 레이아웃은 출력되지 않습니다.</span>(직접 관리자모드에서 상품 입력 해야합니다.)</li>
                            <li><i class="fas fa-minus"></i> 쇼핑몰 설정 및 상품등록등과 관련해서는 sir.kr의 <strong class="color-red">영카트5 매뉴얼</strong>(<a href="https://sir.kr/manual/yc5" target="_blank">https://sir.kr/manual/yc5</a>)를 참고하기 바랍니다.</li>
                            <li><i class="fas fa-minus"></i> <span class="color-red">상품 등록시 이미지 비율을 동일하게 맞추기 바랍니다.</span> 예)1000x1000픽셀 이미지 파일</li>
                            <li><i class="fas fa-minus"></i> 상품 목록에서 두번째 이미지가 있으면 마우스오버시 이미지 출력됩니다.(이윰빌더 4.3.3 적용 예정)</li>
                            <li><i class="fas fa-minus"></i> 메인에서 편집모드를 통해 내용 및 이미지 수정이 가능하며 상품 등록 후에도 개별상품 설정이 가능합니다.</li>
                            <li><i class="fas fa-minus"></i> 쇼핑몰 메인에 <strong>유형별 출력(히트, 추천...)</strong>외에 <strong>분류별 출력</strong>을 할 수 있는 <strong class="color-red"><a href="https://eyoom.net/eb4_theme_guide/36" target="_blank"></a> EB 상품</strong> 스킨을 제공합니다.</li>
                            <li><i class="fas fa-minus"></i> 관리자 - 테마설정관리 - 테마환경설정에서 기본설정의 테마유형을 반응형 / 비반응형, 와이드형 / 박스형, 메뉴 고정 유무등 설정 가능합니다.</li>
                            <li><i class="fas fa-minus"></i> 커뮤니티에서는 <strong>이벤트</strong>와 <strong>최근본 상품 스킨</strong>등은 지원되지 않습니다.</li>
                            <li><i class="fas fa-minus"></i> 헤더와 푸터에 사용되는 CSS 스타일 파일은 /theme/eb4_shop_015/css/shop-style.css 파일에 위치합니다.<br>테마 구조 참고 : <a href="https://eyoom.net/page/eb4_theme_skin" traget="_blank">https://eyoom.net/page/eb4_theme_skin</a></li>
                            <li><i class="fas fa-minus"></i> 메인 컬러 코드들은 /theme/eb4_shop_015/css/shop-style.css(style.css) 상단 color 부분에 있으며 해당 컬러 코드 값을 수정하면 각 코드 값들이 일괄적으로 변경 됩니다.<br>
                            예) --color-primary: <span class="color-red">#f9a825</span> 에서 색상 값을 변경하면 background-color: <span class="color-blue">var(--color-primary)</span> 에 색상이 변경</li>
                            <li><i class="fas fa-minus"></i> 해당 테마는 구글 웹폰트 중 Noto Sans KR폰트를 사용했으며 사용을 원치 않을 시 아래의 소스 삭제합니다.
                                <div class="inner-content">
                                    /theme/eb4_shop_015/shop/head.html.php, /theme/eb4_shop_015/head.html.php 파일 상단 구글폰트 링크 삭제<br>
                                    /theme/eb4_shop_015/skin/shop/basic/css/shop-style.css, /theme/eb4_shop_015/css/style.css 파일 다음 소스 삭제<br>
                                    body, h1, h2, h3, h4, h5, h6 {font-family:'Noto Sans KR',sans-serif;}
                                </div>
                            </li>
                        </ul>
                        
                        <h3><span class="title-bar"></span> 테마 설정</h3>
                        <ul class="list-unstyled margin-bottom-30">
                            <li><i class="fas fa-minus"></i> 관리자 - 쇼핑몰관리 - 분류관리
                            	<ul class="list-unstyled">
                            		<li>&middot; 출력이미지 사이즈 : 폭(600) / 높이(0)으로 설정(반응형이기에 높이는 0)</li>
                            		<li>&middot; 상품 출력 수는 가로 수와 세로 수의 곱으로 출력되며 정렬은 해당 스킨 파일에서 수정합니다.</li>
                            	</ul>
                            </li>
                            <li><i class="fas fa-minus"></i> 관리자 - 쇼핑몰관리 - 쇼핑몰 초기화면
                            	<ul class="list-unstyled">
                            		<li>&middot; 히트 : 스킨(main.10.skin.php) / 1줄당 이미지 수(8) / 출력할 줄 수(1) / 이미지폭(400) / 이미지높이(0)</li>
                            		<li>&middot; 추천 : 스킨(main.10.skin.php) / 1줄당 이미지 수(8) / 출력할 줄 수(1) / 이미지폭(400) / 이미지높이(0)</li>
                            		<li>&middot; 최신 : 스킨(main.10.skin.php) / 1줄당 이미지 수(8) / 출력할 줄 수(1) / 이미지폭(400) / 이미지높이(0)</li>
                            		<li>&middot; 인기 : 스킨(main.30.skin.php) / 1줄당 이미지 수(10) / 출력할 줄 수(1) / 이미지폭(400) / 이미지높이(0)</li>
                            		<li>&middot; 할인 : 스킨(main.50.skin.php) / 1줄당 이미지 수(8) / 출력할 줄 수(1) / 이미지폭(400) / 이미지높이(0)</li>
                            		<li>&middot; 상품 출력 수는 1줄당 이미지 수와 출력할 줄 수의 곱으로 출력되며 목록 정렬은 해당 스킨 파일에서 수정합니다.</li>
                            	</ul>
                            </li>
                            <li><i class="fas fa-minus"></i> 관리자 - 쇼핑몰관리 - 기타설정
                            	<ul class="list-unstyled">
                            		<li>&middot; 이미지폭(400) / 이미지높이(0)</li>
                            		<li>&middot; 상품 출력 수는 1줄당 이미지 수와 출력할 줄 수의 곱으로 출력되며 정렬은 해당 스킨 파일에서 수정합니다.</li>
                            		<li>&middot; 이미지(소) : 폭(400) / 높이(0)</li>
                            		<li>&middot; 이미지(중) : 폭(1000) / 높이(0)</li>
                            	</ul>
                            </li>
                        </ul>
                        
                        <h3><span class="title-bar"></span> 테마 그리드 시스템</h3>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-minus"></i> 해당 테마는 flex-box를 이용한 그리드 시스템이 적용됐습니다.</li>
                            <li><i class="fas fa-minus"></i> 부트스트랩의 그리드 시스템(<a href="https://eyoom.net/page/eb4_code_1" target="_blank">바로가기</a>) 표현을 응용했습니다.<br>예와 같이 기존 클래스에 <strong>f-</strong>만 추가했습니다.
                            	<ul class="list-unstyled">
                            		<li>&middot; 부트스트랩의 그리드 옵션 예 : .row / .col-6 / .col-sm-4 / .col-md-3 / .col-lg-2 </li>
                            		<li>&middot; 테마 그리드 옵션 예 : .f-row / .f-col-6 / .f-col-sm-4 / .f-col-md-3 / .f-col-lg-2</li>
                            		<li>&middot; 변경 예 : 디바이스 폭 992px 이상에서 4행이 출력되는 것을 3행으로 변경한다면 .f-md-<strong>3</strong> 을 .f-md-<strong>4</strong>로 변경</li>
                            	</ul>
                            </li>
                            <li><i class="fas fa-minus"></i> 디바이스 폭 576, 768, 992, 1200, 1400px 에 따라 변경이 됩니다.</li>
                            <li><i class="fas fa-minus"></i> 레이아웃 그리드는 /theme/eb4_shop_015/css/grid.css 파일에 위치합니다.</li>
                        </ul>
                        
                    </div>
                </div>
                <div class="tab-pane fade in" id="tab-bg-default-4">
                    <?php /* 테마 편집모드 */ ?>
                    <div class="theme-editmode">
                        <h3><span class="title-bar"></span> 테마 메인과 편집모드</h3>
                        <p class="margin-bottom-30">편집 모드를 통해 로고, 메뉴, 회사정보 입력은 물론 사이트 콘텐츠의 이미지와 텍스트를 보여지는 화면에서 바로 수정이 가능합니다.
                            <br><strong class="color-red">편집모드란?</strong> <a href="https://eyoom.net/page/?pid=eb4_editmode" target="_blank"><i class="fas fa-link"></i> 관련링크 바로가기</a>
                        </p>

                        <ul class="list-unstyled theme-list">
                            <li>
                                <h5>메인 페이지 로더</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_00.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 메인페이지 로딩 시간 동안 출력되는 화면입니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/shop/index.html.php 파일 '페이지 로더' 부분에 각 소스가 있으며 시간 조정 및 스타일 수정을 합니다.</li>
                                    <li>&middot; 이미지는 /theme/eb4_shop_015/image/site_logo.png 파일이 출력되며 관리자 로고 등록시 해당 이미지가 출력 됩니다.</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Header(상단 레이아웃)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_01.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 로고, 메뉴, 로그인, 검색등 출력되며 로고와 메뉴는 편집모드 등을 통해 설정할 수 있습니다.</li>
                                    <li>&middot; top bar : 로그인, 검색, 버튼등은 직접 파일에서 수정합니다.</li>
                                    <li>&middot; 좌측 상단 링크는 커뮤니티 : G5_URL / 쇼핑몰 : G5_SHOP_URL 입니다.</li>
                                    <li>&middot; 쇼핑몰과 커뮤니티의 마이페이지 링크는 서로 다릅니다.</li>
                                    <li>&middot; 쇼핑몰 검색은 상품을 커뮤니티 검색은 게시글을 검색하며 서로 소스는 다릅니다.</li>
                                    <li>&middot; 로고는 편집모드 또는 '관리자 - 테마설정관리 - 기본정보'에서 등록하며 미등록시 /theme/eb4_shop_015/image/site_logo.png 파일이 출력됩니다.<br>&nbsp; 사용된 이미지 사이즈 512x100 픽셀</li>
                                    <li>&middot; 메뉴는 편집모드 또는 '관리자 - 테마설정관리 - 쇼핑몰(홈페이지)메뉴설정'에서 등록합니다.</li>
                                    <li>&middot; 고정 메뉴는 992px 기준 pc는 우측 모바일은 하단에 출력됩니다.</li>
                                    <li>&middot; 고정메뉴 검색은 모달검색으로 출력됩니다.</li>
                                    <li>&middot; 최근본 상품 출력소스가 있으며 스킨 파일은 /theme/eb4_shop_015/skin/shop/basic/boxtodayview.skin.html.php 입니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/shop/shop.head.html.php 파일에서 수정합니다.</li>
                                </ul>
                                <h6>Top slider(EB슬라이더)</h6>
                                <ul class="list-unstyled">
                                    <li>&middot; 대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1 업로드 합니다.</li>
                                    <li>&middot; 웹접근성을 위해 대표타이틀은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; 이미지 비율 1920x100 픽셀 이미지 사용 등록합니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebslider/shop015_top_slider/ebslider.skin.html.php</li>
                                </ul>
                                <h6>Header slider(EB슬라이더)</h6>
                                <ul class="list-unstyled">
                                    <li>&middot; 헤더 슬라이더(EB슬라이더)는 992px 이상에서만 출력됩니다.</li>
                                    <li>&middot; 대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1 업로드 합니다.</li>
                                    <li>&middot; 웹접근성을 위해 대표타이틀은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; 이미지 비율 620x300 픽셀 이미지 등록합니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebslider/shop015_header_slider/ebslider.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Main slider(EB슬라이더)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_02.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1~2 업로드 합니다.</li>
                                    <li>&middot; 웹접근성을 위해 대표타이틀은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; 이미지 비율 pc:1920x500 / 모바일:800x800 픽셀 이미지 등록합니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebslider/shop015_main_slider/ebslider.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Four Banner(EB콘텐츠)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_03.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 텍스트 필드 #1, 연결주소, 이미지등을 입력 또는 업로드 합니다.</li>
                                    <li>&middot; 이미지 비율 550x300 픽셀 이미지 등록합니다.</li>
                                    <li>&middot; EB컨텐츠 아이템 4개에 맞춰 디자인 되었습니다.</li>
                                    <li>&middot; 웹접근성을 위해 텍스트 필드 #1은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebcontents/shop015_four_banner/ebcontents.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>히트/추천/신상품</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_04.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 탭형식으로 히트, 추천, 신상품이 출력됩니다.</li>
                                    <li>&middot; 출력 스킨 : main.10.skin.php</li>
                                    <li>&middot; 관리자 - 쇼핑몰설정 - 쇼핑몰 초기화면에서 상품 출력수(1줄당 이미지 수 x 출력할 줄 수)와 이미지 사이즈 설정합니다.</li>
                                    <li>&middot; 탭레이아웃과 타이틀, 상품유형 변경은 /theme/eb4_shop_015/shop/index.html.php 파일에서 수정합니다.</li>
                                    <li>&middot; 상품유형 타입 : 히트(1), 추천(2), 신상(3), 인기(4), 할인(5)</li>
                                    <li>&middot; 상품 출력 열은 해당 파일에서 수정합니다.(테마설명과 설정 - 그리드 시스템 참고)</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/shop/basic/main.10.skin.html.php</li>
                                    <li>&middot; <span class="color-red">참고</span> main.20.skin.php 스킨은 슬라이더 형식이며 해당 파일 하단 스크립트에서 상품 출력 수(slidesToShow)와 슬라이드 시간(autoplaySpeed) 조정합니다.</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Two banner(EB콘텐츠) / One slider(EB슬라이더)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_05.jpg" class="img-responsive"></div>
                                <h6>Two banner(EB콘텐츠)</h6>
                                <ul class="list-unstyled">
                                    <li>&middot; 텍스트필드#1, 연결주소, 이미지등을 입력 또는 업로드 합니다.</li>
                                    <li>&middot; 이미지 비율 500x470픽셀 이미지 등록합니다.</li>
                                    <li>&middot; EB컨텐츠 아이템 2개에 맞춰 디자인 되었습니다.</li>
                                    <li>&middot; 웹접근성을 위해 텍스트 필드 #1은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebcontents/shop015_two_banner/ebcontents.skin.html.php</li>
                                </ul>
                                <h6>One slider(EB슬라이더)</h6>
                                <ul class="list-unstyled">
                                    <li>&middot; 대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1 업로드 합니다.</li>
                                    <li>&middot; 웹접근성을 위해 대표타이틀은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; 이미지 비율 800x753 픽셀 이미지 등록합니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebslider/shop015_one_slider/ebslider.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>EB상품</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_06.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 이윰빌더에서 제공하는 분류(카테고리) 상품 출력 스킨입니다.('관리자 - 테마설정관리 - EB상품추출관리'에서 설정)</li>
                                    <li>&middot; 아이템에 출력할 분류(카테고리)등록하며 아이템별로 탭이 추가됩니다.</li>
                                    <li>&middot; 대표 연결주소 입력시 탭 하단에 'More show' 버튼 링크 출력됩니다.</li>
                                    <li>&middot; 상품 출력 열은 해당 파일에서 수정합니다.(테마설명과 설정 - 그리드 시스템 참고)</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebgoods/shop015_goods_tabs/ebgoods.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Two slider(EB슬라이더)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_07.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1 업로드 합니다.</li>
                                    <li>&middot; 웹접근성을 위해 대표타이틀은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; 이미지 비율 644x430 픽셀 이미지 등록합니다.</li>
                                    <li>&middot; 해당 스킨파일 하단 브레이크 포인트를 통해 출력될 이미지수를 수정할 수 있습니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebslider/shop015_main_slider/ebslider.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>인기상품</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_08.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 출력 스킨 : main.30.skin.php</li>
                                    <li>&middot; 관리자 - 쇼핑몰설정 - 쇼핑몰 초기화면에서 상품 출력수(1줄당 이미지 수 x 출력할 줄 수)와 이미지 사이즈 설정합니다.</li>
                                    <li>&middot; 상품유형 타입 : 히트(1), 추천(2), 신상(3), 인기(4), 할인(5)</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/shop/basic/main.30.skin.html.php</li>
                                    <li>&middot; <span class="color-red">참고</span> main.40.skin.php 스킨은 슬라이더 형식이며 해당 파일 하단 스크립트에서 상품 출력 수(slidesToShow)와 슬라이드 시간(autoplaySpeed) 조정합니다.</li>
                                </ul>
                            </li>
                            <li>
                                <h5>이벤트</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_09.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 영카트5에서 제공하는 기본 콘텐츠 입니다. (sir  이벤트 가이드 참고 : <a href="https://sir.kr/manual/yc5/130" target="_blank">https://sir.kr/manual/yc5/130</a>)</li>
                                    <li>&middot; 관련상품 및 디자인에서 상품 등록하며 자세한 사항은 영카트5 매뉴얼 참고합니다.</li>
                                    <li>&middot; 이벤트는 2개에 맞춰 디자인 되었습니다.</li>
                                    <li>&middot; 출력이미지 폭(400) 높이(0) 설정합니다.</li>
                                    <li>&middot; 이벤트 제목 입력과 배너이미지 등록합니다.(이미지 750x400픽셀 사용)</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/shop/basic/boxevent.skin.html.php</li>
                                    <li>&middot; 이벤트 상품은 4개만 출력되며 출력 수 조정은 /eyoom/core/shop/boxevent.skin.php 파일 26줄 'limit' 에서 수를 3으로 조정합니다.</li>
                                    <li>&middot; '관리자 - 테마설정관리 - 테마환경설정 - 메인설정'에서 쇼핑몰 메인 선택시 출력되지 않습니다.<br>(이벤트는 쇼핑몰에서만 사용 가능한 기능으로 설정시 커뮤니티로 인식해 미출력됨)</li>
                                </ul>
                            </li>
                            <li>
                                <h5>할인상품</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_10.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 출력 스킨 : main.50.skin.php</li>
                                    <li>&middot; 관리자 - 쇼핑몰설정 - 쇼핑몰 초기화면에서 상품 출력수(1줄당 이미지 수 x 출력할 줄 수)와 이미지 사이즈 설정합니다.</li>
                                    <li>&middot; 상품유형 타입 : 히트(1), 추천(2), 신상(3), 인기(4), 할인(5)</li>
                                    <li>&middot; 해당 파일 하단 스크립트에서 상품 출력 수(slidesToShow)와 슬라이드 시간(autoplaySpeed) 조정합니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/shop/basic/main.50.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>One banner(EB콘텐츠)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_11.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 텍스트필드#1, 연결주소, 이미지등을 입력 또는 업로드 합니다.</li>
                                    <li>&middot; 이미지 비율 pc:1303x318 / mo:800x400 픽셀 이미지 등록합니다.</li>
                                    <li>&middot; EB컨텐츠 아이템 1개에 맞춰 디자인 되었습니다.</li>
                                    <li>&middot; 웹접근성을 위해 텍스트 필드 #1은 이미지 설명 내용을 입력하기 바랍니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/skin/ebcontents/shop015_one_banner/ebcontents.skin.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Review(사용후기)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_12.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 해당 파일에 디자인 및 출력 소스가 있습니다.</li>
                                    <li>&middot; 이미지 사이즈는 해당 부분 썸네일 출력 소스에서 설정(기본 설정 500x500).</li>
                                    <li>&middot; 아이템 출력 수는 해당 부분 스크립트 'slidesToShow'에서 값 조정.</li>
                                    <li>&middot; /theme/eb4_shop_015/shop/index.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Footer(하단 레이아웃)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_13.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 회사 정보는 편집모드를 이용해 설정합니다.</li>
                                    <li>&middot; 푸터 메뉴, 소셜링크, 무통장입금정보, 카피라이트는 직접 파일 수정합니다.</li>
                                    <li>&middot; /theme/eb4_shop_015/shop/shop.tail.html.php</li>
                                </ul>
                            </li>
                            <li>
                                <h5>Mobile(반응형웹)</h5>
                                <div class="img-box"><img src="<?php echo EYOOM_THEME_PAGE_URL; ?>/img/manual/theme_main_mo.jpg" class="img-responsive"></div>
                                <ul class="list-unstyled">
                                    <li>&middot; 모바일 출력 화면으로 화면 디바이스에 맞게 반응형으로 출력됩니다.</li>
                                    <li>&middot; 하단 버튼 메뉴는 홈(쇼핑몰)이동/최근본상품/장바구니/마이홈/관리자/로그아웃/메뉴 순서 입니다.</li>
                                    <li>&middot; 아이콘 이이미지는 /theme/eb4_shop_015/image/icons 폴더에 위치 합니다.</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade in" id="tab-bg-default-5">
                    <?php /* 테마 패치내역 */ ?>
                    <div class="theme-patch">
                        <h3><span class="title-bar"></span> 테마 패치내역</h3>
                        <p class="margin-bottom-30">테마의 <strong class="color-red">패치내역</strong>을 통해 해당 파일을 업데이트를 합니다.
                            <br>패치시 사용자가 직접 작업 및 수정한 내용에 대해서는 <strong class="color-red">백업</strong>을 한 후 진행하기 바랍니다.
                        </p>

                        <div class="patch-list">
                            <h5>버전 1.2.1 (2021.08.13)</h5>
                            <ul class="list-unstyled margin-bottom-20">
                                <li><span>&middot;</span> 테마 출시</li>
                                <li><span>&middot;</span> 두번째 상품이미지 출력은 이윰빌더 4.3.3에 패치 예정</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/magnific-popup/magnific-popup.min.js"></script>
<script>
    $(document).ready(function() {
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }
        });
        $('.title-tab a').on('click', function(e) {
            e.stopPropagation();
            var scrollTopSpace;
            if (window.innerWidth >= 992) {
                scrollTopSpace = 130;
            } else {
                scrollTopSpace = 130;
            }
            var tabLink = $(this).attr('href');
            var offset = $(tabLink).offset().top;
            $('html, body').animate({scrollTop : offset - scrollTopSpace}, 500);
            return false;
        });
    });
</script>