function check_all(f) {
    var chk = document.getElementsByName("chk[]");

    for (i = 0; i < chk.length; i++)
        chk[i].checked = f.chkall.checked;
}

function btn_check(f, act) {
    if (act == "update") // 선택수정
    {
        f.action = list_update_php;
        str = "수정";
    }
    else if (act == "delete") // 선택삭제
    {
        f.action = list_delete_php;
        str = "삭제";
    }
    else
        return;

    var chk = document.getElementsByName("chk[]");
    var bchk = false;

    for (i = 0; i < chk.length; i++) {
        if (chk[i].checked)
            bchk = true;
    }

    if (!bchk) {
        alert(str + "할 자료를 하나 이상 선택하세요.");
        return;
    }

    if (act == "delete") {
        if (!confirm("선택한 자료를 정말 삭제 하시겠습니까?"))
            return;
    }

    f.submit();
}

function is_checked(elements_name) {
    var checked = false;
    var chk = document.getElementsByName(elements_name);
    for (var i = 0; i < chk.length; i++) {
        if (chk[i].checked) {
            checked = true;
        }
    }
    return checked;
}

function delete_confirm(el) {
    if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        var token = get_ajax_token();
        var href = el.href.replace(/&token=.+$/g, "");
        if (!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }
        el.href = href + "&token=" + token;
        return true;
    }
    else {
        return false;
    }
}

function delete_confirm2(msg) {
    if (confirm(msg))
        return true;
    else
        return false;
}

function get_ajax_token() {
    var token = "";

    $.ajax({
        type: "POST",
        url: g5_admin_url + "/ajax.token.php",
        cache: false,
        async: false,
        dataType: "json",
        success: function (data) {
            if (data.error) {
                alert(data.error);
                if (data.url)
                    document.location.href = data.url;

                return false;
            }

            token = data.token;
        }
    });

    return token;
}

String.prototype.ucfirst = function () {
    this.replace(/\b[a-z]/g, function (letter) {
        return letter.toUpperCase();
    })
};

$(function () {
    $(document).on("click", "form input:submit, form button:submit", function () {
        var f = this.form;
        var token = get_ajax_token();

        if (!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }

        var $f = $(f);

        if (typeof f.token === "undefined")
            $f.prepend('<input type="hidden" name="token" value="">');

        $f.find("input[name=token]").val(token);

        return true;
    });

    // data-startDate data-start-date
    moment && moment.locale('ko');

    (function () {
        var mapping = {
            'startdate': 'startDate'
            , 'enddate': 'endDate'
            , 'mindate': 'minDate'
            , 'maxdate': 'maxDate'
            , 'maxspan': 'maxSpan'
            , 'showdropdowns': 'showDropdowns'
            , 'minyear': 'minYear'
            , 'maxyear': 'maxYear'
            , 'showweeknumbers': 'showWeekNumbers'
            , 'showisoweeknumbers': 'showISOWeekNumbers'
            , 'timepicker': 'timePicker'
            , 'timepickerincrement': 'timePickerIncrement'
            , 'timepicker24hour': 'timePicker24Hour'
            , 'timepickerseconds': 'timePickerSeconds'
            , 'ranges': 'ranges'
            , 'showcustomrangelabel': 'showCustomRangeLabel'
            , 'alwaysshowcalendars': 'alwaysShowCalendars'
            , 'opens': 'opens'
            , 'drops': 'drops'
            , 'buttonclasses': 'buttonClasses'
            , 'applybuttonclasses': 'applyButtonClasses'
            , 'cancelbuttonclasses': 'cancelButtonClasses'
            , 'locale': 'locale'
            , 'singledatepicker': 'singleDatePicker'
            , 'autoapply': 'autoApply'
            , 'linkedcalendars': 'linkedCalendars'
            , 'isinvaliddate': 'isInvalidDate'
            , 'iscustomdate': 'isCustomDate'
            , 'autoupdateinput': 'autoUpdateInput'
            //
            , 'callback': 'callback'
            , 'bind': 'bind'
        };

        /**
         *
         * @param {string} stringify
         * @return {{}}
         * @private
         */
        function __parse_ranges(stringify) {
            // format
            // days: 2d, 7d, ...
            // weeks: 1w, 2w, ...
            // month : 1m, 2m, .. , 6m
            // year: 1y
            if (stringify.toLowerCase() === 'tpl') {
                return {
                    '오늘': [moment(), moment()]
                    , '1주': [moment().subtract(1, 'weeks').startOf('week'), moment().endOf('week')]
                    , '2주': [moment().subtract(2, 'weeks').startOf('week'), moment().endOf('week')]
                    , '이달': [moment().startOf('month'), moment().endOf('month')]
                    , '3개월': [moment().subtract(3, 'months').startOf('month'), moment().endOf('month')]
                    , '6개월': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')]
                    // , '올해': [moment().startOf('year'), moment().endOf('year')]
                    //, '1년전': [moment().subtract(1, 'y').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                }
            }
            else if (stringify.toLowerCase() === 'monthly') {
                return {
                    '어제': [moment().subtract(1, 'days'), moment().subtract(1, 'days')]
                    , '1주전': [moment().subtract(1, 'weeks').startOf('week'), moment().subtract(1, 'weeks').endOf('week')]
                    , '전달': [moment().subtract(1, 'months').startOf('month'), moment().subtract(1, 'months').endOf('month')]
                    , '3개월': [moment().subtract(3, 'months').startOf('month'), moment().endOf('month')]
                    , '6개월': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')]
                    // , '올해': [moment().startOf('year'), moment().endOf('year')]
                    //, '1년전': [moment().subtract(1, 'y').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                }
            }


            var data = JSON.parse(stringify), label, duration, entry, entries = {};
            for (label in data) {
                if (!data.hasOwnProperty(label)) continue;
                duration = data[label].replace(/[^\d]+$/, '') * 1;

                // -- default value
                entry = [moment(), moment()];

                switch (data[label].replace(/^[\d]+/gi, '').toLowerCase()) {
                    default: {
                        entry = null;
                        break;
                    }
                    case 'd': {
                        duration > 0 && entry[0].subtract(duration, 'days');
                        break;
                    }
                    case 'w': {
                        entry[0].subtract(duration > 0 ? (duration * 7) - 1 : 6, 'days');
                        break;
                    }
                    case 'm': {
                        duration > 0 && (entry[0].subtract(duration, 'month'));
                        entry[0].startOf('month');
                        entry[1].endOf('month');
                        break;
                    }
                    case 'y': {
                        duration > 0 && (result[label][0].subtract(duration, 'year'));
                        entry[0].startOf('year');
                        entry[1].endOf('year');
                        break;
                    }
                }
                entry && (entries[label] = entry);
            }
            return entries;

        }


        $.fn.daterangepicker && $('.date-range-picker').each(function () {
            var options = {
                    'locale': {
                        "format": "YYYY년 MM월 DD일",
                        "applyLabel": "확인",
                        "cancelLabel": "닫기",
                        "customRangeLabel": "지정하기"
                    }
                    , 'autoUpdateInput': true
                    , 'alwaysShowCalendars': true
                    , 'showCustomRangeLabel': false
                    , 'callback': null
                },
                picker = $(this),
                toggle = $('<INPUT type="text" class="date-range-picker-toggle" readonly/>').appendTo(picker),
                bind,
                is_empty = picker.hasClass('allow-empty'),
                oncompleted = new Function('');

            if (this.hasAttributes()) {
                $(this.attributes).each(function () {
                    var name, val, key;
                    if (this.name.indexOf('data-') !== 0 || !mapping.hasOwnProperty(name = this.name.toLowerCase().replace(/^data-/ig, '').replace(/[^\w]+/ig, ''))) return;

                    key = mapping[name];
                    typeof (val = this.value) === 'string' && (val.toLowerCase() === 'true' || val.toLowerCase() === 'false' || val.toLowerCase() === 'null') && (val = eval(val.toLowerCase() + ';'));


                    // data-range={'라벨': format} : json type
                    name === 'ranges' && (val = __parse_ranges(val.toString()));
                    val !== null && (options[key] = val);
                });

                //
                options.callback && window[options.callback] && (oncompleted = window[options.callback]);
                delete options.callback;
            }
            options.hasOwnProperty('bind') && (bind = $(options.bind), delete options.bind);

            is_empty && (function () {
                options.autoUpdateInput = false;
                options.locale.cancelLabel = '전체';
                toggle.on('cancel.daterangepicker', function () {
                    toggle.val('')
                }).val('');
            })();


            toggle.daterangepicker(options).on('apply.daterangepicker', function (event, picker) {
                var label = picker.startDate.format(picker.locale.format) + ' - ' + picker.endDate.format(picker.locale.format);
                bind && bind.length > 0 && bind.eq(0).val(picker.startDate.format('YYYY-MM-DD'));
                bind && bind.length > 1 && bind.eq(1).val(picker.endDate.format('YYYY-MM-DD'));
                is_empty && toggle.val(label);

                oncompleted(picker.startDate, picker.endDate, label);
            }).on('show.daterangepicker', function () {
                picker.addClass('show-picker');
            }).on('hide.daterangepicker', function () {
                picker.removeClass('show-picker');
            });


        });

    })();

});

// -----------------------------------------------------------------------------------

/**
 *
 * @param {int|undefined} [decimals]
 * @param {int} [fixed]
 * @returns {string}
 */
Number.prototype.numberFormat = function (decimals, fixed) {
    if (this == 0) {
        return '0';
    }
    var pattern = new RegExp('(\\d+)(\\d{' + (decimals || 3) + '})(\\.\\d*)*$'),
        _fnl_callback = function (match, p1, p2, p3) {
            return p1.replace(pattern, _fnl_callback) + ',' + p2 + (p3 || '');
        };

    var value = this, values, e;
    (Math.abs(value) < 1.0) ? (e = parseInt(value.toString().split('e-')[1])) && (value *= Math.pow(10, e - 1), (value = '0.' + (new Array(e
    )).join('0') + value.toString().substring(2))) : ((e = parseInt(value.toString().split('+')[1])) > 20) && (e -= 20, value /= Math.pow(10, e)
        , value += (new Array(e + 1)).join('0'));
    values = (value + '').split('.');
    (fixed > 0) && (values[1] = ((values[1] || '') + (0).toFixed(fixed).split('.').pop()).substr(0, fixed));
    return (values[0] = values[0].replace(pattern, _fnl_callback), values.join('.').replace(/\.$/, ''));
};
/**
 *
 * @param {int|undefined} [decimals]
 * @param {int} [fixed]
 * @returns {string}
 */
String.prototype.numberFormat = function (decimals, fixed) {
    var number = parseFloat(this);
    if (isNaN(number)) {
        return '';
    }
    return number.numberFormat(decimals, fixed);
};