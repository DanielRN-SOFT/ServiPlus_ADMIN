$(document).ready(function () {
  $("#tblInformacion").dataTable({
    responsive: true,
    rowReorder: {
      selector: "td:nth-child(2)",
    },
    ordering: true,
    scrollY: 300,
    columnControl: ["order", "reorder", "colVisDropdown"],
    ordering: {
      indicators: false,
      handler: false,
    },
    autoWidth: true,
    scrollX: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
    },
  });
});
