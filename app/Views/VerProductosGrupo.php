    <div class="container">
        <h1>Productos del Grupo</h1>
        <?php if (isset($productos)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <!-- Columnas de Productos -->
                        <th>Nombre Producto</th>
                        <th>Descripción Producto</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Fecha Creación</th>
                        <th>Estado</th>
                        <th>Nombre Grupo</th>
                        <th>Descripción Grupo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $fila): ?>
                        <tr>
                            <!-- Datos de Productos -->
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['descripcion']; ?></td>
                            <td><?php echo $fila['precio']; ?></td>
                            <td><?php echo $fila['stock']; ?></td>
                            <td><?php echo $fila['fecha_creacion']; ?></td>
                            <td><?php echo $fila['estado']; ?></td>
                            <!-- Datos de Grupos -->
                            <td><?php echo $fila['nombre_grupo']; ?></td>
                            <td><?php echo $fila['descripcion']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="message">No se encontraron productos para este grupo.</div>
        <?php endif; ?>
    </div>

    <!-- Botones de acción -->
    <div class="text-center mt-4">
        <button type="button" class="btn btn-secondary" onclick="CancelarEditarGrupo(event)">< Volver</button>
    </div>

<script>
    // Función para cancelar la edición y volver a la lista de grupos
    function CancelarEditarGrupo(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo BASE_PATH ?>/grupos',
            method: 'GET',
            success: function(response) {
                $('#grupos-list').html(response); // Actualizar la lista de grupos
            }
        });
    }

    $(document).ready(function() {
        // Manejar el envío del formulario de edición de grupos
        $('#form-editar-grupo').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize(); // Obtener los datos del formulario

            // Enviar los datos mediante AJAX
            $.ajax({
                url: "<?php echo BASE_PATH; ?>/grupos/editar",
                method: "POST",
                data: formData,
                dataType: 'json', // Esperar una respuesta JSON
                success: function(response) {
                    // Mostrar mensaje de éxito
                    alert(response.message);
                    // Volver a la lista de grupos
                    CancelarEditarGrupo(e);
                },
                error: function(xhr, status, error) {
                    // Mostrar mensaje de error
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Error al guardar los cambios.";
                    alert(errorMessage);
                }
            });
        });
    });
</script>