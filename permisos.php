<?php
require 'modelos/Usuario.php';



$usuarioOBJ = new Usuario();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $idempresa = $_POST['idempresa'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $correo = $_POST['correo'];
  $pass = $_POST['pass'];
  $form_id = $_POST['form_id'];

  if (empty($form_id)) {
    $usuarioOBJ->insertar($idempresa, $nombre, $apellido, $correo, $pass);
  } else {
    $usuarioOBJ->editar($idusuario, $idempresa, $nombre, $apellido, $correo, $pass);
  }

  header("Location: permisos.php");
  exit();
}

require_once 'header.php'
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <?php require_once 'topbar.php' ?>

    <!-- Begin Page Content -->





    <!-- Content Wrapper. Contains page content -->
    <?php
    $usuarios = $usuarioOBJ->listar();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Permisos de usuario
                  <a class="btn btn-success" href="usuarios.php"> Agregar</a>
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->


              <div class="panel-body table-responsive " style="padding: 10px 30px;" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <!--Filtro si el usuario esta activo--->
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Empresa</th>
                    <th>Permisos</th>


                  </thead>
                  <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                      <tr>
                        <td><?php echo $usuario['nombre'] ?></td>
                        <td><?php echo $usuario['apellido'] ?></td>
                        <td><?php echo $usuario['idempresa'] ?></td>
                        <!--Nombre de la empresa -->


                        <td class="notexport" >
                        <input class="chkToggle2" data-id="<?= $usuario['idusuario'] ?>" type="checkbox" <?= ($usuario["esadmin"] == 1 ? "checked" : "")  ?>>
                        </td>

                        

                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Empresa</th>
                    <th>Permisos</th>

                  </tfoot>
                </table>
              </div>

              <!-- Formulario Ingreso -->
              
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
  
  
  $(document).ready(function() {
    $('.chkToggle2').bootstrapToggle({
      on: "Admin",
      off: "Observer",
      onstyle: "success",
      offstyle: "danger"
    })

    $('.chkToggle2').on("change", function() {
      $(this).bootstrapToggle("disable")

      estado = $(this).prop("checked") ? 1 : 0;
      selected = $(this)
      if (estado == 1) {
        $.ajax({
          url: "./ajax/usuario.php?op=haceradmin",
          method: "POST",
          data: {
            idusuario: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      } else {
        $.ajax({
          url: "./ajax/usuario.php?op=quitaradmin",
          method: "POST",
          data: {
            idusuario: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      }

    })


  })
  
</script>

<?php
require "scripts.php";
?>