<?php


require 'modelos/Empresa.php';

$empresaObj = new Empresa();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $razon = $_POST['razonsocial'];
  $rut = $_POST['rut'];
  // TODO: Cambiar
  $patrimonio = "";
  $form_id = $_POST['form_id'];

  if (empty($form_id)) {
    $empresaObj->insertar($razon, $rut, $patrimonio);
  } else {
    $empresaObj->editar($form_id, $razon, $rut, $patrimonio);
  }

  header("Location: index.php");
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
    $empresas = $empresaObj->listar();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Empresa
                  <?php if ($_SESSION['admin']) { ?>
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
                    <th>Razon Social</th>
                    <th>Rut</th>
                    <?php if ($_SESSION['admin']) { ?>
                      <th>Acciones</th>
                    <?php } ?>
                  </thead>
                  <tbody>
                    <?php foreach ($empresas as $empresa) : ?>
                      <tr>
                        <td><?php echo $empresa['razonsocial'] ?></td>
                        <td><?php echo $empresa['rut'] ?></td>

                        <?php if ($_SESSION['admin']) { ?>
                          <td class="notexport">
                            <button class="btn btn-warning" onclick="form_editar('<?= $empresa['idempresa'] ?>')"> <i class="fa fa-pencil-alt"></i> </button>
                            <button class="btn btn-danger" onclick="eliminar('<?= $empresa['idempresa'] ?>')"> <i class="fa fa-trash"> </i> </button>
                          </td>
                        <?php } ?>
                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>Razon Social</th>
                    <th>Rut</th>

                    <?php if ($_SESSION['admin']) { ?>
                      <th>Acciones</th>
                    <?php } ?>
                  </tfoot>
                </table>
              </div>

              <!-- Formulario Ingreso -->
              <div class="panel-body" style="height:280px; display: none;" id="formularioregistro">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Razon Social:</label>
                    <input type="hidden" name="idempresa" id="idempresa">
                    <input required type="text" class="form-control" name="razonsocial" id="razonsocial" maxlength="50" placeholder="Digite razon social" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Rut:</label>
                    <input required type="text" class="form-control" name="rut" id="rut" maxlength="256" placeholder="Digite RUT">
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
            <label>Razon Social:</label>
            <input type="hidden" id="form_id" name="form_id">
            <input required type="text" class="form-control" id="form_razonsocial" name="razonsocial" maxlength="50" placeholder="Digite razon social" required>
          </div>
          <div class="form-group ">
            <label>Rut:</label>
            <input required type="text" class="form-control" id="form_rut" name="rut" maxlength="256" placeholder="Digite RUT">
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
      url: 'ajax/empresa.php?op=mostrar',
      type: 'post',
      data: {
        idempresa: id
      },
      success: function(data) {
        if (typeof data.idempresa != undefined) {
          $('#form_id').val(data.idempresa);
          $('#form_razonsocial').val(data.razonsocial);
          $('#form_rut').val(data.rut);
          $('#editar').modal('show');
        }
      }
    });
  }

  function eliminar(id) {
    $.ajax({
      url: 'ajax/empresa/eliminar.php',
      type: 'post',
      data: {
        id: id
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