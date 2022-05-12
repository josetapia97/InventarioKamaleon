<?php
require 'modelos/Contrato.php';
require 'modelos/Empresa.php';
require 'modelos/Articulo.php';
require 'modelos/Usuariofinal.php';

$contratoOBJ = new Contrato();

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
    $contratos = $contratoOBJ->repContratos();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Reporte de Contratos
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->


              <div class="panel-body table-responsive " style="padding: 10px 30px;" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>ID Contrato</th>
                    <th>Empresa</th>
                    <th>Articulo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>F Inicio</th>
                    <th>F Termino</th>
                    <th>Valor</th>
                    <th>Estado</th>


                  </thead>
                  <tbody>
                    <?php foreach ($contratos as $contrato) : ?>
                      <tr>
                        <td><?php echo $contrato['idcontrato'] ?></td>
                        <td><?php echo $contrato['razonsocial'] ?></td>
                        <td><?php echo $contrato['articulo'] ?></td>
                        <td><?php echo $contrato['nombre'] ?></td>
                        <td><?php echo $contrato['apellido'] ?></td>
                        <td><?php echo $contrato['fechainicio'] ?></td>
                        <td><?php echo $contrato['fechatermino'] ?></td>
                        <td><?php echo $contrato['valor'] ?></td>
                        <td><?php echo $contrato['vigente'] ?></td>
                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>ID Empresa</th>
                    <th>Empresa</th>
                    <th>Articulo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>F Inicio</th>
                    <th>F Termino</th>
                    <th>Valor</th>
                    <th>Estado</th>

                  </tfoot>
                </table>
              </div>

             

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

<script>
  $(function() {
  tabla = $("#tbllistado").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend :'excel',
        exportOptions: {
          columns: [ 0, 1, 2,3,4,5,6,7,8]
        }
      }
      
    ]
  });
});

</script>


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

?>