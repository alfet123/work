(function() {

const documentHtml = document.querySelector('html');
//const documentBody = document.querySelector('body');

// Элементы формы фильтра
const formSvtFilter = document.querySelector('form#svt_filter');
const inputPageCurrent = document.querySelector('input#page_current');

const selectBuild = formSvtFilter.querySelector('select#build_id');
const selectFloor = formSvtFilter.querySelector('select#floor_id');
const selectRoom = formSvtFilter.querySelector('select#room_id');
const selectType = formSvtFilter.querySelector('select#type_id');
const selectModel = formSvtFilter.querySelector('select#model_id');

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

const modalFormFields = [
  {element: modalBuild, originalValue: modalData.modal_build_id},
  {element: modalFloor, originalValue: modalData.modal_floor_id},
  {element: modalRoom, originalValue: modalData.modal_room_id},
  {element: modalType, originalValue: modalData.modal_type_id},
  {element: modalModel, originalValue: modalData.modal_model_id},
  {element: modalSvtNumber, originalValue: modalData.modal_svt_number},
  {element: modalSvtSerial, originalValue: modalData.modal_svt_serial},
  {element: modalSvtInv, originalValue: modalData.modal_svt_inv},
  {element: modalSvtComment, originalValue: modalData.modal_svt_comment}
];

const checkChanged = function() {
  modalFormFields.forEach(item => {
    if (item.element.value.trim() !== item.originalValue) {
      element.classList.add('value_changed');
    } else {
      element.classList.remove('value_changed');
    }
  });
}

// Проверка заполнения обязательных полей
const isEmpty = function() {
  return modalBuild.value.trim().length === 0 ||
         modalFloor.value.trim().length === 0 ||
         modalRoom.value.trim().length === 0 ||
         modalType.value.trim().length === 0 ||
         modalModel.value.trim().length === 0 ||
         modalSvtSerial.value.trim().length === 0;
}

// Проверка измененных значений
const isChanged = function() {
  return modalBuild.value.trim() !== modalData.modal_build_id ||
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
  let clearList = [target];
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
      name = (item.number + ' ' + item.name).trim();
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

/*  inputSvtFilter.forEach((input) => {
    input.defaultValue = "";
    input.value = "";
  });
  selectSvtFilter.forEach((select) => {
    for (let option of select.options) {
      option.selected = false;
      option.removeAttribute("selected");
    }
    select.options[0].selected = true;
    select.options[0].setAttribute("selected", "");
  });

  clickSubmitButton();*/
};

buttonSubmit.addEventListener('click', clickSubmitButton);
buttonReset.addEventListener('click', clickResetButton);

/*******************************************/
/***  Обработчик для выпадающих списков  ***/
/*******************************************/

// Обработчик выбора здания, этажа и типа
const changeSelectValue = function(event) {
  const selectName = select[event.target.name];
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

selectBuild.addEventListener('change', changeSelectValue);
selectFloor.addEventListener('change', changeSelectValue);
selectType.addEventListener('change', changeSelectValue);

//modalBuild.addEventListener('change', changeSelectValue);
//modalFloor.addEventListener('change', changeSelectValue);
//modalType.addEventListener('change', changeSelectValue);

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

  loadSprav(modalBuild, 'build', null, svtData['build_id']);
  loadSprav(modalFloor, 'floor', svtData['build_id'], svtData['floor_id']);
  loadSprav(modalRoom, 'room', svtData['floor_id'], svtData['room_id']);
  loadSprav(modalType, 'type', null, svtData['type_id']);
  loadSprav(modalModel, 'model', svtData['type_id'], svtData['model_id']);

  modalSvtNumber.value = svtData['svt_number'];
  modalSvtSerial.value = svtData['svt_serial'];
  modalSvtInv.value = svtData['svt_inv'];
  modalSvtComment.value = svtData['svt_comment'];

  modalWrapper.classList.add('wrapper-modal-visible');
}

// Закрыть модальное окно
const closeModal = function() {

  Object.keys(modalData).forEach(key => delete modalData[key]);

  modalTitle.innerHTML = "";

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

  modalWrapper.classList.remove('wrapper-modal-visible');
  documentHtml.classList.remove('scroll-disable');
//  documentBody.classList.remove('scroll-disable');
}

modalClose.addEventListener('click', closeModal);
modalButtonClose.addEventListener('click', closeModal);

// Изменение данных формы
const changeModalForm = function(event) {

  if (event.target.name in select) {

    changeSelectValue(event);

  } else {

    checkModalData();

  }
  
//  console.log(`${event.target.name}: ${event.target.value} (${modalData[event.target.name]})`);
}

modalBuild.addEventListener('change', changeModalForm);
modalFloor.addEventListener('change', changeModalForm);
modalRoom.addEventListener('change', changeModalForm);
modalType.addEventListener('change', changeModalForm);
modalModel.addEventListener('change', changeModalForm);

modalSvtNumber.addEventListener('input', changeModalForm);
modalSvtSerial.addEventListener('input', changeModalForm);
modalSvtInv.addEventListener('input', changeModalForm);
modalSvtComment.addEventListener('input', changeModalForm);

})();
