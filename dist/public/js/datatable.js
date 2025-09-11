$(document).ready(function () {
  $("#tblEmpleados").dataTable({
    responsive:true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    },
    autoWidth: true,
    ordering: true,
    scrollX: true,
    scrollY: 300,
    scrollCollapse: true,
   columnControl: ['order', 'reorder', 'colVisDropdown'],
    ordering: {
        indicators: false,
        handler: false
    },  
   fixedColumns: true,
   fixedHeader: true,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
    },
  });
});
