<?php
session_start();
global $cursos, $usuarios;
//Importamos las funciones del backend
require '../../backend/Administrador/funcion_panel_control.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col px-4">
<!-- Video del fondo  -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!--Navegador -->
<?php require '../partes_pagina/Administrador/Navegador.php' ?>


<main class="flex-grow flex flex-col items-center mt-32 pb-10">
    <div class="w-full max-w-6xl">

        <div class="text-center mb-10">
            <div class="bg-blue-900 text-white p-4 rounded-lg shadow-lg max-w-sm mx-auto mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold">Cursos</h2>
            </div>


            <!-- Tabla de los cursos creados-->
            <div class="overflow-x-auto w-full mb-8">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md mx-auto">
                    <?php if (count($cursos) > 0): ?>
                        <thead class="bg-gray-200 text-sm text-gray-700">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Titulo</th>
                            <th class="px-4 py-2">Descripcion</th>
                            <th class="px-4 py-2">Precio</th>
                            <th class="px-4 py-2">Creado por</th>
                            <th class="px-4 py-2">Hora creada</th>
                            <th class="px-4 py-2">Operaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cursos as $curso): ?>
                            <tr class="hover:bg-gray-100 text-sm text-gray-700">
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($curso['Id_curso']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($curso['Titulo']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($curso['Descripcion']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($curso['Precio']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($curso['Creado_por']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($curso['Hora_creacion']) ?></td>
                                <td class="px-4 py-2 border-b flex flex-wrap gap-2 justify-center">
                                    <!-- Boton de eliminar curso -->
                                    <button onclick="mostrarModalCurso(<?= htmlspecialchars($curso['Id_curso']) ?>, '<?= htmlspecialchars($curso['Titulo']) ?>')" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        <img src="../Imagenes/basura.png" alt="Eliminar" width="20">
                                    </button>
                                    <!-- Boton de modificar curso -->
                                    <form action="../../backend/Administrador/funcion_panel_control.php" method="POST">
                                        <input type="hidden" name="curso_id_modificar" value="<?= htmlspecialchars($curso['Id_curso']) ?>">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                            <img src="../Imagenes/editar.png" alt="Editar" width="20">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    <?php else: ?>
                        <caption class="bg-yellow-200 text-gray-700 p-4 rounded-lg mt-4">
                            <img src="../Imagenes/advertencia.png" alt="Advertencia" class="inline w-5 h-5 mr-2"> No hay cursos disponibles
                        </caption>
                    <?php endif; ?>
                </table>
            </div>

            <!-- Modal curso -->
            <div id="panelEliminarCurso" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
                <div class="bg-orange-200 p-6 rounded-lg shadow-lg w-full sm:max-w-md md:max-w-lg lg:max-w-xl text-center">
                    <p id="mensajeEliminarCurso" class="text-2xl mb-4 text-orange-800"></p>

                    <!-- Formulario curso -->
                    <form id="formEliminarCurso" action="Panel_Control.php" method="POST">
                        <input type="hidden" name="curso_id_eliminar" id="cursoId">
                        <div class="flex justify-center space-x-4">
                            <!-- Boton de confirmacion -->
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">Eliminar curso</button>
                            <!-- Boton de cancelacion -->
                            <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200" onclick="cerrarModalCurso()">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Boton de añadir curso -->
            <form action="../../backend/Administrador/funcion_panel_control.php" method="POST" class="mb-8">
                <input type="hidden" name="curso_id_anadir" value="añadir">
                <button class="bg-green-500 hover:bg-green-700 text-white px-6 py-3 rounded text-lg font-semibold">
                    Añadir curso
                </button>
            </form>
        </div>


        <div class="text-center">
            <div class="bg-blue-900 text-white p-4 rounded-lg shadow-lg max-w-2xl mx-auto mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold">Usuarios registrados</h2>
            </div>

            <!-- Tabla de los usuarios registrados -->
            <div class="overflow-x-auto w-full">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md mx-auto">
                    <?php if (count($usuarios) > 0): ?>
                        <thead class="bg-gray-200 text-sm text-gray-700">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Usuario</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Apellidos</th>
                            <th class="px-4 py-2">Correo</th>
                            <th class="px-4 py-2">Edad</th>
                            <th class="px-4 py-2">Operaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr class="hover:bg-gray-100 text-sm text-gray-700">
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($usuario['usuario']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($usuario['nombre']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($usuario['apellidos']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($usuario['correo']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($usuario['edad']) ?></td>
                                <td class="px-4 py-2 border-b flex flex-wrap gap-2 justify-center">
                                    <!-- Boton de eliminar usuario -->
                                    <button onclick="mostrarModalUsuario(<?= htmlspecialchars($usuario['id_usuario']) ?>, '<?= htmlspecialchars($usuario['usuario']) ?>')" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        <img src="../Imagenes/basura.png" alt="Eliminar" width="20">
                                    </button>
                                    <!-- Boton de modificar usuario -->
                                    <form action="../../backend/Administrador/funcion_panel_control.php" method="POST">
                                        <input type="hidden" name="usuario_id_modificar" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                            <img src="../Imagenes/editar.png" alt="Editar" width="20">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    <?php else: ?>
                        <caption class="bg-yellow-200 text-gray-700 p-4 rounded-lg mt-4">
                            <img src="../Imagenes/advertencia.png" alt="Advertencia" class="inline w-5 h-5 mr-2"> No hay usuarios registrados
                        </caption>
                    <?php endif; ?>
                </table>
            </div>
        </div>


        <!-- Modal usuario -->
        <div id="panelEliminarUsuario" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
            <div class="bg-orange-200 p-6 rounded-lg shadow-lg w-full sm:max-w-md md:max-w-lg lg:max-w-xl text-center">
                <p id="mensajeEliminarUsuario" class="text-2xl mb-4 text-orange-800"></p>

                <!-- Formulario usuario -->
                <form id="formEliminarUsuario" action="Panel_Control.php" method="POST">
                    <input type="hidden" name="usuario_id_eliminar" id="usuarioId">
                    <div class="flex justify-center space-x-4">
                        <!-- Boton de confirmacion -->
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">Eliminar usuario</button>
                        <!-- Boton de cancelacion -->
                        <button type="button" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200" onclick="cerrarModalUsuario()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>

<script>
    //Esta funcion mostrara el modal del usuario seleccionado y mostrara el mensaje de advertencia
    function mostrarModalCurso(cursoId,titulo) {

        //Mostramos el modal
        document.getElementById('panelEliminarCurso').classList.remove('hidden');

        // Establecemos el valor del campo oculto
        document.getElementById('cursoId').value = cursoId;

        //Mostramos el mensaje que queremos que muestre en el modal
        const mensaje = document.getElementById('mensajeEliminarCurso');
        mensaje.innerHTML = `⚠️ ¿Estas seguro de que quieres eliminar el curso ${titulo}?`;
    }

    //Esta funcion lo que hara sera que el model de curso se esconda
    function cerrarModalCurso() {

        document.getElementById('panelEliminarCurso').classList.add('hidden');
    }

    //Esta funcion mostrara el modal del usuario seleccionado y mostrara el mensaje de advertencia
    function mostrarModalUsuario(usuarioId,usuario) {

        // Mostramos el modal
        document.getElementById('panelEliminarUsuario').classList.remove('hidden');

        // Establecemos el valor del campo oculto
        document.getElementById('usuarioId').value = usuarioId;

        //Mostramos el mensaje que queremos que se muestre en el modal
        const mensaje = document.getElementById('mensajeEliminarUsuario');
        mensaje.innerHTML = `⚠️ ¿Estas seguro de que quieres eliminar al usuario ${usuario}?`;
    }

    //Esta funcion lo que hara sera que el model de usuario se esconda
    function cerrarModalUsuario() {

        document.getElementById('panelEliminarUsuario').classList.add('hidden');
    }
</script>