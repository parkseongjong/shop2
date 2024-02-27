$(function () {
    var $dialog, $export = $('button.btn-export[data-filter]'), $import = $('button.btn-import[data-filter]');
    var sse, tmID, is_process = false;
    var $progressbar, $progresstext, $progressvalue;
    var $file, callback;

    if (!window.EventSource) {
        $('button.btn-export[data-filter], button.btn-import[data-filter]').on('click', function () {
            alert('현재 브라우저에서 SSE를 지원하지 않습니다.\n개발자에게 문의하세요.');
        });
        // Result to xhr polling :(
        return;
    }

    /**
     *
     * @param message
     * @param value
     * @param {string} [feed]
     */
    function fnl_progress(message, value, feed) {
        $progresstext.html(message);
        if (value == 'reset') {
            $progressbar.width(0);
            $progressvalue.text('');
        }
        else if (value == 'error') {
            feed = 'error';
        }
        else if (!isNaN(value)) {
            $progressbar.width(value + '%');
            $progressvalue.text(value + '%');
        }

        feed ? $progresstext.attr('data-feedback', feed) : $progresstext.removeAttr('data-feedback');
    }

    /**
     *
     */
    function fnl_dialog_open() {
        if (!$dialog) {
            $dialog = $('<div class="export-container"></div>');
            $dialog.html("<section class=\"export-dialog\"><div class=\"export-content\"><article class=\"export-progress\"><span class=\"export-progressbar\"></span><em></em></article><article class=\"export-message\"></article><article class=\"export-button\"><button type=\"button\" data-dismiss=\"dialog\">닫기</button></article></div></section>");
            $dialog.find('[data-dismiss="dialog"]').on('click', fnl_sse_close);
            $dialog.appendTo('BODY:eq(0)');

            $progressbar = $dialog.find('.export-progressbar');
            $progresstext = $dialog.find('.export-message');
            $progressvalue = $dialog.find('.export-progress > em');
        }
        $dialog.show();
    }

    /**
     *
     */
    function fnl_dialog_close() {
        clearTimeout(tmID);
        tmID = null;

        tmID = setTimeout(function () {
            $dialog.hide();
            fnl_progress('', 'reset');
        }, 500)
    }

    /**
     *
     */
    function fnl_sse_open(endpoint) {
        if (sse || is_process) {
            $file && $file.removeAttr('disabled');
            return false;
        }

        is_process = true;
        $file && $file.attr('disabled');

        fnl_dialog_open();

        sse = new EventSource(endpoint);
        // -- Connection was opened.
        sse.addEventListener('open', function () {
            console.info("Event::Connection.");
        }, false);

        sse.addEventListener('error', function (event) {
            if (event.readyState == EventSource.CLOSED) {
                console.warn("Event::Closed.");
                // Connection was closed.
            }
        }, false);

        sse.addEventListener('error', fnl_sse_response, false);
        sse.addEventListener('log', fnl_sse_response, false);
        sse.addEventListener('close', fnl_sse_response, false);
        sse.addEventListener('warn', fnl_sse_response, false);
    }

    /**
     *
     * @param is_force
     */
    function fnl_sse_close(is_force) {
        if (sse) {
            sse.removeEventListener('error', fnl_sse_response, false);
            sse.removeEventListener('log', fnl_sse_response, false);
            sse.removeEventListener('close', fnl_sse_response, false);
            sse.removeEventListener('warn', fnl_sse_response, false);

            sse.close();
            sse = null;
        }

        is_process = false;
        $file &&  $file.removeAttr('disabled');

        is_force !== false && fnl_dialog_close();
    }

    /**
     *
     * @param event
     */
    function fnl_sse_response(event) {
        var result = JSON.parse(event.data);

        switch (event.type) {
            case 'warn':
            case 'error': {
                fnl_progress(result.message, 'error');
                fnl_sse_close(false);
                break;
            }
            case 'log': {
                var value = 0;
                result.hasOwnProperty('param') && result.param.hasOwnProperty('progress') && (value = result.param.progress * 1);
                fnl_progress(result.message, value);
                break;
            }
            case 'close': {


                if (result.param && result.param.mode == 'export') {
                    fnl_sse_close();
                    window.location.href = g5_admin_url + '?dir=export&pid=download&id=' + result.param.fileName;
                }
                else if (result.param.apply > 0) {
                    fnl_progress(result.message, 100);
                    fnl_sse_close(false);

                    $dialog.find('[data-dismiss="dialog"]').html('확인').off('click').on('click', function () {
                        window.location.reload(true);
                    });
                }
                else {
                    fnl_progress(result.message, 100);
                    fnl_sse_close();
                    callback && callback();
                }

                break;
            }
            default: { // close
                result.message && fnl_progress(result.message, 'error');
                fnl_sse_close();
                break;
            }
        }
    }

    $export.on('click', function () {
        fnl_sse_open(g5_admin_url + '?' + $(this).attr('data-filter'));
    });

    /*
     *
     *
     */
    var endpoint = g5_admin_url + '/import/' + $import.attr('data-filter') + '_import';

    function _importing(result) {
        if (result.code !== 200) {
            _reset();
            alert('ERR-' + result.code + ': ' + result.message);
            return false;
        }
        callback = _reset;
        fnl_sse_open(endpoint + '?mode=import&id=' + result.message);
    }

    function _reset() {
        ($file && $file.length > 0) && $file.remove();

        $file = $('<INPUT type="file" accept="application/vnd.ms-excel"  />');
        $file.css({'opacity': 0, 'position': 'absolute', 'left': 0, 'top': 0, 'width': '100%', 'height': '100%', 'z-index': 2});
        $import.css({'position': 'relative', 'z-index': 1}).append($file);

        $file.on('change', function () {
            var file, formData;
            this.files.length > 0 && (file = this.files[0]);

            if (!file) {
                alert('업로드할 엑셀 파일을 선택해주세요.');
                return false;
            }

            formData = new FormData();
            formData.append('responseType', 'json');
            formData.append('mode', 'upload');
            formData.append('source', file);

            $.ajax({
                'url': endpoint
                , 'processData': false
                , 'contentType': false
                , 'type': 'POST'
                , 'data': formData
                , 'success': _importing
                , 'error': function (e) {
                    alert(e.responseText());
                }
            });
        });
    }

    $import.length > 0 && _reset();
});