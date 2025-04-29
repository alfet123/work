(function() {

/**************************************************/
/***  Функция для загрузки данных справочников  ***/
/**************************************************/

const loadSprav = function(element, tableName, filterId=null, currentId=null) {
  const requestURL = `get/` + tableName + `/` + filterId + `/` + currentId;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return null;
    }
    const data = JSON.parse(xhr.response);
    renderSelectList(data, element);
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
    return null;
  };
  xhr.send();
};

/*********************************************************/
/***  Функция для вывода элементов выпадающего списка  ***/
/*********************************************************/

function renderSelectList(data, target, emptyOption=false, clear=[]) {
  var clearList = [target];
  if (clear.length) {
    clearList = clear;
  }
  clearList.forEach((item) => {
    item.innerHTML = (emptyOption) ? '<option value="" hidden disabled selected>&nbsp;</option>' : '';
  });
  // Старый способ
//  for (var key in data) {
//    if (data.hasOwnProperty(key)) {
//      target.innerHTML += '<option value="' + data[key].id + '">' + data[key].name + '</option>';
//    }
//  }
  // ES6
//  Object.keys(data).forEach((key) => {
//    target.innerHTML += '<option value="' + data[key].id + '">' + data[key].name + '</option>';
//  });
  // ES8
  Object.values(data).forEach((item) => {
    var name = item.name;
    if (target.name === 'room_id' || target.name === 'modal_room_id') {
      name = (item.number + ' ' + item.name).trim();
    }
    target.innerHTML += '<option value="' + item.id + '"' + item.selected + '>' + name + '</option>';
  });
}

/*************************************/
/***  Функции для модального окна  ***/
/*************************************/

const modalWrapper = document.querySelector('div.wrapper-modal');
const modalSection = document.querySelector('section.modal');

//const modalData = modalSection.querySelector('div.modal-data');

const modalTitle = modalSection.querySelector('span#modal_title');

const modalBuild = modalSection.querySelector('select#modal_build_id');
const modalFloor = modalSection.querySelector('select#modal_floor_id');
const modalRoom = modalSection.querySelector('select#modal_room_id');
const modalType = modalSection.querySelector('select#modal_type_id');
const modalModel = modalSection.querySelector('select#modal_model_id');

const modalSvtNumber = modalSection.querySelector('input#modal_svt_number');
const modalSvtSerial = modalSection.querySelector('input#modal_svt_serial');
const modalSvtInv = modalSection.querySelector('input#modal_svt_inv');
const modalSvtComment = modalSection.querySelector('input#modal_svt_comment');

const modalButtonSave = modalSection.querySelector('button#modal_button_save');
const modalButtonClose = modalSection.querySelector('button#modal_button_close');

const renderModal = function($svtData) {
//  modalData.innerHTML = "Изменение элемента " + svtId + modalData.innerHTML;
//  modalData.innerHTML = $svtData;
  modalTitle.innerHTML = "Изменение элемента " + $svtData['svt_id'] + " - " + $svtData['type_name'] + " " + $svtData['model_name'] + ", s/n " + $svtData['svt_serial'];

  loadSprav(modalBuild, 'build', null, $svtData['build_id']);
  loadSprav(modalFloor, 'floor', $svtData['build_id'], $svtData['floor_id']);
  loadSprav(modalRoom, 'room', $svtData['floor_id'], $svtData['room_id']);
  loadSprav(modalType, 'type', null, $svtData['type_id']);
  loadSprav(modalModel, 'model', $svtData['type_id'], $svtData['model_id']);

  modalSvtNumber.value = $svtData['svt_number'];
  modalSvtSerial.value = $svtData['svt_serial'];
  modalSvtInv.value = $svtData['svt_inv'];
  modalSvtComment.value = $svtData['svt_comment'];

  modalWrapper.classList.add('wrapper-modal-visible');
}

const closeModal = function() {
//  modalData.innerHTML = "";
  modalTitle.innerHTML = "";

  modalSvtNumber.value = "";
  modalSvtSerial.value = "";
  modalSvtInv.value = "";
  modalSvtComment.value = "";

  modalWrapper.classList.remove('wrapper-modal-visible');
}

modalButtonClose.addEventListener('click', closeModal);

/***************************************/
/***  Общее для обработчиков кнопок  ***/
/***************************************/

// Форма #svt-filter
const formSvtFilter = document.querySelector('form#svt_filter');

// Поле ввода #page_current
const inputPageCurrent = document.querySelector('input#page_current');

/*************************************/
/***  Обработчик для кнопок формы  ***/
/*************************************/

const buttonSubmit = formSvtFilter.querySelector('button#form_submit');
const buttonReset = formSvtFilter.querySelector('button#form_reset');

const inputSvtFilter = formSvtFilter.querySelectorAll('input.svt-filter-text');
const selectSvtFilter = formSvtFilter.querySelectorAll('select.svt-filter-select');

// Отправка формы
const clickSubmitButton = function() {
  inputPageCurrent.value = 1;
  formSvtFilter.submit();
};

// Очистка формы
const clickResetButton = function() {
  inputSvtFilter.forEach((input) => {
    input.defaultValue = "";
    input.value = "";
  });
  selectSvtFilter.forEach((select) => {
    // Старый способ
//    Array.prototype.forEach.call(select.options, (option) => {
//      option.selected = false;
//      option.removeAttribute("selected");
//    });
    // ES6
    for (var option of select.options) {
      option.selected = false;
      option.removeAttribute("selected");
    }
    select.options[0].selected = true;
    select.options[0].setAttribute("selected", "");
  });

  clickSubmitButton();
};

buttonSubmit.addEventListener('click', clickSubmitButton);
buttonReset.addEventListener('click', clickResetButton);

/********************************************/
/***  Обработчики для выпадающих списков  ***/
/********************************************/

const selectBuild = formSvtFilter.querySelector('select#build_id');
const selectFloor = formSvtFilter.querySelector('select#floor_id');
const selectRoom = formSvtFilter.querySelector('select#room_id');
const selectType = formSvtFilter.querySelector('select#type_id');
const selectModel = formSvtFilter.querySelector('select#model_id');

// Выбор здания, загрузка этажей
const changeBuild = function(event) {
  const requestURL = `get/floor/` + event.target.value;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return;
    }
    const data = JSON.parse(xhr.response);
    renderSelectList(data, selectFloor, true, [selectFloor, selectRoom]);
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
  };
  xhr.send();
};
selectBuild.addEventListener('change', changeBuild);

// Выбор этажа, загрузка кабинетов
const changeFloor = function(event) {
  const requestURL = `get/room/` + event.target.value;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return;
    }
    const data = JSON.parse(xhr.response);
    renderSelectList(data, selectRoom, true);
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
  };
  xhr.send();
};
selectFloor.addEventListener('change', changeFloor);

// Выбор типа, загрузка моделей
const changeType = function(event) {
  const requestURL = `get/model/` + event.target.value;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', requestURL);
  xhr.onload = () => {
    if (xhr.status !== 200) {
      console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      return;
    }
    const data = JSON.parse(xhr.response);
    renderSelectList(data, selectModel, true);
  };
  xhr.onerror = () => {
    console.log(`Ошибка при выполнении запроса`);
  };
  xhr.send();
};
selectType.addEventListener('change', changeType);

/******************************************/
/***  Обработчик выбора строки таблицы  ***/
/******************************************/

const tableSvt = document.querySelector('table.table-svt');
if (tableSvt === null) {
  return 0;
}

const tableRows = tableSvt.querySelectorAll('tr.tr-item');
if (tableRows.length === 0) {
  return 0;
}

//const sectionModal = document.querySelector('div.wrapper-modal');

const selectRow = function(event) {
  const requestURL = `get/svt/` + event.currentTarget.id;
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
//  window.location.href = window.location.origin + "/svt/" + event.currentTarget.id;
//  renderModal(event.currentTarget.id);
//};

tableRows.forEach((item) => {
  item.addEventListener('click', selectRow);
});

/*****************************************/
/***  Обработчик для кнопок пагинации  ***/
/*****************************************/

const buttonFirst = document.querySelector('button#page_first');
const buttonPrev = document.querySelector('button#page_prev');
const buttonNext = document.querySelector('button#page_next');
const buttonLast = document.querySelector('button#page_last');

const clickPagesButton = function(event) {
  inputPageCurrent.value = event.currentTarget.value;
  formSvtFilter.submit();
};

buttonFirst.addEventListener('click', clickPagesButton);
buttonPrev.addEventListener('click', clickPagesButton);
buttonNext.addEventListener('click', clickPagesButton);
buttonLast.addEventListener('click', clickPagesButton);

})();
