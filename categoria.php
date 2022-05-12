<?php

session_start();
// Validar que tiene acceso a la pagina
$_SESSION['privilegio-1'] = true;
$_SESSION['privilegio-2'] = true;

if (!isset($_SESSION['privilegio-1']) || !$_SESSION["privilegio-1"]) {
  header("location: login.php");
  exit();
}

require 'modelos/Categoria.php';

$categoriaOBJ = new Categoria();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $propiedades = $_POST['propiedades'];
  // TODO: Cambiar
  $form_id = $_POST['idcategoria'];

  if (empty($form_id)) {
    $categoriaOBJ->insertar($nombre,$propiedades);
  } else {
    $categoriaOBJ->editar($form_id, $nombre, $propiedades);
  }
  var_dump($_POST);
  header("Location: categoria.php");
  exit();
}


require_once 'header.php' ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">
    <!-- Topbar -->
    <?php require_once 'topbar.php' ?>
    

    <!-- Begin Page Content -->





    <!-- Content Wrapper. Contains page content -->
    <?php
    $categorias = $categoriaOBJ->listar();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Categorias de Articulos
                  <?php if ($_SESSION['privilegio-2']) { ?>
                    <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <?php } ?>
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->


              <div class="panel-body table-responsive " style="padding: 10px 30px;" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Propiedades</th>
                    <?php if ($_SESSION['privilegio-2']) { ?>
                      <th>Acciones</th>
                    <?php } ?>
                  </thead>
                  <tbody>
                    <?php foreach ($categorias as $categoria) : ?>
                      <tr>
                        <td><?php echo $categoria['idcategoria'] ?></td>
                        <td><?php echo $categoria['nombre'] ?></td>
                        <td><?php echo $categoria['propiedades'] ?></td>

                        <?php if ($_SESSION['privilegio-2']) { ?>
                          <td class="notexport">
                            <button class="btn btn-warning" onclick="form_editar('<?= $categoria['idcategoria'] ?>')"> <i class="fa fa-pencil-alt"></i> </button>
                            <button class="btn btn-danger" onclick="eliminar('<?= $categoria['idcategoria'] ?>')"> <i class="fa fa-trash"> </i> </button>
                          </td>
                        <?php } ?>
                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Propiedades</th>

                    <?php if ($_SESSION['privilegio-2']) { ?>
                      <th>Acciones</th>
                    <?php } ?>
                  </tfoot>
                </table>
              </div>

              <!-- Formulario Ingreso -->
              <div class="panel-body" style="height:280px; display: none;" id="formularioregistro">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre Categoria:</label>
                    <input type="hidden" name="form_id" id="idcategoria">
                    <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Ingrese nueva categoria" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Propiedades:</label>
                    <input type="text" class="form-control" name="propiedades" id="propiedades" maxlength="256" placeholder="Ingrese sus caracteristicas">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>
              <!-- End Formulario Ingreso -->

              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

  </div>
  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Your Website 2021</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->


<!-- Modal -->
<div class="modal fade show" id="editar" tabindex="-1" aria-labelledby="editar" aria-hidden="true">
  <div class="modal-dialog " style="margin-top: 15vh;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formulario" id="formulario" method="POST">
          <div class="form-group ">
            <label>Nombre:</label>
            <input type="hidden" id="form_id" name="idcategoria">
            <input type="text" class="form-control" id="form_nombre" name="nombre" maxlength="50" placeholder="Ingrese nuevo nombre" required>
          </div>
          <div class="form-group ">
            <label>Propiedades:</label>
            <input type="text" class="form-control" id="form_propiedades" name="propiedades" maxlength="256" placeholder="Ingrese nuevas caracteristicas">
          </div>
          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <button class="btn btn-primary float-right" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
            <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<?php require_once 'footer.php' ?>

<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">


<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">

<script src="scripts/empresa.js"></script>
<script>
  function form_editar(id) {
    $.ajax({
      url: 'ajax/categoria.php?op=mostrar',
      type: 'post',
      data: {
        idcategoria: id
      },
      success: function(data) {
        data = JSON.parse(data);
        if (typeof data.idcategoria != undefined) {
          $('#form_id').val(data.idcategoria);
          $('#form_nombre').val(data.nombre);
          $('#form_propiedades').val(data.propiedades);
          $('#editar').modal('show');
        }
      }
    });
  }

  function eliminar(id) {
    $.ajax({
      url: 'ajax/categoria.php?op=eliminar',
      type: 'post',
      data: {
        idcategoria: id
      },
      success: function(data) {
        alert('eliminado');
        document.location.reload();
      }
    });
  }
</script>

<?php
require "scripts.php";
?>