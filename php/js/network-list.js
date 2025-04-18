(function() {

// Найти таблицу

  var tableNetwork = document.querySelector('table.table-network');

  if (tableNetwork === null) {
    return 0;
  }

// Отключить колонку с ID

  var columnNetworkId = tableNetwork.querySelectorAll('th.network-id, td.network-id');

  columnNetworkId.forEach((item) => {
    item.classList.add('hidden');
  });

// Установить обработчик выбора строки

  var tableRows = tableNetwork.querySelectorAll('tr.tr-item');

  if (tableRows.length === 0) {
    return 0;
  }

  var selectRow = function(event) {
    window.location.href = window.location.origin+"/network/"+event.currentTarget.id;
  };

  tableRows.forEach((item) => {
    item.addEventListener('click', selectRow);
  });

})();
