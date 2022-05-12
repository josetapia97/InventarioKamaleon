function limpiar() {
  $("#idempresa").val("");
  $("#razonsocial").val("");
  $("#rut").val("");
  $("#patrimonio").val("");
}

//mostrar formulario

function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadoregistros").hide();
    $("#formularioregistro").show();
    $("btnGuardar").prop("disabled", false);
  } else {
    $("#listadoregistros").show();
    $("#formularioregistro").hide();
  }
}

//funcion cancelarform
function cancelarform() {
  limpiar();
  mostrarform(false);
}
$(function() {
  tabla = $("#tbllistado").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend :'excel',
        exportOptions: {
          columns: [ 0, 1, 2]
        }
      }
      
    ]
  });
});
