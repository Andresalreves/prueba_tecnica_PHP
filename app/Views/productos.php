<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Fecha Creación</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
<?php 
    if(isset($productos)){
        foreach ($productos as $producto): 
?>
    <tr>
        <td><?php echo $producto['id']; ?></td>
        <td><?php echo $producto['nombre']; ?></td>
        <td><?php echo $producto['descripcion']; ?></td>
        <td><?php echo $producto['precio']; ?></td>
        <td><?php echo $producto['stock']; ?></td>
        <td><?php echo $producto['fecha_creacion']; ?></td>
        <td><?php echo $producto['estado'] ? 'Activo' : 'Inactivo'; ?></td>
        <td>
            <!-- Botón para editar -->
            <button onclick="editarProducto(<?php echo $producto['id']; ?>)" class="btn-editar btn btn-success">Editar</button>

            <!-- Botón para eliminar -->
            <button onclick="confirmarEliminar(<?php echo $producto['id']; ?>)" class="btn-eliminar btn btn-danger">Eliminar</button>
            <select name="producto_grupo" class="producto_grupo btn btn-secondary"">
                <option value="">Seleccione</option>
                <?php 
                    foreach ($grupos as $grupo){
                ?>
                    <option <?php echo ($grupo['id'] == $producto['grupo_id']) ? 'selected="selected"':""; ?> value="<?php echo $producto['id'].'-'.$grupo['id'] ?>"><?php echo $grupo['nombre'] ?></option>

                <?php
                    }
                ?>
            </select>
        </td>
    </tr>
<?php 
        endforeach;
    }
?>
    </tbody>
</table>

<script>
    function cargarProductos() {
        $.ajax({
            url: '<?php echo BASE_PATH ?>/productos',
            method: 'GET',
            success: function(response) {
                $('#productos-list').html(response);
            }
        });
    }

    function confirmarEliminar(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
            $.ajax({
                url: "<?php echo BASE_PATH; ?>/productos/Delete", // URL sin el ID
                method: "POST",
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    cargarProductos()
                },
                error: function(xhr, status, error) {
                    alert("Error al eliminar el producto.");
                }
            });
        }
    }

    function editarProducto(id) {
        $.ajax({
            url: "<?php echo BASE_PATH; ?>/productos/ViewUpdate",
            method: "POST",
            data: { id: id }, // Enviar el ID en el cuerpo de la solicitud
            success: function(response) {
                        $('#productos-list').html(response);
                    },
            error: function(xhr, status, error) {
                alert("Error al eliminar el producto.");
            }
        });
    }

    $(document).ready(function() {
        $('.producto_grupo').on('change', function() {
            const selectedValue = $(this).val();

            if (selectedValue) {
                // Separar el valor en producto_id y grupo_id
                const valores = selectedValue.split('-');
                // Realizar la petición AJAX
                $.ajax({
                    url: '<?php echo BASE_PATH; ?>/pyg/CreateOrUpdeat',
                    method: 'POST',
                    dataType: 'json',
                    data:{
                        'producto_id': parseInt(valores[0]),
                        'grupo_id': parseInt(valores[1])
                    },
                    success: function(data) {
                        alert(data.message);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Hubo un error en la solicitud.');
                    }
                });
            }
        });
    });
</script>