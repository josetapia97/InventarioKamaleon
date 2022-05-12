var tabla;

//funcion que se ejecuta al inicio

//funcion limpiar form
function limpiar() {
  $("idcaracteristica").val("");
  $("nombre").val("");
}

//mostrar formulario

function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadocaracteristicas").hide();
    $("#formularioregistro").show();
    $("btnGuardar").prop("disabled", false);
  } else {
    $("#listadocaracteristicas").show();
    $("#formularioregistro").hide();
  }
}

//funcion cancelarform
function cancelarform() {
  limpiar();
  mostrarform(false);
}

//listar
function listar() {
  console.log("listar");
  tabla = $("#tbllistado").DataTable({
    ajax: "../ajax/caracteristica.php?op=listar",
  });
}

$(document).ready(function () {
  mostrarform(false);
  tabla = $("#tbllistado").DataTable({
    ajax: "../ajax/caracteristica.php?op=listar",
    dom: "Bfrtip",
    buttons: ["copy", "excel", "pdf"],
  });
});
