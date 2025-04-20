(function() {

// Функция для вывода элементов выпадающего списка

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

// Найти таблицу

  var tableSvt = document.querySelector('table.table-svt');

  if (tableSvt === null) {
    return 0;
  }

// Установить обработчик выбора строки

  var tableRows = tableSvt.querySelectorAll('tr.tr-item');

  if (tableRows.length === 0) {
    return 0;
  }

  var selectRow = function(event) {
    window.location.href = window.location.origin+"/svt/"+event.currentTarget.id;
  };

  tableRows.forEach((item) => {
    item.addEventListener('click', selectRow);
  });

/***************************************/
/***  Общее для обработчиков кнопок  ***/
/***************************************/

  // Форма #svt-filter
  var formSvtFilter = document.querySelector('form#svt_filter');

  // Поле ввода #page_current
  var inputPageCurrent = document.querySelector('input#page_current');

/*************************************/
/***  Обработчик для кнопок формы  ***/
/*************************************/

  var buttonSubmit = formSvtFilter.querySelector('button#form_submit');
  var buttonReset = formSvtFilter.querySelector('button#form_reset');

  var inputSvtFilter = formSvtFilter.querySelectorAll('input.svt-filter-text');
  var selectSvtFilter = formSvtFilter.querySelectorAll('select.svt-filter-select');

  // Отправка формы
  var clickSubmitButton = function() {
    inputPageCurrent.value = 1;
    formSvtFilter.submit();
  };

  // Очистка формы
  var clickResetButton = function() {
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

var selectBuild = formSvtFilter.querySelector('select[id="build_id"]');
var selectFloor = formSvtFilter.querySelector('select[id="floor_id"]');
var selectRoom = formSvtFilter.querySelector('select[id="room_id"]');
var selectType = formSvtFilter.querySelector('select[id="type_id"]');
var selectModel = formSvtFilter.querySelector('select[id="model_id"]');

// Выбор здания, загрузка этажей
var changeBuild = function(event) {
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
var changeFloor = function(event) {
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
var changeType = function(event) {
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

/*****************************************/
/***  Обработчик для кнопок пагинации  ***/
/*****************************************/

  var buttonFirst = document.querySelector('button#page_first');
  var buttonPrev = document.querySelector('button#page_prev');
  var buttonNext = document.querySelector('button#page_next');
  var buttonLast = document.querySelector('button#page_last');

  var clickPagesButton = function(event) {
    inputPageCurrent.value = event.currentTarget.value;
    formSvtFilter.submit();
  };

  buttonFirst.addEventListener('click', clickPagesButton);
  buttonPrev.addEventListener('click', clickPagesButton);
  buttonNext.addEventListener('click', clickPagesButton);
  buttonLast.addEventListener('click', clickPagesButton);

})();
