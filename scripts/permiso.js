var tabla;

//funcion que se ejecuta al inicio

//funcion limpiar form
function limpiar() {
  $("idpermiso").val("");
  $("nombre").val("");
}

//mostrar formulario

function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadopermisos").hide();
    $("#formularioregistro").show();
    $("btnGuardar").prop("disabled", false);
  } else {
    $("#listadopermisos").show();
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
    ajax: "../ajax/permiso.php?op=listar",
  });
}

$(document).ready(function () {
  mostrarform(false);
  tabla = $("#tbllistado").DataTable({
    ajax: "../ajax/permiso.php?op=listar",
    dom: "Bfrtip",
    buttons: ["copy", "excel", "pdf"],
  });
});
