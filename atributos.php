<?php
require 'modelos/Atributos.php';
require 'modelos/Caracteristica.php';
require 'modelos/Articulo.php';

$atributoOBJ = new Atributos();
$caracteristicaOBJ = new Caracteristica();
$articuloOBJ = new Articulo();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $form_id = $_POST['idatributos'];
  $idcaracteristica = $_POST['idcaracteristica'];
  $idarticulo = $_POST['idarticulo'];
  $valor = $_POST['valor'];

  if (empty($form_id)) {
    $atributoOBJ->insertar($idcaracteristica, $idarticulo, $valor);
  } else {
    $atributoOBJ->editar($form_id, $idcaracteristica, $idarticulo, $valor);
  }

  header("Location: atributos.php");
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
    $atributos = $atributoOBJ->listar();
    $caracteristicas = $caracteristicaOBJ->listar();
    $articulos = $articuloOBJ->listar();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Atributos por Articulo
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
                    <th>Articulo</th>
                    <th>Caraceristica</th>
                    <th>Valor</th>
                    <th>Acciones</th>

                  </thead>
                  <tbody>
                    <?php foreach ($atributos as $atributo) : ?>
                      <tr>
                        <td><?php echo $atributo['idarticulo'] ?></td>
                        <!--Nombre de la empresa -->
                        <td><?php echo $atributo['idcaracteristica'] ?></td>
                        <td><?php echo $atributo['valor'] ?></td>
                        <td class="notexport">
                          <button class="btn btn-warning" onclick="form_editar('<?= $atributo['idatributos'] ?>')"> <i class="fa fa-pencil-alt"></i> </button>
                          <button class="btn btn-danger" onclick="eliminar('<?= $atributo['idatributos'] ?>')"> <i class="fa fa-trash"> </i> </button>
                          <!--Se puede cambiar por un toggle? -->
                          
                        </td>

                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <th>Articulo</th>
                    <th>Caraceristica</th>
                    <th>Valor</th>
                    <th>Acciones</th>
                  </tfoot>
                </table>
              </div>

              <!-- Formulario Ingreso -->
              <div class="panel-body" style="height:280px; display: none;" id="formularioregistro">
                <form name="formulario" id="formulariof" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Articulo:</label>
                    <select required name="idarticulo" id="idarticulo" class="form-control">
                      <?php foreach ($articulos as $articulo) : ?>
                        <option value="<?php echo $articulo['idarticulo'] ?>"> <?php echo $articulo['nombre'] ?> </option>
                      <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="idatributos" id="idatributos">    
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Caracteristica:</label>
                    <select required name="idcaracteristica" id="idcaracteristica" class="form-control">
                      <?php foreach ($caracteristicas as $caracteristica) : ?>
                        <option value="<?php echo $caracteristica['idcaracteristica'] ?>"> <?php echo $caracteristica['nombre'] ?> </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Valor:</label>
                    <input required type="text" class="form-control" name="valor" id="valor" maxlength="256" placeholder="Ingrese el valor de la caracteristica">
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
        <h5 class="modal-title" id="exampleModalLabel">Editar caracteristica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formulario" id="formulario" method="POST">
          <div class="form-group ">
            <label>Articulo:</label>
            <select require id="form_idarticulo" name="idarticulo" class="form-control">
                <?php foreach ($articulos as $articulo) : ?>
                  <option value="<?php echo $articulo['idarticulo'] ?>"> <?php echo $articulo['nombre'] ?> </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" id="form_id" name="idatributos">
            
          </div>
          <div class="form-group ">
            <label>Caracteristica:</label>
            <select require id="form_idcaracteristica" name="idcaracteristica" class="form-control">
                <?php foreach ($caracteristicas as $caracteristica) : ?>
                    <option value="<?php echo $caracteristica['idcaracteristica'] ?>"> <?php echo $caracteristica['nombre'] ?> </option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group ">
            <label>Valor:</label>
            <input type="text" class="form-control" id="form_valor" name="valor" maxlength="256" placeholder="Ingrese el valor">
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
  function form_editar(id) {
    $.ajax({
      url: 'ajax/atributos.php?op=mostrar',
      type: 'post',
      data: {
        idatributos: id
      },
      success: function(data) {
        data = JSON.parse(data)
        if (typeof data.idatributos != undefined) {
          console.log(data)
          $('#form_id').val(data.idatributos);
          $('#form_idarticulo').val(data.idarticulo);
          $('#form_idcaracteristica').val(data.idcaracteristica);
          $('#form_valor').val(data.valor);
          $('#editar').modal('show');
        }
      }
    });
  }

  function eliminar(id) {
    $.ajax({
      url: 'ajax/atributos.php?op=eliminar',
      type: 'post',
      data: {
        idatributos: id
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