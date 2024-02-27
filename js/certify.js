// 본인확인 인증창 호출
function certify_win_open(type, url, event) {

    var popupWindow;
    var width, height, leftpos, toppos;

    typeof event == "undefined" && (event = window.event);
    if (type == 'kcb-ipin') {
        popupWindow = window.open(url, "kcbPop", "left=200, top=100, status=0, width=450, height=550");
    }
    else if (type == 'kcb-hp') {
        popupWindow = window.open(url, "auth_popup", "left=200, top=100, width=430, height=590, scrollbar=yes");
    }
    else if (type == 'kcp-hp') {
        $("input[name=veri_up_hash]").length < 1 && $("input[name=cert_no]").after('<input type="hidden" name="veri_up_hash" value="">');

        if (navigator.userAgent.indexOf("Android") > -1 || navigator.userAgent.indexOf("iPhone") > -1) {
            var $section = $('#kcp-identify-verify-frame'), $content;

            $section.length && $section.remove();
            $section = $('<section id="kcp-identify-verify-frame"></section>');
            $content = $('<div></div>').css({'display': 'flex', 'flex-direction': 'column', 'height': '100%'});
            $content.append('<div style="padding: 15px 15px 0 0"><button type="button" class="close">&times;</button></div>');
            $section.append($content);
            $section.css({'position': 'fixed', 'left': 0, 'top': 0, 'width': '100vw', 'height': '100vh', 'background': '#fff', 'z-index': 501}).appendTo('body:eq(0)');
            $content.find('button.close').on('click', function () {
                $section.remove();
            });

            $content.append('<div style="flex-grow: 1"><iframe src="' + url + '" name="ifrMobileOwnerVerify" frameborder="0" allowtransparency="true" width="100%" height="100%" scrolling="yes"></iframe></div>');
        }
        else {
            width = 410;
            height = 500;

            leftpos = screen.width / 2 - (width / 2);
            toppos = screen.height / 2 - (height / 2);

            var winopts = "width=" + width + ", height=" + height + ", toolbar=no,status=no,statusbar=no,menubar=no,scrollbars=no,resizable=no";
            var position = ",left=" + leftpos + ", top=" + toppos;
            popupWindow = window.open(url, 'auth_popup', winopts + position);
        }
    }
    else if (type == 'lg-hp') {

        if (g5_is_mobile) {
            var $frm = $(event.target.form),
                lgu_cert = "lgu_cert";

            if ($("#lgu_cert").length < 1) {
                $frm.wrap('<div id="cert_info"></div>');

                $("#cert_info").append('<form name="form_temp" method="post">');
            }
            else {
                $("#" + lgu_cert).remove();
            }

            $("#cert_info")
                .after('<iframe id="' + lgu_cert + '" name="lgu_cert" width="100%" src="' + url + '" height="700" frameborder="0" scrolling="no" style="display:none"></iframe>');

            document.getElementById("cert_info").style.display = "none";
            document.getElementById(lgu_cert).style.display = "";

        }
        else {
            width = 640;
            height = 660;

            leftpos = screen.width / 2 - (width / 2);
            toppos = screen.height / 2 - (height / 2);

            popupWindow = window.open(url, "auth_popup", "left=" + leftpos + ", top=" + toppos + ", width=" + width + ", height=" + height + ", scrollbar=yes");

        }
    }

    popupWindow && popupWindow.focus();
    return popupWindow;

}

// 인증체크
function cert_confirm() {
    var type;
    var val = document.fregisterform.cert_type.value

    switch (val) {
        case "ipin":
            type = "아이핀";
            break;
        case "hp":
            type = "휴대폰";
            break;
        default:
            return true;
    }

    if (confirm("이미 " + type + "으로 본인확인을 완료하셨습니다.\n\n이전 인증을 취소하고 다시 인증하시겠습니까?"))
        return true;
    else
        return false;
}