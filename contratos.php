<?php
require 'modelos/Contrato.php';
require 'modelos/Empresa.php';
require 'modelos/Articulo.php';
require 'modelos/Usuariofinal.php';

$contratoOBJ = new Contrato();
$empresaOBJ = new Empresa();
$articuloOBJ = new Articulo();
$trabajadorOBJ = new Usuariofinal();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $idarticulo = $_POST['idarticulo'];
  $idusuariofinal = $_POST['idusuariofinal'];
  $idempresa = $_POST['idempresa'];
  $valorarticulo = $_POST['valorarticulo'];
  $form_id = $_POST['idcontrato'];

  if (empty($form_id)) {
    $contratoOBJ->insertar($idarticulo, $idusuariofinal, $idempresa, $valorarticulo);
  } else {
    $vigente = $_POST['vigente'];
    $fechainicio = $_POST['fechainicio'];
    $fechatermino = $_POST['fechatermino'];
    $contratoOBJ->editar($form_id,$idarticulo, $idusuariofinal, $idempresa,$fechainicio,$fechatermino, $valorarticulo);
  }
  header("Location: contratos.php");
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
    $contratos = $contratoOBJ->listar();
    $empresas = $empresaOBJ->listar();
    $articulos = $articuloOBJ->listar();
    $trabajadores = $trabajadorOBJ->listar();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Contratos
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
                    <th>Empresa</th>
                    <th>Articulo</th>
                    <th>Trabajador</th>
                    <th>F Inicio</th>
                    <th>F Termino</th>
                    <th>Valor</th>
                    <th>Estado</th>
                    <?php if ($_SESSION['admin']) { ?>
                    <th>Acciones</th>
                    <?php } ?>


                  </thead>
                  <tbody>
                    <?php foreach ($contratos as $contrato) : ?>
                      <tr>
                        <td><?php echo $contrato['idempresa'] ?></td>
                        <!--Nombre de la empresa -->
                        <td><?php echo $contrato['idarticulo'] ?></td>
                        <td><?php echo $contrato['idusuariofinal'] ?></td>
                        <td><?php echo $contrato['fechainicio'] ?></td>
                        <td><?php 
                         $ft=$contrato['fechatermino'];
                        if ($ft!="0000-00-00"){
                        echo $contrato['fechatermino'];} ?></td>
                        <td><?php echo $contrato['valorarticulo'] ?></td>
                        <?php if ($_SESSION['admin']) { ?>
                        <td><input class="chkToggle2" data-id="<?= $contrato['idcontrato'] ?>" type="checkbox" <?= ($contrato["vigente"] == 1 ? "checked" : "")  ?>></td>
                        <?php }else{?>
                          <td><?php echo $contrato['vigente'] ?></td>
                        <?php } ?>
                        <?php if ($_SESSION['admin']) { ?>
                        <td class="notexport">
                          <button class="btn btn-warning" onclick="form_editar('<?= $contrato['idcontrato'] ?>')"> <i class="fa fa-pencil-alt"></i> </button>
                          <!--Se puede cambiar por un toggle? -->
                        </td>
                        <?php } ?>
                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>Empresa</th>
                    <th>Articulo</th>
                    <th>Trabajador</th>
                    <th>F Inicio</th>
                    <th>F Termino</th>
                    <th>Valor</th>
                    <th>Estado</th>
                    <?php if ($_SESSION['admin']) { ?>
                    <th>Acciones</th>
                    <?php } ?>
                  </tfoot>
                </table>
              </div>

              <!-- Formulario Ingreso -->
              <div class="panel-body" style="height:280px; display: none;" id="formularioregistro">
                <form name="formulario" id="formulariof" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Empresa:</label>
                    <input type="hidden" name="idcontrato" id="idcontrato">
                     <!---Lista de empresas--->
                    <select required name="idempresa" id="idempresa" class="form-control">
                      <?php foreach ($empresas as $empresa) : ?>
                        <option value="<?php echo $empresa['idempresa'] ?>"> <?php echo $empresa['razonsocial'] ?> </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <!---que solo muestre los articulos ACTIVOS Y NO ARRENDADOS-->
                    <label>Articulo:</label>
                    <select required name="idarticulo" id="idarticulo" class="form-control">
                      <?php foreach ($articulos as $articulo) : 
                          $AAct=$articulo['activo'];
                          $AArr=$articulo['arrendado'];
                          if($AAct == 1 and $AArr == 0 ){
                        ?>
                        <option value="<?php echo $articulo['idarticulo'] ?>"> <?php echo $articulo['nombre'];}?> </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Trabajador:</label>
                    <!--trabajadores activos--->
                    <select required name="idusuariofinal" id="idusuariofinal" class="form-control">
                      <?php foreach ($trabajadores as $trabajador) : 
                        $TAct=$trabajador['activo'];
                        if($TAct ==1 ){
                        ?>
                        <option value="<?php echo $trabajador['idusuariofinal'] ?>"> <?php echo $trabajador['nombre'] . " ". $trabajador['apellido'];} ?> </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Valor:</label>
                    <input required type="int" class="form-control" name="valorarticulo" id="valorarticulo" maxlength="256" placeholder="Ingrese valor">
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
        <h5 class="modal-title" id="exampleModalLabel">Editar Contrato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formulario" id="formulario" method="POST">
          <div class="form-group ">
            <label>Empresa:</label>
            <input type="hidden" id="form_id" name="idcontrato">
            <select required id="form_idempresa" name="idempresa" class="form-control">
                      <?php foreach ($empresas as $empresa) : ?>
                        <option value="<?php echo $empresa['idempresa'] ?>"> <?php echo $empresa['razonsocial'] ?> </option>
                      <?php endforeach; ?>
                    </select>
          </div>
          <div class="form-group ">
            <label>Articulo:</label>
            <!---Solo articulos disponibles y no arrendados--->
            <select disabled id="form_idarticulo" name="idarticulo" class="form-control">
                  <?php foreach ($articulos as $articulo) : ?>
                    <option value="<?php echo $articulo['idarticulo'] ?>"> <?php echo $articulo['nombre']?> </option>
                   <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group ">
            <label>Trabajador:</label>
            <!--Trabajadores activos--->
            <select required id="form_idusuariofinal" name="idusuariofinal" class="form-control">
                <?php foreach ($trabajadores as $trabajador) : 
                  $TAct=$trabajador['activo'];
                  if($TAct==1){?>
                  <option value="<?php echo $trabajador['idusuariofinal'] ?>"> <?php echo $trabajador['nombre'] . " ". $trabajador['apellido'];} ?> </option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group ">
            <label>Fecha de inicio:</label>
            <input required type="date" class="form-control" id="form_fechainicio" name="fechainicio" maxlength="256" placeholder="Fecha de inicio del contrato">
          </div>
          <div class="form-group ">
            <label>Fecha de termino:</label>
            <input type="date" class="form-control" id="form_fechatermino" name="fechatermino" maxlength="256" placeholder="Seleccione fecha de termino">
          </div>
          <div class="form-group ">
            <label>Valor:</label>
            <input required type="int" class="form-control" id="form_valorarticulo" name="valorarticulo" maxlength="256" placeholder="Digite valor">
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
      on: "Vigente",
      off: "No vigente",
      onstyle: "success",
      offstyle: "danger"
    })

    $('.chkToggle2').on("change", function() {
      $(this).bootstrapToggle("disable")

      estado = $(this).prop("checked") ? 1 : 0;
      selected = $(this)
      if (estado == 1) {
        $.ajax({
          url: "./ajax/contrato.php?op=activar",
          method: "POST",
          data: {
            idcontrato: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      } else {
        $.ajax({
          url: "./ajax/contrato.php?op=finalizarcontrato",
          method: "POST",
          data: {
            idcontrato: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      }
      document.location.reload();

    })

    /**
     * $.ajax({
          url: "./ajax/contrato.php",
          method: "POST",
          data: {
            op: 'finalizarcontrato'
            idcontrato: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      }
      document.location.reload();

    })
     */


  })
</script>

<script>
  function form_editar(id) {
    $.ajax({
      url: 'ajax/contrato.php?op=mostrar',
      type: 'post',
      data: {
        idcontrato: id
      },
      success: function(data) {
        data = JSON.parse(data)
        if (typeof data.idcontrato != undefined) {
          console.log(data)
          $('#form_id').val(data.idcontrato);
          $('#form_idarticulo').val(data.idarticulo);
          $('#form_idusuariofinal').val(data.idusuariofinal);
          $('#form_idempresa').val(data.idempresa);
          $('#form_fechainicio').val(data.fechainicio);
          $('#form_fechatermino').val(data.fechatermino);
          $('#form_valorarticulo').val(data.valorarticulo);
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

  function form_cambiarfecha(id) {
    $.ajax({
      url: 'ajax/contrato.php?op=mostrar',
      type: 'post',
      data: {
        idcontrato: id
      },
      success: function(data) {
        data = JSON.parse(data)
        if (typeof data.idcontrato != undefined) {
          console.log(data)
          $('#form_id').val(data.idcontrato);
          $('#form_fechainicio').val(data.fechainicio);
          $('#form_fechatermino').val(data.fechatermino);
          $('#editarfecha').modal('show');
        }
      }
    });
  }
</script>

<?php
require "scripts.php";
?>