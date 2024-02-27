<?php
if (!defined('_EYOOM_')) exit;
require __DIR__.'/../tail.html.php';
return ;

?>

<?php if (!$wmode) { ?>
				</article>
                <?php if ($side_layout['use'] == 'yes') { ?>
	                <?php
	                if ($side_layout['pos'] == 'right') {
	                    /* 사이드영역 시작 */
	                    include_once(EYOOM_THEME_SHOP_PATH . '/shop.side.html.php');
	                    /* 사이드영역 끝 */
	                }
	                ?>
                <?php } ?>
			<?php if (!defined('_INDEX_')) { ?>
                    <div class="clearfix"></div>
                </div><?php /* End ib-row */ ?>
            </div><?php /* End container */ ?>
			<?php } ?>
        </main><?php /* End Basic Body */ ?>

		<footer class="footer">
            <div class="footer-top">
                <div class="f-container">
                    <div class="f-row">
                   <!--     <div class="f-col-lg-6">
                            <ul class="list-unstyled footer-sns">
                                <li><a href="" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>-->
                        <div class="f-col-lg-6 ord-1">
                            <ul class="list-unstyled footer-menu">
                                <li><a href="<?php echo get_eyoom_pretty_url('page','aboutus'); ?>">회사소개</a></li>
                                <li><a href="<?php echo get_eyoom_pretty_url('page','provision'); ?>">이용약관</a></li>
                                <li><a href="<?php echo get_eyoom_pretty_url('page','privacy'); ?>">개인정보처리방침</a></li>
                                <li><a href="<?php echo get_eyoom_pretty_url('page','noemail'); ?>">이메일무단수집거부</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-mid">
                <div class="f-container">
                    <div class="f-row">
                        <div class="f-col-lg-4">
                            <div class="footer-box footer-customer">
					        	<h4>고객센터</h4>
					        	<div class="footer-tel"><?php echo $bizinfo['bi_cs_tel1']; ?> <small>(<?php echo $bizinfo['bi_cs_time']; ?>)</small></div>
					        	<div class="footer-email"><a href="mailto:<?php echo $bizinfo['bi_cs_email']; ?>"><?php echo $bizinfo['bi_cs_email']; ?></a></div>
					        	<ul class="list-inline footer-cc-link">
						        	<li><a href="<?php echo G5_BBS_URL; ?>/faq.php">FAQ</a></li>
									<li><a href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1문의</a></li>
					        	</ul>
				        	</div>
                        </div>
                        <div class="f-col-lg-4">
                            <div class="footer-box footer-bank">
					        	<h4>무통장입금정보</h4>
					        	<ul class="list-unstyled">
                                    <?php

                                    preg_match_all('/([가-힣]+)[^\d]+([\d\-]+)/', $default['de_bank_account'], $matches, PREG_SET_ORDER);
                                    foreach($matches as $match){?>
						        	<li><?=$match[1]?>: <strong><?=$match[2]?></strong></li>
                                    <?php }?>
					        	</ul>
					        	<!-- h6>예금주명 : <strong>홍길동</strong></h6 -->
				        	</div>
                        </div>
                        <div class="f-col-12 f-col-lg-4">
                            <div class="footer-box footer-info">
					        	<h4>회사정보</h4>
					        	<address>
						        	<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
		                            <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm">
		                                <div class="btn-group">
		                                    <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=biz_info&amp;amode=biz&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> 기업정보 설정</a>
		                                    <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=biz_info&amp;amode=biz&amp;thema=<?php echo $theme; ?>" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
		                                        <i class="far fa-window-maximize"></i>
		                                    </a>
		                                    <button type="button" class="btn-e btn-e-xs btn-e-red btn-e-split-red popovers" data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-content="
		                                        <span class='font-size-11'>
		                                        <strong class='color-indigo'>기업정보 사용가능한 변수</strong><br>
		                                        <div class='margin-hr-5'></div>
		                                        <span class='color-indigo'>[설정정보]</span><br>
		                                        회사명 : $bizinfo['bi_company_name']<br>
		                                        사업자등록번호 : $bizinfo['bi_company_bizno']<br>
		                                        대표자명 : $bizinfo['bi_company_ceo']<br>
		                                        대표전화 : $bizinfo['bi_company_tel']<br>
		                                        팩스번호 : $bizinfo['bi_company_fax']<br>
		                                        통신판매업 : $bizinfo['bi_company_sellno']<br>
		                                        부가통신사업자 : $bizinfo['bi_company_bugano']<br>
		                                        정보관리책임자 : $bizinfo['bi_company_infoman']<br>
		                                        정보책임자메일 : $bizinfo['bi_company_infomail']<br>
		                                        우편번호 : $bizinfo['bi_company_zip']<br>
		                                        주소1 : $bizinfo['bi_company_addr1']<br>
		                                        주소2 : $bizinfo['bi_company_addr2']<br>
		                                        주소3 : $bizinfo['bi_company_addr3']<br>
		                                        고객센터1 : $bizinfo['bi_cs_tel1']<br>
		                                        고객센터2 : $bizinfo['bi_cs_tel2']<br>
		                                        고객센터팩스 : $bizinfo['bi_cs_fax']<br>
		                                        고객센터메일 : $bizinfo['bi_cs_email']<br>
		                                        상담시간 : $bizinfo['bi_cs_time']<br>
		                                        휴무안내 : $bizinfo['bi_cs_closed']
		                                        </span>
		                                    "><i class="fas fa-question-circle"></i></button>
		                                </div>
		                            </div>
		                            <?php } ?>
		                            <span class="add">주소 <?php echo $bizinfo['bi_company_zip']; ?> <?php echo $bizinfo['bi_company_addr1']; ?> <?php echo $bizinfo['bi_company_addr2']; ?><br> <?php echo $bizinfo['bi_company_addr3']; ?></span><br>
		                            <span>대표 <?php echo $bizinfo['bi_company_ceo']; ?></span>
		                            <span>사업자등록번호 <?php echo $bizinfo['bi_company_bizno']; ?></span><br>
		                            <span>E-mail <a href="mailto:<?php echo $bizinfo['bi_cs_email']; ?>"><?php echo $bizinfo['bi_cs_email']; ?></a></span>
		                            <span>Tel <?php echo $bizinfo['bi_cs_tel1']; ?></span>
	                            </address>
				        	</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-btm">
                <?php /* copyright */ ?>
                <div class="copyright">Copyright &copy; <strong><?php echo $config['cf_title']; ?></strong>. All Rights Reserved.</div>
            </div>
        </footer>
	
	    <?php /* 상하단 이동 */ ?>
        <div class="bw-top-btm">
        	<ul>
		        <li class="go-to-top">
		    		<a href="">
			    		<i class="fas fa-caret-up"></i>
		            </a>
		        </li>
		    	<li class="go-to-bottom">
		    		<a href="">
			    		<i class="fas fa-caret-down"></i>
		            </a>
		        </li>
			</ul>
		</div>
	</div><?php /* End wrapper-inner */ ?>
</div><?php /* End wrapper */ ?>
<?php } ?>

<div class="sidebar-left-mask sidebar-left-trigger" data-action="toggle" data-side="left"></div>
<div class="sidebar-right-mask sidebar-right-trigger" data-action="toggle" data-side="right"></div>
<div class="sidebar-shop-mask sidebar-shop-trigger"></div>
<form name="fitem_for_list" method="post" action="" onsubmit="return fitem_for_list_submit(this);">
<input type="hidden" name="url">
<input type="hidden" name="it_id">
</form>

<?php
include_once(EYOOM_THEME_PATH . '/misc.html.php');
?>

<?php
if ($is_member && $eyoomer['onoff_push'] == 'on') {
    include_once(EYOOM_THEME_PATH . '/skin/push/basic/push.skin.html.php');
}
?>

<script src="<?php echo EYOOM_THEME_URL; ?>/js/shop-app.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script>
$(window).on('load', function() {
    ShopApp.init();
});

function search_submit(f) {
    if (f.q.value.length < 2) {
        alert("검색어는 두글자 이상 입력하십시오.");
        f.q.select();
        f.q.focus();
        return false;
    }
    return true;
}

function item_wish_for_list(it_id) {
    var f = document.fitem_for_list;
    f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
    f.it_id.value = it_id;
    f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
    f.submit();
}

<?php if ($is_admin == 'super') { ?>
$(document).ready(function() {
    var edit_mode = "<?php echo $eyoom_default['edit_mode']; ?>";
    if (edit_mode == 'on') {
        $(".btn-edit-mode").show();
    } else {
        $(".btn-edit-mode").hide();
    }

    $("#btn_edit_mode").click(function() {
        var edit_mode = $("#edit_mode").val();
        if (edit_mode == 'on') {
            $(".btn-edit-mode").hide();
            $("#edit_mode").val('');
        } else {
            $(".btn-edit-mode").show();
            $("#edit_mode").val('on');
        }

        $.post("<?php echo G5_ADMIN_URL; ?>/?dir=theme&pid=theme_editmode&smode=1", { edit_mode: edit_mode });
    });
});
<?php } ?>
</script>