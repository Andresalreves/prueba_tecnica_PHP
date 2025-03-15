<form id="form-editar-producto" action="<?php echo BASE_PATH; ?>/productos/editar/<?php echo $producto['id']; ?>" method="POST">
    <!-- Campo oculto para el ID del producto -->
    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

    <!-- Contenedor de 3 columnas -->
    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-4">
            <!-- Campo para el nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
            </div>

            <!-- Campo para el precio -->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="col-md-4">
            <!-- Campo para la descripción -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $producto['descripcion']; ?></textarea>
            </div>
        </div>

        <!-- Columna 3 -->
        <div class="col-md-4">
            <!-- Campo para el stock -->
            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required>
            </div>

            <!-- Campo para el estado -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="1" <?php echo $producto['estado'] ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo !$producto['estado'] ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" onclick="CancelarEditarProducto(event)">Cancelar</button>
    </div>
</form>
<script>
        function CancelarEditarProducto(e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo BASE_PATH ?>/productos',
                method: 'GET',
                success: function(response) {
                    $('#productos-list').html(response);
                }
            });
        }
        $(document).ready(function() {
            $('#form-editar-producto').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                // Enviar los datos mediante AJAX
                $.ajax({
                    url: "<?php echo BASE_PATH; ?>/productos/editar",
                    method: "POST",
                    data: formData,
                    dataType: 'json', 
                    success: function(response) {
                        // Mostrar mensaje de éxito
                        alert(response.message);
                        CancelarEditarProducto(e)
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