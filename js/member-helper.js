var MemberHelper = {
    'form': null,
    'feeds': null,

    'call': function (path, param) {
        var result = '';
        $.ajax({
            'type': 'POST',
            'url': g5_bbs_url + '/' + path,
            'data': param,
            'cache': false,
            'async': false,
            'success': function (data) {
                result = data;
            }
        });
        return result ? {'code': 500, 'message': result} : {'code': 200, 'message': 'OK'};
    }
    , 'alert': function (message, selector, type, title) {
        !window.swal ? alert(message) : swal({
            'title': title || '',
            'type': type || 'warning', // warning, error, success, info
            'text': "\n" + message + "\n\n",
            'showCancelButton': false,
            'confirmButtonColor': "#FF4848",
            'confirmButtonText': "확인",
            'closeOnConfirm': true
        }, function () {
            selector && setTimeout(function () {
                $(selector).get(0).focus();
            }, 0);
        });
        return false;
    }
    , 'feedback': function (selector, message, severity, option) {
        severity = severity || '';
        var $input = MemberHelper.form.find('INPUT[name="' + selector + '"]');
        MemberHelper.feeds.filter('[data-control="' + selector + '"]').attr('data-feedback', severity).text(message);

        option !== false && $input.attr('data-feedback', severity);
        option === true && $input.focus();
        return false;
    }
    , 'load': function () {
        var $form = MemberHelper.form;

        $form.find('button.form-is-exists').on('click', function (event) {
            event.preventDefault();
            var $toggle = $(this), scope = $toggle.attr('data-own'), $input = $form.find('INPUT[name="' + scope + '"]').attr('data-feedback', ''), feed = $input.data('feed');
            var result, value, param = {};
            value = param['reg_' + scope] = $input.attr('readOnly', true).val();
            scope == 'mb_recommend' && (param.recommend_type = 'phone', $form.find('INPUT[name="recommendee"]').val(''));

            if (!value) {
                MemberHelper.feedback(scope, scope == 'mb_recommend' ? '통신망 번호(010)을 제외한 추천인의 휴대전화번호 8자리를 입력하세요.' : '필수 정보입니다.', 'error', true);
                $input.removeAttr('readOnly');
            }
            else if ((result = MemberHelper.call('ajax.' + scope + '.php', param)).code != 200) {
                MemberHelper.feedback(scope, result.message, 'error', true);
                $input.removeAttr('readOnly');
            }
            else {
                $input.data('verified', value);
                typeof(feed) === 'function' && feed();

                if (scope == 'mb_recommend') {
                    $form.find('INPUT[name="recommendee"]').val('phone');
                    $input.css('background', '#f5f5f5').attr('readOnly', true);
                    MemberHelper.feedback(scope, '등록 가능한 추천인입니다.', 'success', false);
                    $toggle.attr('data-role') != 'retry' ? $toggle.off('click').attr('disabled', true) : $input.removeAttr('readOnly');
                }
                else {
                    MemberHelper.feedback(scope, '사용 가능합니다.', 'success', false);
                    $input.removeAttr('readOnly');
                }
            }

        });

        $form.find('input[name="mb_id"], input[name="mb_email"], input[name="mb_recommend"]').on('focus', function () {
            var $input = $(this);
            !$input.attr('readOnly') &&
            ($input.attr('data-feedback') == 'error' || $input.data('verified') != $input.val()) &&
            MemberHelper.feedback($input.attr('name'), '', '');
        });


        var Password = {
            'input': $form.find('INPUT[name="mb_password"]')
            , 'confirm': $form.find('INPUT[name="mb_password_re"]')
            , 'min': 4
            , 'max': 20
            , 'score': -1
        };

        // 0: 취약(weakness), 1: 낮음(lowness), 2: 적정(normal), 3: 좋음(good), 4: 안전(safety)
        $form.find('INPUT[name="mb_password"], INPUT[name="mb_password_re"]').on('focus keyup blur', function () {
            Password.score = -1;

            var pass = Password.input.attr('data-score', Password.score).val()
                , conf = Password.confirm.attr('data-score', Password.score).val()
                , len = pass.length;

            MemberHelper.feedback('mb_password', '', '') || MemberHelper.feedback('mb_password_re', '', ''); // reset

            if (!len) {
                MemberHelper.feedback('mb_password', '필수 정보입니다.', 'error');
            }
            else if (Password.min > len || Password.max < len) {
                MemberHelper.feedback('mb_password', Password.min + ' ~ ' + Password.max + '자 이내로 입력하세요.', 'error');
            }
            else {
                Password.input.attr('data-score', (Password.score = zxcvbn(pass, []).score));
                Password.score < 2 && MemberHelper.feedback('mb_password', '보안에 취약하여 사용하실 수 없습니다.', 'error');

                if (!conf.length) {
                    MemberHelper.feedback('mb_password_re', '필수 정보입니다.', 'error');
                }
                else if (conf && pass != conf) {
                    MemberHelper.feedback('mb_password_re', '비밀번호가 일치하지 않습니다.', 'error');
                }
                else if (pass == conf) {
                    Password.confirm.attr('data-score', 'match');
                }
            }
        });


    }
};
/**
 * @typedef {{}} MemberFormType
 * @property {HTMLInputElement} mb_id
 * @property {HTMLInputElement} mb_name
 * @property {HTMLInputElement} mb_password
 * @property {HTMLInputElement} mb_password_re
 * @property {HTMLInputElement} mb_nick
 * @property {HTMLInputElement} mb_email
 * @property {HTMLInputElement} mb_name
 * @property {HTMLInputElement} mb_hp
 * @property {HTMLInputElement} cert_type
 * @property {HTMLInputElement} cert_no
 * @property {HTMLInputElement} recommendee
 * @property {HTMLInputElement} mb_recommend
 * @property {HTMLInputElement} captcha_key
 */
