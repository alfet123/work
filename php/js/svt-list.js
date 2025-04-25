(function() {

/*********************************************************/
/***  Функция для вывода элементов выпадающего списка  ***/
/*********************************************************/

function renderSelectList(data, target, clear=[]) {
  var clearList = [target];
  if (clear.length) {
    clearList = clear;
  }
  clearList.forEach((item) => {
    item.innerHTML = '<option value="" hidden disabled selected>&nbsp;</option>';
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
    if (target.name === 'room_id') {
      name = (item.number + ' ' + item.name).trim();
    }
    target.innerHTML += '<option value="' + item.id + '">' + name + '</option>';
  });
}

/*************************************/
/***  Функции для модального окна  ***/
/*************************************/

const wrapperModal = document.querySelector('div.wrapper-modal');
const modalData = document.querySelector('div.modal-data');
const buttonModalClose = document.querySelector('button#modal-close');

const renderModal = function(svtId) {
  modalData.innerHTML = "Изменение элемента " + svtId;
  wrapperModal.classList.add('wrapper-modal-visible');
}

const closeModal = function() {
  modalData.innerHTML = "";
  wrapperModal.classList.remove('wrapper-modal-visible');
}

buttonModalClose.addEventListener('click', closeModal);

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
//      Array.prototype.forEach.call(select.options, (option) => {
//        option.selected = false;
//        option.removeAttribute("selected");
//      });
      // ES6
      for (var option of select.options) {
        option.selected = false;
        option.removeAttribute("selected");
      }
      select.options[0].selected = true;
      select.options[0].setAttribute("selected", "");
    });
    formSvtFilter.submit();
  };

  buttonSubmit.addEventListener('click', clickSubmitButton);
  buttonReset.addEventListener('click', clickResetButton);

/********************************************/
/***  Обработчики для выпадающих списков  ***/
/********************************************/

const selectBuild = formSvtFilter.querySelector('select[id="build_id"]');
const selectFloor = formSvtFilter.querySelector('select[id="floor_id"]');
const selectRoom = formSvtFilter.querySelector('select[id="room_id"]');
const selectType = formSvtFilter.querySelector('select[id="type_id"]');
const selectModel = formSvtFilter.querySelector('select[id="model_id"]');

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
    renderSelectList(data, selectFloor, [selectFloor, selectRoom]);
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
    renderSelectList(data, selectRoom);
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
    renderSelectList(data, selectModel);
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
//  window.location.href = window.location.origin + "/svt/" + event.currentTarget.id;
//  sectionModal.classList.add('wrapper-modal-visible');
  renderModal(event.currentTarget.id);
};

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
