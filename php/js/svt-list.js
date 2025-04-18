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

})();
