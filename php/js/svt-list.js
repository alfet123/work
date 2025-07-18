(function() {

const documentHtml = document.querySelector('html');
const documentBody = document.querySelector('body');

// Элементы формы фильтра
const formSvtFilter = document.querySelector('form#svt_filter');
const inputPageCurrent = document.querySelector('input#page_current');

const selectBuild = formSvtFilter.querySelector('select#build_id');
const selectFloor = formSvtFilter.querySelector('select#floor_id');
const selectRoom = formSvtFilter.querySelector('select#room_id');
const selectType = formSvtFilter.querySelector('select#type_id');
const selectModel = formSvtFilter.querySelector('select#model_id');
const selectDepart = formSvtFilter.querySelector('select#depart_id');
const selectStatus = formSvtFilter.querySelector('select#status_id');

const inputNumber = formSvtFilter.querySelector('input#svt_number');
const inputSerial = formSvtFilter.querySelector('input#svt_serial');
const inputInv = formSvtFilter.querySelector('input#svt_inv');
const inputComment = formSvtFilter.querySelector('input#svt_comment');

const formElementClearButtons = formSvtFilter.querySelectorAll('div.form-element-clear-btn');

const buttonSubmit = formSvtFilter.querySelector('button#form_submit');
const buttonReset = formSvtFilter.querySelector('button#form_reset');

//const inputSvtFilter = formSvtFilter.querySelectorAll('input.svt-filter-text');
//const selectSvtFilter = formSvtFilter.querySelectorAll('select.svt-filter-select');

// Элементы таблицы
const tableSvt = document.querySelector('table.table-svt');
const tableRows = tableSvt.querySelectorAll('tr.tr-item');

// Элементы блока пагинации
const buttonFirst = document.querySelector('button#page_first');
const buttonPrev = document.querySelector('button#page_prev');
const buttonNext = document.querySelector('button#page_next');
const buttonLast = document.querySelector('button#page_last');

// Элементы модального окна
const modalWrapper = document.querySelector('div.wrapper-modal');
const modalSection = document.querySelector('section.modal');

//const modalForm = modalSection.querySelector('form#modal_form');

const modalTitle = modalSection.querySelector('div#modal_title');
const modalClose = modalSection.querySelector('.modal-close');

const modalStatus = modalSection.querySelector('select#modal_status_id');
const modalBuild = modalSection.querySelector('select#modal_build_id');
const modalFloor = modalSection.querySelector('select#modal_floor_id');
const modalRoom = modalSection.querySelector('select#modal_room_id');
const modalType = modalSection.querySelector('select#modal_type_id');
const modalModel = modalSection.querySelector('select#modal_model_id');

const modalSvtId = modalSection.querySelector('input#modal_svt_id');
const modalSvtNumber = modalSection.querySelector('input#modal_svt_number');
const modalSvtSerial = modalSection.querySelector('input#modal_svt_serial');
const modalSvtInv = modalSection.querySelector('input#modal_svt_inv');
const modalSvtComment = modalSection.querySelector('input#modal_svt_comment');

const modalButtonReset = modalSection.querySelector('button#modal_button_reset');
const modalButtonSave = modalSection.querySelector('button#modal_button_save');
const modalButtonClose = modalSection.querySelector('button#modal_button_close');

// Данные для обработчика выпадающих списков changeSelectValue
const select = {
  'build_id': {
    'source': 'floor',
    'target': selectFloor,
    'clear': [selectFloor, selectRoom]
  },
  'floor_id': {
    'source': 'room',
    'target': selectRoom,
    'clear': []
  },
  'type_id': {
    'source': 'model',
    'target': selectModel,
    'clear': []
  },
  'modal_build_id': {
    'source': 'floor',
    'target': modalFloor,
    'clear': [modalFloor, modalRoom]
  },
  'modal_floor_id': {
    'source': 'room',
    'target': modalRoom,
    'clear': []
  },
  'modal_type_id': {
    'source': 'model',
    'target': modalModel,
    'clear': []
  }
};

// Данные модального окна при открытии (для контроля изменений)
const modalData = {};

const modalChanges = {};

const modalFormFields = [
  {element: modalStatus},
  {element: modalBuild},
  {element: modalFloor},
  {element: modalRoom},
  {element: modalType},
  {element: modalModel},
  {element: modalSvtNumber},
  {element: modalSvtSerial},
  {element: modalSvtInv},
  {element: modalSvtComment}
];

const checkChanged = function() {

  modalFormFields.forEach(item => {

    if (item.element.value.trim() !== modalData[item.element.name]) {
      modalChanges[item.element.name] = item.element.value.trim();
      item.element.classList.add('value_changed');
    } else {
      delete modalChanges[item.element.name];
      item.element.classList.remove('value_changed');
    }

    if (item.element.required && item.element.value.trim() === "") {
      item.element.classList.add('value_required');
    } else {
      item.element.classList.remove('value_required');
    }

  });

}

// Проверка заполнения обязательных полей
const isEmpty = function() {
  return modalStatus.value.trim().length === 0 ||
         modalBuild.value.trim().length === 0 ||
         modalFloor.value.trim().length === 0 ||
         modalRoom.value.trim().length === 0 ||
         modalType.value.trim().length === 0 ||
         modalModel.value.trim().length === 0 ||
         modalSvtSerial.value.trim().length === 0;
}

// Проверка измененных значений
const isChanged = function() {
  return modalStatus.value.trim() !== modalData.modal_status_id ||
         modalBuild.value.trim() !== modalData.modal_build_id ||
         modalFloor.value.trim() !== modalData.modal_floor_id ||
         modalRoom.value.trim() !== modalData.modal_room_id ||
         modalType.value.trim() !== modalData.modal_type_id ||
         modalModel.value.trim() !== modalData.modal_model_id ||
         modalSvtNumber.value.trim() !== modalData.modal_svt_number ||
         modalSvtSerial.value.trim() !== modalData.modal_svt_serial ||
         modalSvtInv.value.trim() !== modalData.modal_svt_inv ||
         modalSvtComment.value.trim() !== modalData.modal_svt_comment;
}

const checkModalData = function() {

  checkChanged();

  // Управление кнопкой сброса (восстановления)
  if (isEmpty() || isChanged()) {
    modalButtonReset.removeAttribute("disabled");
  } else {
    modalButtonReset.setAttribute("disabled", "");
  }

  // Управление кнопкой сохранения
  if (!isEmpty() && isChanged()) {
    modalButtonSave.removeAttribute("disabled");
  } else {
    modalButtonSave.setAttribute("disabled", "");
  }

}

/********************************************/
/***  Вывод элементов выпадающего списка  ***/
/********************************************/

function renderSelectList(data, target, emptyOption=false, clear=[], checkValues=false) {
  var clearList = [target];
  if (clear.length) {
    clearList = clear;
  }
  clearList.forEach((item) => {
    item.setAttribute("disabled", "");
    item.innerHTML = (emptyOption) ? '<option value="" hidden disabled selected>&nbsp;</option>' : '';
  });
  Object.values(data).forEach((item) => {
    let name = item.name;
    if (target.name === 'room_id' || target.name === 'modal_room_id') {
      name = (`${item.number} ${item.name}`).trim();
    }
    target.innerHTML += `<option value="${item.id}"${item.selected}>${name}</option>`;
  });
  if (Object.entries(data).length) {
    target.removeAttribute("disabled");
  }
  if (checkValues) {
    checkModalData();
  }
}

/**************************************/
/***  Загрузка данных справочников  ***/
/**************************************/

const loadSprav = function(element, tableName, filterId=null, currentId=null) {
  const requestURL = `get/${tableName}/${filterId}/${currentId}`;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return;
    }
    const data = JSON.parse(xhr.response);
    renderSelectList(data, element);
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
    return;
  };
  xhr.send();
};

/*********************************************/
/***  Обработчик для кнопок формы фильтра  ***/
/*********************************************/

// Отправка формы
const clickSubmitButton = function() {
  inputPageCurrent.value = 1;
  formSvtFilter.submit();
};

// Очистка формы
const clickResetButton = function() {
  window.location.href = "/";
};

buttonSubmit.addEventListener('click', clickSubmitButton);
buttonReset.addEventListener('click', clickResetButton);

/*********************************************/
/***  Функции для элементов формы фильтра  ***/
/*********************************************/

// Переключение состояния кнопки очистки
const switchClearBtn = function(element) {
  const clearBtn = element.parentNode.querySelector('div.form-element-clear-btn');
  if (element.value === "" || element.value === null) {
    clearBtn.classList.add('hidden');
  } else {
    clearBtn.classList.remove('hidden');
  }
}

// Загрузка значений для выбранного элемента списка
const loadSelectValues = function(event, selectName) {
  const requestURL = `get/${selectName.source}/${event.target.value}`;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return;
    }
    const data = JSON.parse(xhr.response);
    renderSelectList(data, selectName.target, true, selectName.clear, true);
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
  };
  xhr.send();
};

// Обработчик изменения значения поля
const changeValue = function(event) {
  switchClearBtn(event.target);
  if (event.target.name in select) {
    loadSelectValues(event, select[event.target.name]);
  }
}

selectBuild.addEventListener('change', changeValue);
selectFloor.addEventListener('change', changeValue);
selectRoom.addEventListener('change', changeValue);
selectType.addEventListener('change', changeValue);
selectModel.addEventListener('change', changeValue);
selectDepart.addEventListener('change', changeValue);
selectStatus.addEventListener('change', changeValue);

inputNumber.addEventListener('input', changeValue);
inputSerial.addEventListener('input', changeValue);
inputInv.addEventListener('input', changeValue);
inputComment.addEventListener('input', changeValue);

/******************************************/
/***  Обработчик выбора строки таблицы  ***/
/******************************************/

// Загрузка данных по заданному ID
const selectRow = function(event) {
  const requestURL = `get/svt/${event.currentTarget.id}`;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return;
    }
    const data = JSON.parse(xhr.response);
    renderModal(data);
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
  };
  xhr.send();
};

//const selectRow = function(event) {
//  window.location.href = `/svt/${event.currentTarget.id}`;
//};

tableRows.forEach((item) => {
  item.addEventListener('click', selectRow);
});

/*****************************************/
/***  Обработчик для кнопок пагинации  ***/
/*****************************************/

const clickPagesButton = function(event) {
  inputPageCurrent.value = event.currentTarget.value;
  formSvtFilter.submit();
};

buttonFirst.addEventListener('click', clickPagesButton);
buttonPrev.addEventListener('click', clickPagesButton);
buttonNext.addEventListener('click', clickPagesButton);
buttonLast.addEventListener('click', clickPagesButton);

/*************************************/
/***  Функции для модального окна  ***/
/*************************************/

// Открыть модальное окно
const renderModal = function(svtData) {

  modalData.modal_status_id = svtData['status_id'];
  modalData.modal_build_id = svtData['build_id'];
  modalData.modal_floor_id = svtData['floor_id'];
  modalData.modal_room_id = svtData['room_id'];
  modalData.modal_type_id = svtData['type_id'];
  modalData.modal_model_id = svtData['model_id'];
  modalData.modal_svt_number = svtData['svt_number'];
  modalData.modal_svt_serial = svtData['svt_serial'];
  modalData.modal_svt_inv = svtData['svt_inv'];
  modalData.modal_svt_comment = svtData['svt_comment'];

  documentHtml.classList.add('scroll-disable');
//  documentBody.classList.add('scroll-disable');

  modalTitle.innerHTML = `${svtData['svt_id']} - ${svtData['type_name']} ${svtData['model_name']} (${svtData['svt_serial']})`;

  modalSvtId.value = svtData['svt_id'];

  loadSprav(modalStatus, 'status', null, modalData.modal_status_id);
  loadSprav(modalBuild, 'build', null, modalData.modal_build_id);
  loadSprav(modalFloor, 'floor', modalData.modal_build_id, modalData.modal_floor_id);
  loadSprav(modalRoom, 'room', modalData.modal_floor_id, modalData.modal_room_id );
  loadSprav(modalType, 'type', null, modalData.modal_type_id);
  loadSprav(modalModel, 'model', modalData.modal_type_id, modalData.modal_model_id);

  modalSvtNumber.value = modalData.modal_svt_number;
  modalSvtSerial.value = modalData.modal_svt_serial;
  modalSvtInv.value = modalData.modal_svt_inv;
  modalSvtComment.value = modalData.modal_svt_comment;

  modalWrapper.classList.add('wrapper-modal-visible');
}

// Закрыть модальное окно
const closeModal = function() {

  Object.keys(modalData).forEach(key => delete modalData[key]);

  modalTitle.innerHTML = "";

  modalStatus.value = null;
  modalStatus.innerHTML = "";

  modalBuild.value = null;
  modalBuild.innerHTML = "";

  modalFloor.value = null;
  modalFloor.innerHTML = "";

  modalRoom.value = null;
  modalRoom.innerHTML = "";

  modalType.value = null;
  modalType.innerHTML = "";

  modalModel.value = null;
  modalModel.innerHTML = "";

  modalSvtNumber.value = "";
  modalSvtSerial.value = "";
  modalSvtInv.value = "";
  modalSvtComment.value = "";

  modalFormFields.forEach(item => {
    item.element.classList.remove('value_changed');
    item.element.classList.remove('value_required');
  });

  modalButtonReset.setAttribute("disabled", "");
  modalButtonSave.setAttribute("disabled", "");

  delete modalData.modal_status_id;
  delete modalData.modal_build_id;
  delete modalData.modal_floor_id;
  delete modalData.modal_room_id;
  delete modalData.modal_type_id;
  delete modalData.modal_model_id;
  delete modalData.modal_svt_number;
  delete modalData.modal_svt_serial;
  delete modalData.modal_svt_inv;
  delete modalData.modal_svt_comment;

  modalWrapper.classList.remove('wrapper-modal-visible');
  documentHtml.classList.remove('scroll-disable');
//  documentBody.classList.remove('scroll-disable');
}

modalClose.addEventListener('click', closeModal);
modalButtonClose.addEventListener('click', closeModal);
documentBody.addEventListener('keydown', (event) => {
  if (event.key === "Escape") {
    closeModal();
  }
});

// Сбросить (восстановить) исходные данные модального окна
const resetModal = function() {
  loadSprav(modalStatus, 'status', null, modalData.modal_status_id);
  loadSprav(modalBuild, 'build', null, modalData.modal_build_id);
  loadSprav(modalFloor, 'floor', modalData.modal_build_id, modalData.modal_floor_id);
  loadSprav(modalRoom, 'room', modalData.modal_floor_id, modalData.modal_room_id );
  loadSprav(modalType, 'type', null, modalData.modal_type_id);
  loadSprav(modalModel, 'model', modalData.modal_type_id, modalData.modal_model_id);

  modalSvtNumber.value = modalData.modal_svt_number;
  modalSvtSerial.value = modalData.modal_svt_serial;
  modalSvtInv.value = modalData.modal_svt_inv;
  modalSvtComment.value = modalData.modal_svt_comment;

  modalFormFields.forEach(item => {
    item.element.classList.remove('value_changed');
    item.element.classList.remove('value_required');
  });

  modalButtonReset.setAttribute("disabled", "");
  modalButtonSave.setAttribute("disabled", "");
}

modalButtonReset.addEventListener('click', resetModal);

// Успешное сохранение данных
const saveModalSuccess = function() {
  closeModal();
  formSvtFilter.submit();
}

// Запрос для сохранения изменений
const saveChanges = function(tableName, id, newDataObject) {
  const requestURL = `put/${tableName}/${id}`;
  const xhr = new XMLHttpRequest();
  xhr.open('PUT', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return;
    }
    const result = JSON.parse(xhr.response);
    //console.log(result);
    if (result.data_is_updated) {
      saveModalSuccess();
    }
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
    return;
  };
  xhr.send(JSON.stringify(newDataObject));
};

// Сохранить изменения модального окна
const saveModal = function() {
  saveChanges('svt', modalSvtId.value, modalChanges);
}

modalButtonSave.addEventListener('click', saveModal);

// Изменение данных формы
const changeModalForm = function(event) {

  if (event.target.name in select) {

    loadSelectValues(event, select[event.target.name]);

  } else {

    checkModalData();

  }
  
}

const clearFormElement = function(event) {
  var formElement = event.target.parentNode.parentNode;

  var formElementInput = formElement.querySelector('input');
  var formElementSelect = formElement.querySelector('select');

  if (formElementInput !== null) {
    formElementInput.value = "";
  }

  if (formElementSelect !== null) {
    formElementSelect.value = null;
  }

  event.target.classList.add('hidden');
}

modalStatus.addEventListener('change', changeModalForm);
modalBuild.addEventListener('change', changeModalForm);
modalFloor.addEventListener('change', changeModalForm);
modalRoom.addEventListener('change', changeModalForm);
modalType.addEventListener('change', changeModalForm);
modalModel.addEventListener('change', changeModalForm);

modalSvtNumber.addEventListener('input', changeModalForm);
modalSvtSerial.addEventListener('input', changeModalForm);
modalSvtInv.addEventListener('input', changeModalForm);
modalSvtComment.addEventListener('input', changeModalForm);

formElementClearButtons.forEach((clearButton) => {
  clearButton.addEventListener('click', clearFormElement);
});

})();
