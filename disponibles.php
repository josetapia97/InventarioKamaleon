<?php
require 'modelos/Contrato.php';

$contratoOBJ = new Contrato();


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
    $contratos = $contratoOBJ->articdisponibles();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Articulos Disponibles
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
                    <th>Categoria</th>
                    <th>ID Articulo</th>
                    <th>Articulo</th>
                    

                  </thead>
                  <tbody>
                    <?php foreach ($contratos as $contrato) : ?>
                      <tr>
                        <td><?php echo $contrato['razonsocial'] ?></td>
                        <td><?php echo $contrato['categoria'] ?></td>
                        <td><?php echo $contrato['idarticulo'] ?></td>
                        <td><?php echo $contrato['articulo'] ?></td>
                    
                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>Empresa</th>
                    <th>Categoria</th>
                    <th>ID Articulo</th>
                    <th>Articulo</th>
                    
                  </tfoot>
                </table>
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

<script>
  $(function() {
  tabla = $("#tbllistado").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend :'excel',
        exportOptions: {
          columns: [ 0, 1, 2,3]
        }
      }
      
    ]
  });
});
</script>

<?php
require "scripts.php";
?>