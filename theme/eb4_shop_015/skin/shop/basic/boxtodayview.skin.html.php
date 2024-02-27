<?php
/**
 * core file : /eyoom/core/shop/boxtodayview.skin.php - 이미지 사이즈, 한번에 보여줄 이미지 수
 */
if (!defined('_EYOOM_')) exit;
?>
<style>
.op-area h2 {margin:0;padding:10px;font-size:13px;background:#333;color:#fff}
.op-area h2 span {font-weight:400;color:#fe676e}
.op-area-inner {width:220px;padding:15px;border:1px solid #ccc;border-right:0 none;background:#fff;}
.op-area ul {display:flex;justify-content:center;margin:0 -2px}
.op-area ul li {position:relative;padding:0 2px}
.op-area ul li .prd-name {opacity:0;position:absolute;top:-22px;left:50%;transform:translateX(-50%);min-width:60px;padding:2px 4px;font-size:9px;color:#fff;background:#333;border-radius:2px !important;transition:.3s ease}
.op-area ul li:hover .prd-name {opacity:1}
.op-area #stv {position:relative}
.op-area #stv_pg {display:block;;text-align:center;margin:5px 0;line-height:20px;font-size:11px}
.op-area .stv-item {display:none;word-break:break-all}
.op-area .stv-btn:after {content:"";display:block;clear:both}
.op-area #up {float:left;width:28px;height:20px;line-height:18px;overflow:hidden;border:1px solid #c5c5c5}
.op-area #up span {position:absolute;font-size:0;line-height:0;overflow:hidden}
.op-area #down {float:right;width:28px;height:20px;line-height:18px;overflow:hidden;border:1px solid #c5c5c5}
.op-area #down span {position:absolute;font-size:0;line-height:0;overflow:hidden}
.op-area .li-empty {font-size:11px;color:#707070}
</style>
<div id="stv" class="op-area">
    <div class="op-area-inner">
	    <?php if ($tv_list) { ?>
	    <ul id="stv_ul" class="list-unstyled">
	        <?php if (is_array($tv_list)) { ?>
	        <?php foreach ($tv_list as $info) { ?>
	        <li class="stv-item c<?php echo $info['k']; ?> clear-after">
	            <div class="prd-img"><?php echo $info['img']; ?></div>
	            <div class="prd-name ellipsis"><?php echo cut_str($info['it_name'], 10, ''); ?></div>
	        </li>
	        <?php } ?>
	        <?php } ?>
	    </ul>

	    <span id="stv_pg"></span>
	    <div id="stv_btn" class="stv-btn"></div>

	    <script>
	    $(function() {
	        var itemQty = <?php echo $tv_tot_count; ?>; // 총 아이템 수량
	        var itemShow = <?php echo $tv_div['img_length']; ?>; // 한번에 보여줄 아이템 수량
	        if (itemQty > itemShow) {
	            $('#stv_btn').append('<button type="button" id="up"><i class="fas fa-angle-left"></i><span>이전</span></button><button type="button" id="down"><span>다음</span><i class="fas fa-angle-right"></i></button>');
	        }
	        var Flag = 1; // 페이지
	        var EOFlag = parseInt(<?php echo $cnt-1; ?>/itemShow); // 전체 리스트를 3(한 번에 보여줄 값)으로 나눠 페이지 최댓값을 구하고
	        var itemRest = parseInt(<?php echo $cnt-1; ?>%itemShow); // 나머지 값을 구한 후
	        if (itemRest > 0) // 나머지 값이 있다면
	        {
	            EOFlag++; // 페이지 최댓값을 1 증가시킨다.
	        }
	        $('.c'+Flag).css('display','block');
	        $('#stv_pg').text(Flag+'/'+EOFlag); // 페이지 초기 출력값
	        $('#up').click(function() {
	            if (Flag == 1)
	            {
	                alert('목록의 처음입니다.');
	            } else {
	                Flag--;
	                $('.c'+Flag).css('display','block');
	                $('.c'+(Flag+1)).css('display','none');
	            }
	            $('#stv_pg').text(Flag+'/'+EOFlag); // 페이지 값 재설정
	        })
	        $('#down').click(function() {
	            if (Flag == EOFlag)
	            {
	                alert('더 이상 목록이 없습니다.');
	            } else {
	                Flag++;
	                $('.c'+Flag).css('display','block');
	                $('.c'+(Flag-1)).css('display','none');
	            }
	            $('#stv_pg').text(Flag+'/'+EOFlag); // 페이지 값 재설정
	        });
	    });
	    </script>

	    <?php } else { // 오늘 본 상품이 없을 때?>
	    <p class="li-empty">해당내용 없음</p>
	    <?php } ?>
	</div>
</div>

<script src="<?php echo G5_JS_URL ?>/scroll_oldie.js"></script>