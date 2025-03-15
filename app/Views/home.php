<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos y Grupos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center">Gestión de Productos y Grupos</h2>
        
        <!-- Tabs para Productos y Grupos -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="productos-tab" data-bs-toggle="tab" data-bs-target="#productos" type="button">Productos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="grupos-tab" data-bs-toggle="tab" data-bs-target="#grupos" type="button">Grupos</button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">
            <!-- Sección de Productos -->
            <div class="tab-pane fade show active" id="productos">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productoModal">Agregar Producto</button>
                <div id="productos-list"></div>
            </div>

            <!-- Sección de Grupos -->
            <div class="tab-pane fade" id="grupos">
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#grupoModal">Agregar Grupo</button>
                <div id="grupos-list"></div>
            </div>
        </div>
    </div>

    <!-- Modal para Producto -->
    <div class="modal fade" id="productoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="producto-form">
                        <input type="hidden" id="producto-id">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" id="producto-nombre" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Descripción</label>
                            <input type="text" id="producto-descripcion" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Precio</label>
                            <input type="number" id="producto-precio" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Stock</label>
                            <input type="number" id="producto-stock" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Grupo -->
    <div class="modal fade" id="grupoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="grupo-form">
                        <input type="hidden" id="grupo-id">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" id="grupo-nombre" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Descripción</label>
                            <input type="text" id="grupo-descripcion" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function cargarProductos() {
                $.ajax({
                    url: '<?php echo BASE_PATH ?>/productos',
                    method: 'GET',
                    success: function(response) {
                        $('#productos-list').html(response);
                    }
                });
            }
            function cargarGrupos() {
                $.ajax({
                    url: '<?php echo BASE_PATH ?>/grupos',
                    method: 'GET',
                    success: function(response) {
                        $('#grupos-list').html(response);
                    }
                });
            }
            cargarProductos();
            cargarGrupos();

            function LimpiarInputs(){
                $('#producto-nombre').val('');
                $('#producto-descripcion').val('');
                $('#producto-precio').val('');
                $('#producto-stock').val(''); 
            }

            function LimpiarInputsGrupo() {
                $('#grupo-id').val('');
                $('#grupo-nombre').val('');
                $('#grupo-descripcion').val('');
            }

            $('#producto-form').submit(function(event) {
                event.preventDefault(); // Evitar el envío tradicional del formulario

                // Obtener los valores de los campos
                let id = $('#producto-id').val();
                let nombre = $('#producto-nombre').val().trim();
                let descripcion = $('#producto-descripcion').val().trim();
                let precio = parseFloat($('#producto-precio').val());
                let stock = parseInt($('#producto-stock').val());

                if (!nombre) {
                    alert("El nombre del producto es obligatorio.");
                    return;
                }

                if (!descripcion) {
                    alert("La descripción del producto es obligatoria.");
                    return;
                }

                if (isNaN(precio) || precio <= 0) {
                    alert("El precio debe ser un número mayor que 0.");
                    return;
                }

                if (isNaN(stock) || stock < 0) {
                    alert("El stock debe ser un número mayor o igual a 0.");
                    return;
                }

                // Si todas las validaciones pasan, preparar los datos para enviar
                let datos = {
                    id: id,
                    nombre: nombre,
                    descripcion: descripcion,
                    precio: precio,
                    stock: stock
                };

                // Enviar la solicitud AJAX
                $.ajax({
                    url: '<?php echo BASE_PATH ?>/productos/crear',
                    method: 'POST',
                    data: datos,
                    success: function(response) {
                        // Ocultar el modal
                        $('#productoModal').modal('hide');

                        // Recargar la lista de productos
                        cargarProductos();

                        // Limpiar los campos del formulario
                        LimpiarInputs();

                        // Mostrar un mensaje de éxito
                        alert("Producto creado con éxito.");
                    },
                    error: function(xhr, status, error) {
                        // Mostrar un mensaje de error
                        alert("Error al crear el producto: " + error);
                    }
                });
            });

            $('#grupo-form').submit(function(event) {
                event.preventDefault(); // Evitar el envío tradicional del formulario

                // Obtener los valores de los campos
                let id = $('#grupo-id').val();
                let nombre = $('#grupo-nombre').val().trim();
                let descripcion = $('#grupo-descripcion').val().trim();

                // Validar los campos
                if (!nombre) {
                    alert("El nombre del grupo es obligatorio.");
                    return;
                }

                if (!descripcion) {
                    alert("La descripción del grupo es obligatoria.");
                    return;
                }

                // Si todas las validaciones pasan, preparar los datos para enviar
                let datos = {
                    id: id,
                    nombre: nombre,
                    descripcion: descripcion
                };

                // Enviar la solicitud AJAX
                $.ajax({
                    url: '<?php echo BASE_PATH ?>/grupos/crear',
                    method: 'POST',
                    data: datos,
                    success: function(response) {
                        // Ocultar el modal
                        $('#grupoModal').modal('hide');

                        // Recargar la lista de grupos
                        cargarGrupos();

                        // Limpiar los campos del formulario
                        LimpiarInputsGrupo();

                        // Mostrar un mensaje de éxito
                        alert("Grupo creado con éxito.");
                    },
                    error: function(xhr, status, error) {
                        // Mostrar un mensaje de error
                        alert("Error al crear el grupo: " + error);
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>







<!--
<form id="form-crear-producto">
    <input type="text" id="nombre" placeholder="Nombre" required>
    <textarea id="descripcion" placeholder="Descripción"></textarea>
    <input type="number" id="precio" placeholder="Precio" required>
    <input type="number" id="stock" placeholder="Stock" required>
    <select id="estado">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select>
    <button type="submit">Crear Producto</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#form-crear-producto').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'app/controllers/ProductoController.php',
            method: 'POST',
            data: {
                nombre: $('#nombre').val(),
                descripcion: $('#descripcion').val(),
                precio: $('#precio').val(),
                stock: $('#stock').val(),
                estado: $('#estado').val()
            },
            success: function(response) {
                alert(response.message);
            }
        });
    });
});
</script>-->