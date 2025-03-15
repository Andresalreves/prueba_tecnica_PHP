<form id="form-editar-grupo" action="<?php echo BASE_PATH; ?>/grupos/editar/<?php echo $grupo['id']; ?>" method="POST">
    <!-- Campo oculto para el ID del grupo -->
    <input type="hidden" name="id" value="<?php echo $grupo['id']; ?>">

    <!-- Contenedor de 3 columnas -->
    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-4">
            <!-- Campo para el nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $grupo['nombre']; ?>" required>
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="col-md-4">
            <!-- Campo para la descripción -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $grupo['descripcion']; ?></textarea>
            </div>
        </div>

        <!-- Columna 3 -->
        <div class="col-md-4">
            <!-- Puedes agregar más campos aquí si es necesario -->
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" onclick="CancelarEditarGrupo(event)">Cancelar</button>
    </div>
</form>

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