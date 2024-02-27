"use strict";

function fn_alert_focus(message, selector) {
    alert(message);
    selector && $(selector).focus();
    /*
    if (!window.swal) {
        alert(message);
        selector && $(selector).focus();
        return false;
    }
    swal({
        'title': '',
        'text': "\n" + message + "\n\n",
        'showCancelButton': false,
        'confirmButtonColor': "#545454",
        'confirmButtonText': "확인",
        'closeOnConfirm': true
    }, function () {
        selector && $(selector).focus();
    });*/
    return false;
}

function fn_alert_error(message, title) {
    alert(message);
    /*
    window.swal ? swal({
        'title': title || '오류',
        'text': message + "\n",
        'type': 'error',
        'confirmButtonColor': "#545454",
        'confirmButtonText': "확인",
        'closeOnConfirm': true
    }) : alert(message);
    */
    return false;
}


function disableClick(event) {
    if (event.button == 2) {
        event.preventDefault();
        fn_alert_focus('마우스 오른쪽 버튼을 이용할 수 없습니다.');
        return false;
    }
}

function hasParent() {
    return window.parent && window.parent.closePayUp;
}


function closeCapture() {
    if (!hasParent()) {
        !window.opener && (window.opener = self);
        window.close();
    }
    else {
        window.parent.closePayUp();
    }
}

function completeCapture(response) {
    try {

        if (!hasParent()) {
            !window.opener && (window.opener = self);
            fn_alert_error('유효하지 않은 접근입니다.');
            window.close();
        }
        else if (response.responseCode != '0000') {
            $('FORM[name="frmPayout"] button[type="submit"]').removeAttr('disabled');
            fn_alert_error(data.responseMsg);
        }
        else {
            $('#pay-complete').show(function () {
                window.parent.completePayUp(response);
            });
        }
    }
    catch (e) {
        fn_alert_error('결제가 정상적으로 승인되었으나, 오류로 인하여 주문처리를 할 수 없습니다.\n관리자에게 문의하세요.');
        closeCapture();
    }
}

function cardFormat(value, storage) {
    var parts = [], n, sl = (storage || '').length, vl = (value || '').length;

    if (sl < vl) {
        if ((sl == 4 && vl == 5) || (sl == 9 && vl == 10) || (sl == 14 && vl == 15)) {
            parts = [storage, value.charAt(v - 1)];
        }
        else if (vl == 4 || vl == 9 || vl == 14) {
            parts = [value, ''];
        }
    }
    else {
        n = value.replace(/\s+/g, '').replace(/[^\d]/gi, '');
        var matches = n.match(/\d{4,16}/g), m = matches && matches[0] || '';
        for (var i = 0, len = m.length; i < len; i += 4) {
            parts.push(m.substring(i, i + 4))
        }
    }
    return parts.length > 0 ? parts.join(' ') : '';
}

function expirFormat(value, storage) {
    var parts = [], n, sl = (storage || '').length, vl = (value || '').length;
    if (sl < vl) {
        if ((sl == 4 && vl == 5) || (sl == 3 && vl == 4) || (sl == 2 && vl == 3)) {
            parts = [storage, value.charAt(vl - 1)];
        }
        else if (vl == 2) {
            parts = [value, ''];
        }
    }
    else if (sl == 5 && vl == 4) {
        parts = [value.substr(0, 2)];
    }
    else {
        n = value.replace(/\s+/gi, '').replace(/[^\d]/gi, '');
        n.length > 2 && (parts = [n.substr(0, 2), n.substr(2, 2)]);
        n.length == 2 && (parts = [n.substr(0, 2)]);
    }
    return parts.length > 0 ? parts.join(' / ') : '';
}


$(function () {
    var $form = $('FORM[name="frmPayout"]');
    $('button[data-dismiss="modal" ]').on('click', closeCapture);

    $('A.btn-popup').on('click', function (event) {
        event.preventDefault();

        var k = $(this).attr('data-label'), url = {
            'term': 'https://payup.co.kr/popup/term',
            'privacy': 'https://payup.co.kr/popup/privacy',
            'quota': payupHostName + '/popup/noInterest?mid=' + payupAccountName + '&type=m'
        }[k];

        if (!url) ;

        else if (window.parent && window.parent.popupModal) {
            window.parent.popupModal(url, k == 'quota');
        }
        else {
            window.open(url, '', 'width=' + (k == 'quota' ? 600 : 450) + ',height=700,toolbar=no,menubar=no');
        }
    });

    (function () {
        var $checks = $('#terms-container INPUT:checkbox.term-check')
            , $control = $checks.filter('[data-role="control"]')
            , $bind = $checks.not('[data-role="control"]');

        $control.on('change', function () {
            $bind.prop('checked', this.checked);
        });

        $bind.on('change', function () {
            var checked = $bind.filter(':checked').length;
            if (!checked) {
                $control.removeClass('partial').prop('checked', false);
            }
            else if (checked == $bind.length) {
                $control.removeClass('partial').prop('checked', true);
            }
            else {
                $control.addClass('partial').prop('checked', false);
            }
        });
    })();


    (function () {
        var $cardNo = $form.find('INPUT[name="cardNo"]'), $expiry = $form.find('INPUT[name="expiry"]');

        var fulfilled = true;

        function getCardInfo(force) {
            if (!fulfilled) return true;
            var cardNo = $cardNo.val().replace(/_/g, '').replace(/-/g, '').replace(/ /g, '');
            if (cardNo.length < 6) {
                $('#card-info-desc').text('');
                return false;
            }
            else if (cardNo.length !== 6 && force !== true) {
                return false;
            }

            var param = {'cardNo': cardNo};
            force === true && (param.cardNo = param.cardNo.substring(0, 6));

            fulfilled = false;
            $.post(g5_shop_url + '/payup/payup_card_check.php', param, function (response) {
                if (response.responseCode != '0000') {
                    $('#card-info-desc').text('카드정보 없음');
                    return false;
                }
                var inf = response.cardInfo;
                $('#card-info-desc').text(inf.issuer + ' / ' + inf.voucherName + ' / ' + inf.division + ' / ' + inf.brand + ' / ' + inf.type + '카드');
            }).fail(function () {
                console.log("CARD BIN CHECK ERROR!!");
            }).always(function () {
                fulfilled = true;
            });
        }

        function nextFocus(event) {
            var $self = $(event.target)
                , v = $self.val().replace(/[^\d]+/g, '')
                , l = ($self.attr('data-focus-size') || $self.attr('maxLength') || 0) * 1
                , $next = $($self.attr('data-labelledby'));

            if (l <= 0 || !$next.length) {
                $self.off('click', nextFocus);
                return false;
            }
            v = v.replace(/[^\d]+/g, '');
            v.length == l && $next.focus();
        }

        $cardNo.on('keydown', function () {
            $cardNo.data('storage', $cardNo.val());
        }).on('focusout', function () {
            getCardInfo(true);
        }).on('propertychange change keyup paste input', function () {
            var result = cardFormat($cardNo.val(), $cardNo.data('storage'));
            result && $cardNo.val(result);
            event.type == 'keyup' && getCardInfo();
        });

        $expiry.on('keydown', function () {
            $expiry.data('storage', $cardNo.val());
        }).on('propertychange change keyup paste input', function () {
            var result = expirFormat($expiry.val(), $expiry.data('storage'));
            result && $expiry.val(result);
        });

        $form.find('INPUT.next-focus').on('keyup', nextFocus);


    })();

    $form.on('submit', function (event) {
        event.preventDefault();

        if (!$form.hasClass('payout')) {
            if (!this.ck02.checked) {
                fn_alert_focus("전자 금융거래 이용약관에 동의 해주세요.");
                return false;
            }
            else if (!this.ck03.checked) {
                fn_alert_focus("개인정보 처리방침에 동의 해주세요.");
                return false;
            }
            $('html').scrollTop(0);
            $form.addClass('payout').find('button[type="submit"]').text('결제하기');
            return false;
        }

        if (!this.cardNo.value.replace(/[^\d]+/g, '').length) {
            return fn_alert_focus('카드번호를 입력해주세요.', 'PU_cardNo');
        }
        else if (!this.expiry.value.replace(/[^\d]+/g, '').length) {
            return fn_alert_focus('유효기간을 입력해주세요.', 'PU_expiry');
        }
        else if (!this.pass.value.replace(/[^\d]+/g, '').length) {
            return fn_alert_focus('비밀번호 앞2자리를 입력해주세요.', 'PU_pw');
        }
        else if (!this.identify.value.replace(/[^\d]+/g, '').length) {
            return fn_alert_focus('생년월일/사업자번호를 입력해주세요.', 'PU_identify');
        }

        $('#pay-load').show();
        $form.find('button[type="submit"]').attr('disabled', true);
        $.post(g5_shop_url + '/payup/payup_payout.php', $form.serialize(), completeCapture).always(function () {
            $('#pay-load').hide();
        });
    });
});