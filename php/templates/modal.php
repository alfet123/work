<div class="wrapper-modal">
<section class="modal">

<div class="modal-data">

    <div class="modal-data-header">
        <div class="modal-title" id="modal_title"></div>
        <div class="modal-close">X</div>
    </div>

    <form class="modal-form" action="" id="modal_form">

    <input hidden readonly type="text" id="modal_svt_id" name="modal_svt_id" value="">

    <div class="modal-data-element">
    <label class="modal-label" for="modal_status_id">Статус</label>
    <select class="modal-select" name="modal_status_id" id="modal_status_id" required></select>
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_build_id">Здание</label>
    <select class="modal-select" name="modal_build_id" id="modal_build_id" required></select>
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_floor_id">Этаж</label>
    <select class="modal-select" name="modal_floor_id" id="modal_floor_id" required></select>
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_room_id">Кабинет</label>
    <select class="modal-select" name="modal_room_id" id="modal_room_id" required></select>
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_type_id">Тип</label>
    <select class="modal-select" name="modal_type_id" id="modal_type_id" required></select>
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_model_id">Модель</label>
    <select class="modal-select" name="modal_model_id" id="modal_model_id" required></select>
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_svt_number">№ ТК</label>
    <input class="modal-text" type="text" size="8" maxlength="8" id="modal_svt_number" name="modal_svt_number" value="">
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_svt_serial">Серийный номер</label>
    <input class="modal-text" type="text" size="16" maxlength="32" id="modal_svt_serial" name="modal_svt_serial" value="" required>
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_svt_inv">Инвентарный номер</label>
    <input class="modal-text" type="text" size="16" maxlength="16" id="modal_svt_inv" name="modal_svt_inv" value="">
    </div>

    <div class="modal-data-element">
    <label class="modal-label" for="modal_svt_comment">Примечание</label>
    <input class="modal-text" type="text" size="32" maxlength="64" id="modal_svt_comment" name="modal_svt_comment" value="">
    </div>

    </form>

</div>

<div class="modal-buttons">

    <div class="modal-buttons-section  modal-buttons-section-left">
        <div class="modal-buttons-element">
        <button id="modal_button_reset" disabled="">Восстановить</button>
        </div>
    </div>

    <div class="modal-buttons-section  modal-buttons-section-right">
        <div class="modal-buttons-element">
        <button id="modal_button_save" disabled="">Сохранить</button>
        </div>

        <div class="modal-buttons-element">
        <button id="modal_button_close">Закрыть</button>
        </div>
    </div>

</div>

</section>
</div>
