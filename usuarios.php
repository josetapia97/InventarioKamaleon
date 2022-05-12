<?php
require 'modelos/Usuario.php';
require 'modelos/Empresa.php';

$usuarioOBJ = new Usuario();
$empresaOBJ = new Empresa();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $idempresa = $_POST['idempresa'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $correo = $_POST['correo'];
  $pass = md5($_POST['pass']);
  $form_id = $_POST['idusuario'];

  if (empty($form_id)) {
    $usuarioOBJ->insertar($idempresa, $nombre, $apellido, $correo, $pass);
  } else {
    $usuarioOBJ->editar($form_id, $idempresa, $nombre, $apellido, $correo,$pass);
  }

  header("Location: usuarios.php");
  exit();
}

require_once 'header.php';

$empresas = $empresaOBJ->listar();
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
                <h1 class="box-title">Usuarios
                <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->


              <div class="panel-body table-responsive " style="padding: 10px 30px;" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Empresa</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                  </thead>
                  <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                      <tr>
                        <td><?php echo $usuario['idempresa'] ?></td>
                        <!--Nombre de la empresa -->
                        <td><?php echo $usuario['nombre'] ?></td>
                        <td><?php echo $usuario['apellido'] ?></td>
                        <td><?php echo $usuario['correo'] ?></td>
                        <td><?php echo $usuario['pass'] ?></td>
                        <td><input class="chkToggle2" data-id="<?= $usuario['idusuario'] ?>" type="checkbox" <?= ($usuario["activo"] == 1 ? "checked" : "")  ?>></td>
                        <td class="notexport">
                          <button class="btn btn-warning" onclick="form_editar('<?= $usuario['idusuario'] ?>')"> <i class="fa fa-pencil-alt"></i> </button>
                          <!--Se puede cambiar por un toggle? -->

                        </td>

                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>Empresa</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tfoot>
                </table>
              </div>

              <!-- Formulario Ingreso -->
              <div class="panel-body" style="height:280px; display: none;" id="formularioregistro">
                <form name="formulario" id="formulariof" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <label>Empresa:</label>
                    <select required name="idempresa" id="idempresa" class="form-control">
                      <?php foreach ($empresas as $empresa) : ?>
                        <option value="<?php echo $empresa['idempresa'] ?>"> <?php echo $empresa['razonsocial'] ?> </option>
                      <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="idusuario" id="idusuario">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre:</label>
                    <input required type="text" class="form-control" name="nombre" id="nombre" maxlength="256" placeholder="Ingrese su nombre">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Apellido:</label>
                    <input required type="text" class="form-control" name="apellido" id="apellido" maxlength="256" placeholder="Ingrese su apellido">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Correo:</label>
                    <input required type="email" class="form-control" name="correo" id="correo" maxlength="256" placeholder="Ingrese su correo">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Contraseña:</label>
                    <input required type="password" class="form-control" name="pass" id="pass" maxlength="256" placeholder="Ingrese su contraseña">
                  </div>
                  <!--confirmar-->

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
        <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formulario" id="formulario" method="POST">
          <div class="form-group ">
            <label>Empresa:</label>     
            <select required id="form_idempresa" name="idempresa" class="form-control">
                <?php foreach ($empresas as $empresa) : ?>
                  <option value="<?php echo $empresa['idempresa'] ?>"> <?php echo $empresa['razonsocial'] ?> </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" id="form_id" name="idusuario">
          </div>
          <div class="form-group ">
            <label>Nombre:</label>
            <input required type="text" class="form-control" id="form_nombre" name="nombre" maxlength="256" placeholder="Digite nombre">
          </div>
          <div class="form-group ">
            <label>Apellido:</label>
            <input required type="text" class="form-control" id="form_apellido" name="apellido" maxlength="256" placeholder="Digite apellido">
          </div>
          <div class="form-group ">
            <label>Correo:</label>
            <input required type="email" class="form-control" id="form_correo" name="correo" maxlength="256" placeholder="Digite correo">
          </div>
          <div class="form-group ">
            <label>Contraseña:</label>
            <input required type="password" class="form-control" id="form_pass" name="pass" maxlength="256" placeholder="Digite nueva contraseña">
          </div>
          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <button class="btn btn-primary float-right" type="submit" id="btnGuardar2"><i class="fa fa-save"></i> Guardar</button>
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
  $(document).ready(function() {
    $('.chkToggle2').bootstrapToggle({
      on: "Activo",
      off: "No activo",
      onstyle: "success",
      offstyle: "danger"
    })

    $('.chkToggle2').on("change", function() {
      $(this).bootstrapToggle("disable")

      estado = $(this).prop("checked") ? 1 : 0;
      selected = $(this)
      if (estado == 1) {
        $.ajax({
          url: "./ajax/usuario.php?op=activar",
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
          url: "./ajax/usuario.php?op=desactivar",
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

<script>
  function form_editar(id) {
    $.ajax({
      url: 'ajax/usuario.php?op=mostrar',
      type: 'post',
      data: {
        idusuario: id
      },
      success: function(data) {
        data = JSON.parse(data)
        if (typeof data.idusuario != undefined) {
          console.log(data)
          $('#form_id').val(data.idusuario);
          $('#form_idempresa').val(data.idempresa);
          $('#form_nombre').val(data.nombre);
          $('#form_apellido').val(data.apellido);
          $('#form_correo').val(data.correo);
          $('#form_pass').val(data.pass);
          $('#editar').modal('show');
        }
      }
    });
  }

  function activar(id) {
    $.ajax({
      url: 'ajax/usuario.php?op=activar',
      type: 'post',
      data: {
        id: id
      },
      success: function(data) {
        alert('activado');
        document.location.reload();
      }
    });
  }

  function desactivar(id) {
    $.ajax({
      url: 'ajax/usuario.php?op=desactivar',
      type: 'post',
      data: {
        id: id
      },
      success: function(data) {
        alert('desactivado');
        document.location.reload();
      }
    });
  }
</script>

<?php
require "scripts.php";
?>