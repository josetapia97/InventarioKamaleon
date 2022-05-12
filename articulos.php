<?php
require 'modelos/Articulo.php';
require 'modelos/Categoria.php';
require 'modelos/Empresa.php';

$articuloOBJ = new Articulo();
$categoriaOBJ = new Categoria();
$empresaOBJ = new Empresa();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $idcategoria = $_POST['idcategoria'];
  $idempresa = $_POST['idempresa'];
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $imagen = $_POST['imagen'];
  $condicion = $_POST['condicion'];
  $activo = $_POST['activo'];
  $arrendado= $_POST['arrendado'];
  $form_id = $_POST['idarticulo'];

  if (empty($form_id)) {
    $articuloOBJ->insertar($idcategoria, $idempresa, $codigo, $nombre);
  } else {
    $articuloOBJ->editar($form_id,$idcategoria, $idempresa, $codigo, $nombre,$imagen);
  }

  header("Location: articulos.php");
  var_dump($_POST);
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
    $articulos = $articuloOBJ->listar();
    $categorias = $categoriaOBJ ->listar();
    $empresas = $empresaOBJ ->listar();
    ?>



    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Articulos
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
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Empresa</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Condicion</th>
                    <th>Activo</th>
                    <th>Arrendado</th>
                    <th>Acciones</th>

                  </thead>
                  <tbody>
                    <?php foreach ($articulos as $articulo) : ?>
                      <tr>
                        <td><?php echo $articulo['idarticulo'] ?></td>
                        <!--Nombre de la empresa -->
                        <td><?php echo $articulo['idcategoria'] ?></td>
                        <td><?php echo $articulo['idempresa'] ?></td>
                        <td><?php echo $articulo['codigo'] ?></td>
                        <td><?php echo $articulo['nombre'] ?></td>
                        <td><input class="chkToggle2 tgcond" data-id="<?= $articulo['idarticulo'] ?>" type="checkbox" <?= ($articulo["condicion"] == 1 ? "checked" : "")  ?>></td>
                        <td><input class="chkToggle2 tgact" data-id="<?= $articulo['idarticulo'] ?>" type="checkbox" <?= ($articulo["activo"] == 1 ? "checked" : "")  ?>></td>
                        <td><input class="chkToggle2 tgarr" disabled data-id="<?= $articulo['idarticulo'] ?>" type="checkbox" <?= ($articulo["arrendado"] == 1 ? "checked" : "")  ?>></td>

                        <td class="notexport">
                          <button class="btn btn-warning" onclick="form_editar('<?= $articulo['idarticulo'] ?>')"> <i class="fa fa-pencil-alt"></i> </button>
                          <!--Se puede cambiar por un toggle? -->
                          
                        </td>

                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                  <th>ID</th>
                    <th>Categoria</th>
                    <th>Empresa</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Condicion</th>
                    <th>Activo</th>
                    <th>Arrendado</th>
                    <th>Acciones</th>
                  </tfoot>
                </table>
              </div>

              <!-- Formulario Ingreso -->
              <div class="panel-body" style="height:280px; display: none;" id="formularioregistro">
                <form name="formulario" id="formulariof" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <label>Categoria:</label>
                    <select required name="idcategoria" id="idcategoria" class="form-control">
                      <?php foreach ($categorias as $categoria) : ?>
                        <option value="<?php echo $categoria['idcategoria'] ?>"> <?php echo $categoria['nombre'] ?> </option>
                      <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="idarticulo" id="idarticulo">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Empresa:</label>
                    <select required name="idempresa" id="idempresa" class="form-control">
                      <?php foreach ($empresas as $empresa) : ?>
                        <option value="<?php echo $empresa['idempresa'] ?>"> <?php echo $empresa['razonsocial'] ?> </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Codigo:</label>
                    <input required type="text" class="form-control" name="codigo" id="codigo" maxlength="256" placeholder="Ingrese codigo del articulo">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre:</label>
                    <input required type="text" class="form-control" name="nombre" id="nombre" maxlength="256" placeholder="Ingrese nombre del articulo">
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
        <h5 class="modal-title" id="exampleModalLabel">Editar articulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formulario" id="formulario" method="POST">
          <div class="form-group ">
            <label>Categoria:</label>
            <select required id="form_idcategoria" name="idcategoria" class="form-control">
                  <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?php echo $categoria['idcategoria'] ?>"> <?php echo $categoria['nombre'] ?> </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" id="form_id" name="idarticulo">
          </div>
          <div class="form-group ">
            <label>Empresa:</label>
            <select required id="form_idempresa" name="idempresa" class="form-control">
                  <?php foreach ($empresas as $empresa) : ?>
                    <option value="<?php echo $empresa['idempresa'] ?>"> <?php echo $empresa['razonsocial'] ?> </option>
                  <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group ">
            <label>Codigo:</label>
            <input required type="text" class="form-control" id="form_codigo" name="codigo" maxlength="256" placeholder="Digite el codigo">
          </div>
          <div class="form-group ">
            <label>Nombre:</label>
            <input required type="text" class="form-control" id="form_nombre" name="nombre" maxlength="256" placeholder="Digite nombre">
          </div>
          <div class="form-group ">
            <label>Imagen:</label>
            <input type="text" class="form-control" id="form_imagen" name="imagen" maxlength="256" placeholder="Puede agregar URL de imagen (opcional)">
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
    $('.tgact').bootstrapToggle({
      on: "Activo",
      off: "No activo",
      onstyle: "success",
      offstyle: "danger"
    })

    
    $('.tgcond').bootstrapToggle({
      on: "Nuevo",
      off: "Usado",
      onstyle: "success",
      offstyle: "danger"
    })

    
    $('.tgarr').bootstrapToggle({
      on: "Arrendado",
      off: "Disponible",
      onstyle: "danger",
      offstyle: "success"
    })

    $('.tgact').on("change", function() {
      $(this).bootstrapToggle("disable")

      estado = $(this).prop("checked") ? 1 : 0;
      selected = $(this)
      if (estado == 1) {
        $.ajax({
          url: "./ajax/articulo.php?op=activar",
          method: "POST",
          data: {
            idarticulo: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      } else {
        $.ajax({
          url: "./ajax/articulo.php?op=desactivar",
          method: "POST",
          data: {
            idarticulo: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      }

    })

    

    $('.tgcond').on("change", function() {
      $(this).bootstrapToggle("disable")

      estado = $(this).prop("checked") ? 1 : 0;
      selected = $(this)
      if (estado == 1) {
        $.ajax({
          url: "./ajax/articulo.php?op=cambiaranuevo",
          method: "POST",
          data: {
            idarticulo: selected.data("id")
          },
          success: function(respuesta) {
            selected.bootstrapToggle("enable")
          }
        })
      } else {
        $.ajax({
          url: "./ajax/articulo.php?op=cambiarausado",
          method: "POST",
          data: {
            idarticulo: selected.data("id")
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
      url: 'ajax/articulo.php?op=mostrar',
      type: 'post',
      data: {
        idarticulo: id
      },
      success: function(data) {
        data = JSON.parse(data)
        if (typeof data.idusuario != undefined) {
          console.log(data)
          $('#form_id').val(data.idarticulo);
          $('#form_idcategoria').val(data.idcategoria);
          $('#form_idempresa').val(data.idempresa);
          $('#form_codigo').val(data.codigo);
          $('#form_nombre').val(data.nombre);
          $('#form_imagen').val(data.imagen);
          $('#editar').modal('show');
        }
      }
    });
  }

  function activar(id) {
    $.ajax({
      url: 'ajax/articulo.php?op=activar',
      type: 'post',
      data: {
        idarticulo: id
      },
      success: function(data) {
        alert('activado');
        document.location.reload();
      }
    });
  }

  function desactivar(id) {
    $.ajax({
      url: 'ajax/articulo.php?op=desactivar',
      type: 'post',
      data: {
        idarticulo: id
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