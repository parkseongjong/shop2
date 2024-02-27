<?php

if ($_COOKIE['BM-POPUP-221011'] == 'Y' || ($_NOW = time()) < strtotime('2022-10-11 10:00:00') || $_NOW > strtotime('2022-10-11 11:20:00')) {
    unset($_NOW);
    return;
}
?>
<style type="text/css">
    #popup-dialog .modal-dialog {margin-top: 15%}
    #popup-dialog .modal-content {box-shadow: 0 1px 10px rgba(0, 0, 0, .25)}
    #popup-dialog .popup-dismiss {line-height: 1.5;font-weight: normal;padding-right: .5rem;display: inline-block; cursor: pointer;}
    #popup-dialog .popup-dismiss input {vertical-align: middle; margin: 0}
</style>

<div id="popup-dialog" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">긴급공지</h4>
            </div>
            <div class="modal-body">
                안녕하세요. 바리바리마켓입니다.<br />
                저희 사이트를 이용해 주시는 고객님들께 감사의 말씀을 드립니다.<br /><br />

                많은 분들이 이용해주시는 포인트 시스템 개편을 위하여 일시적으로 서비스가 중단될 예정입니다.<br />
                이에 불편을 끼쳐드려 죄송하다는 말씀을 먼저 드리며, 서비스 일시 중지됨을 알려드립니다.<br /><br />

                <strong>시스템 개편 적용을 위해 2022년 10월 12일(수) 오전 11:00 ~ 11:30까지 전체 서비스가 일시 중단 됩니다.</strong><br /><br />

                본 시간동안에는 서비스 접속이 불가능하며 최대한 빠르게 정상적인 서비스를 제공해드릴 수 있도록 노력하겠습니다.<br />
                감사합니다.<br />
            </div>
            <div class="modal-footer">
                <label class="popup-dismiss"><input type="checkbox" /> 오늘 하루 그만보기</label>
                <button data-dismiss="modal" class="btn-e btn-e-lg btn-e-dark" type="button">
                    <i class="fas fa-times"></i> 닫기
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#popup-dialog').modal('show').on('hide.bs.modal', function () {
            if ($(this).find('LABEL.popup-dismiss INPUT:checkbox:checked').length > 0) {
                var dt = new Date(), days = 1;
                dt.setDate(dt.getDate() + days);
                document.cookie = 'BM-POPUP-221011' + '=Y; path=/; expires=' + dt.toUTCString() + ';'
            }
        })
    });
</script>
