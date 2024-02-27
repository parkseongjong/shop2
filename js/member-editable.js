$(function () {
    var $form = $('form[name="frmProfile"]');
    $.getScript(g5_url + '/js/member-helper.js', function () {
        MemberHelper.form = $form;
        MemberHelper.feeds = $form.find('DIV.control-feedback');
        MemberHelper.load();
        $form.submit(function (event) {
            event.preventDefault();
            var is_success = true, /**@type {MemberFormType}*/ els = this.elements;

            $form.find('INPUT[data-feedback="error"]').attr('data-feedback', '');
            MemberHelper.feeds.filter('[data-feedback="error"]').attr('data-feedback', '').text('');

            !els.cert_type.value && (is_success = MemberHelper.feedback('verify-mobile', '본인 인증이 필요합니다.', 'error'));

            if (els.mb_password.value) {
                if ($(els.mb_password).attr('data-score') * 1 < 2) {
                    is_success = MemberHelper.feedback('mb_password', '보안에 취약하여 사용하실 수 없습니다.', 'error');
                }
                else if (els.mb_password.value != els.mb_password_re.value) {
                    is_success = MemberHelper.feedback('mb_password_re', '비밀번호가 일치하지 않습니다.', 'error');
                }
            }

            (els.mb_email.value != $(els.mb_email).attr('data-value') && els.mb_email.value != $(els.mb_email).data('verified')) &&
            (is_success = MemberHelper.feedback('mb_email', '중복검사가 필요합니다.', 'error'));

            //
            if (els.recommendee && els.mb_recommend.value) {
                (els.mb_recommend.value != $(els.mb_recommend).attr('data-value') && els.mb_recommend.value != $(els.mb_recommend).data('verified')) &&
                (is_success = MemberHelper.feedback('mb_recommend', '추천인 등록 가능 여부를 확인하셔야 합니다.', 'error'));
            }
            if (!is_success) {
                $form.find('INPUT[data-feedback="error"]:eq(0)').attr('readOnly', true).focus().removeAttr('readOnly');
                return false;
            }
            else if (els.captcha_key && !els.captcha_key.value) {
                MemberHelper.alert('자동등록방지 숫자를 입력해주세요.');
                return false;
            }
            
            !els.mb_nick.value && (els.mb_nick.value = this.mb_id.value);
            this.submit();
        });
    });

    $form.find('INPUT[required]').removeAttr('required').removeClass('required');
    $form.find('.editable-group').each(function () {
        var $group = $(this), $input = $group.find('INPUT.editable-item-write');
        $group.find('button.editable-toggle').on('click', function () {
            $group.attr('data-expanded') !== 'true' ? $group.attr('data-expanded', 'true') : $group.attr('data-expanded', 'false');
            $group.attr('data-expanded') == 'true' && $group.find('INPUT:eq(0)').focus();
        });

        $input.data('feed', function () {
            $group.attr('data-expanded', 'false').find('.editable-item-read').text($input.val());
        });

        $group.find('button.editable-close').on('click', function () {
            $group.attr('data-expanded', 'false').find('.control-feedback[data-feedback="error"]').text('');
            $group.find('[data-feedback="error"]').removeAttr('data-feedback');

            $group.find('[data-role="write"] INPUT').val('').filter('[data-value]').each(function () {
                $(this).val($(this).attr('data-value'));
            });


        });
    });
});
