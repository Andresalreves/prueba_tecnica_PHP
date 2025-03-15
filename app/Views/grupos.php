<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
<?php 
    if(isset($grupos)){
        foreach ($grupos as $grupo): 
?>
    <tr>
        <td><?php echo $grupo['id']; ?></td>
        <td><?php echo $grupo['nombre']; ?></td>
        <td><?php echo $grupo['descripcion']; ?></td>
        <td>
            <!-- Botón para editar -->
            <button onclick="editarGrupo(<?php echo $grupo['id']; ?>)" class="btn-editar btn btn-success">Editar</button>

            <!-- Botón para eliminar -->
            <button onclick="confirmarEliminarGrupo(<?php echo $grupo['id']; ?>)" class="btn-eliminar btn btn-danger">Eliminar</button>
            <button onclick="verProductosGrupo(<?php echo $grupo['id']; ?>)" type="button" class="btn btn-info">Info</button>
        </td>
    </tr>
<?php 
        endforeach;
    }
?>
    </tbody>
</table>

<script>
    function cargarGrupos() {
        $.ajax({
            url: '<?php echo BASE_PATH ?>/grupos',
            method: 'GET',
            success: function(response) {
                $('#grupos-list').html(response);
            }
        });
    }

    // Función para confirmar la eliminación de un grupo
    function confirmarEliminarGrupo(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este grupo?")) {
            $.ajax({
                url: "<?php echo BASE_PATH; ?>/grupos/Delete", // URL sin el ID
                method: "POST",
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    cargarGrupos()
                },
                error: function(xhr, status, error) {
                    alert("Error al eliminar el grupo.");
                }
            });
        }
    }

    function verProductosGrupo(id) {
        $.ajax({
            url: "<?php echo BASE_PATH; ?>/grupos/ViewProducts",
            method: "POST",
            data: { id: id }, // Enviar el ID en el cuerpo de la solicitud
            success: function(response) {
                // Actualizar el contenido de la página con el formulario de edición
                $('#grupos-list').html(response);
            },
            error: function(xhr, status, error) {
                alert("Error al cargar el formulario de edición.");
            }
        });
    }

    // Función para editar un grupo
    function editarGrupo(id) {
        $.ajax({
            url: "<?php echo BASE_PATH; ?>/grupos/ViewUpdate",
            method: "POST",
            data: { id: id }, // Enviar el ID en el cuerpo de la solicitud
            success: function(response) {
                // Actualizar el contenido de la página con el formulario de edición
                $('#grupos-list').html(response);
            },
            error: function(xhr, status, error) {
                alert("Error al cargar el formulario de edición.");
            }
        });
    }
</script>