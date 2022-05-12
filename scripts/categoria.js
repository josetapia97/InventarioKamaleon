var tabla;

//funcion que se ejecuta al inicio

//funcion limpiar form
function limpiar() {
  $("idcategoria").val("");
  $("nombre").val("");
  $("propiedades").val("");
}

//mostrar formulario

function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadocategorias").hide();
    $("#formularioregistro").show();
    $("btnGuardar").prop("disabled", false);
  } else {
    $("#listadocategorias").show();
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
    ajax: "../ajax/categoria.php?op=listar",
  });
}

$(document).ready(function () {
  mostrarform(false);
  tabla = $("#tbllistado").DataTable({
    ajax: "../ajax/categoria.php?op=listar",
    dom: "Bfrtip",
    buttons: ["copy", "excel", "pdf"],
  });
});
