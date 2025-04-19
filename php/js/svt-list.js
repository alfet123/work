(function() {

// Найти таблицу

  var tableSvt = document.querySelector('table.table-svt');

  if (tableSvt === null) {
    return 0;
  }

// Отключить колонку с ID

  var columnSvtId = tableSvt.querySelectorAll('th.svt-id, td.svt-id');

  columnSvtId.forEach((item) => {
    item.classList.add('hidden');
  });

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

  // Найти форму #svt-filter
  var formSvtFilter = document.querySelector('form#svt-filter');

  // Найти поле ввода #page_current
  var inputPageCurrent = document.querySelector('input#page_current');

/*************************************/
/***  Обработчик для кнопок формы  ***/
/*************************************/

  var buttonSubmit = document.querySelector('button#submit');
  //var buttonReset = document.querySelector('button#reset');

  var clickSubmitButton = function(event) {
    inputPageCurrent.value = 1;
    formSvtFilter.submit();
  };

  //var clickResetButton = function(event) {
    //inputPageCurrent.value = event.currentTarget.value;
    //formSvtFilter.submit();
  //};

  buttonSubmit.addEventListener('click', clickSubmitButton);
  //buttonReset.addEventListener('click', clickResetButton);

/*****************************************/
/***  Обработчик для кнопок пагинации  ***/
/*****************************************/

  var buttonFirst = document.querySelector('button#first');
  var buttonPrev = document.querySelector('button#prev');
  var buttonNext = document.querySelector('button#next');
  var buttonLast = document.querySelector('button#last');

  var clickPagesButton = function(event) {
    inputPageCurrent.value = event.currentTarget.value;
    formSvtFilter.submit();
  };

  buttonFirst.addEventListener('click', clickPagesButton);
  buttonPrev.addEventListener('click', clickPagesButton);
  buttonNext.addEventListener('click', clickPagesButton);
  buttonLast.addEventListener('click', clickPagesButton);

})();
