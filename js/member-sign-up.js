$(function () {
    var $form = $('form[name="frmSignUp"]');

    if (window.confirmMobile) {
        var $toggle = $('#mobile-owner-verify-toggle').on('click', window.confirmMobile);
        $form.data('feed', function () {
            $toggle.addClass('success').off('click');
        });
    }

    $.getScript(g5_url + '/js/member-helper.js', function () {
        MemberHelper.form = $form;
        MemberHelper.feeds = $form.find('DIV.control-feedback');
        MemberHelper.load();

        $form.find('INPUT[required]').removeAttr('required').removeClass('required');
        $form.submit(function (event) {
            event.preventDefault();
            var is_success = true, /**@type {MemberFormType}*/ els = this.elements;

            $form.find('INPUT[data-feedback="error"]').attr('data-feedback', '');
            MemberHelper.feeds.filter('[data-feedback="error"]').attr('data-feedback', '').text('');

            if (!els.mb_id.value) {
                is_success = MemberHelper.feedback('mb_id', '필수 정보입니다.', 'error');
            }
            else if (!(/^([0-9a-z_]{3,})$/i).test($.trim(els.mb_id.value).toLowerCase())) {
                is_success = MemberHelper.feedback('mb_id', '3자 이상 영숫자와 밑줄(_)만 가능합니다.', 'error');
            }
            else if ($(els.mb_id).data('verified') != els.mb_id.value) {
                is_success = MemberHelper.feedback('mb_id', '중복검사가 필요합니다.', 'error');
            }

            if (!els.mb_password.value) {
                is_success = MemberHelper.feedback('mb_password', '필수 정보입니다.', 'error');
            }
            else if ($(els.mb_password).attr('data-score') * 1 < 2) {
                is_success = MemberHelper.feedback('mb_password', '보안에 취약하여 사용하실 수 없습니다.', 'error');
            }
            else if (els.mb_password.value != els.mb_password_re.value) {
                is_success = MemberHelper.feedback('mb_password_re', '비밀번호가 일치하지 않습니다.', 'error');
            }

            if(!els.mb_email.value) {
                is_success = MemberHelper.feedback('mb_email', '필수 정보입니다.', 'error');
            }
            else if($(els.mb_email).data('verified') != els.mb_email.value) {
                is_success = MemberHelper.feedback('mb_email', '중복검사가 필요합니다.', 'error');
            }

            els.recommendee && els.mb_recommend.value && !els.recommendee.value && (is_success = MemberHelper.feedback('mb_recommend', '추천인 등록 가능 여부를 확인하셔야 합니다.', 'error'));

            if (!is_success) {
                $form.find('INPUT[data-feedback="error"]:eq(0)').attr('readOnly', true).focus().removeAttr('readOnly');
                return false;
            }
            else if (window.confirmMobile && !els.cert_no.value) {
                MemberHelper.alert('본인확인 후 회원가입이 가능합니다.');
                return false;
            }
            else if (!$form.find('INPUT[name="agree"]:checkbox').is(':checked')) {
                MemberHelper.alert('[회원가입약관] 동의 후 회원가입이 가능합니다.');
                return false;
            }
            else if (!$form.find('INPUT[name="agree1"]:checkbox').is(':checked')) {
                MemberHelper.alert('[개인정보처리방침안내] 동의 후 회원가입이 가능합니다.');
                return false;
            }
            else if (els.captcha_key && !els.captcha_key.value) {
                MemberHelper.alert('자동등록방지 숫자를 입력해주세요.');
                return false;
            }

            !els.mb_nick.value && (els.mb_nick.value = els.mb_id.value);
            this.submit();

        });
    });


});
