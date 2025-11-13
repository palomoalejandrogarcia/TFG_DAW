<?php
//importamos las funciones del backend
require '../../backend/Administrador/funcion_añadir_curso.php'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
<!-- Video del fondo  -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>



<main class="flex-grow flex justify-center items-center text-center px-4 md:px-6 mt-16 md:mt-20">
    <div class="w-full max-w-4xl mx-auto bg-white shadow p-4 md:p-6 rounded">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Crear Curso</h1>
        <form method="POST">

            <div class="space-y-4">
                <div>
                    <!-- Campo titulo curso -->
                    <label class="block font-semibold">Titulo del Curso</label>
                    <input type="text" name="titulo" required class="w-full border p-2 rounded"/>
                </div>
                <div>
                    <!-- Campo descripcion -->
                    <label class="block font-semibold">Descripcion</label>
                    <textarea name="descripcion" rows="3" class="w-full border p-2 rounded"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <!-- Campo precio -->
                        <label class="block font-semibold">Precio</label>
                        <input type="number" name="precio" step="0.01" required class="w-full border p-2 rounded"/>
                    </div>
                    <div>
                        <!-- Campo foto -->
                        <label class="block font-semibold">Foto</label>
                        <input type="text" name="url_foto" placeholder="URL" class="w-full border p-2 rounded" required />
                    </div>
                </div>
            </div>

            <div id="apartados" class="my-4 space-y-6">
                <!-- Donde se agregara los apartados creados -->

            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <!-- Boton de añadir apartado -->
                <button type="button" onclick="agregarApartado()" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded my-2 sm:my-0">
                    Añadir Apartado
                </button>
                <!-- Boton de crear curso -->
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">
                    Crear Curso
                </button>
            </div>

            <!-- Notificacion de errores  -->
            <?php if (!empty($mensajeCurso)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded my-4 text-center font-semibold flex items-center justify-center">
                    <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                    <?= htmlspecialchars($mensajeCurso) ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</main>

<script>
    let apartado_Indice = 0;
    //Esta funcion lo que hace es crear un apartado en el curso
    function agregarApartado() {
        const apartados = document.getElementById('apartados');
        const div = document.createElement('div');
        div.className = "p-4 mb-4 border rounded bg-gray-50";
        div.innerHTML = `
        <h2 class="text-lg font-bold mb-2">Apartado ${apartado_Indice + 1}</h2>
        <label class="block font-semibold">Titulo del Apartado</label>
        <input type="text" name="apartado_titulo[]" required class="w-full border p-2 rounded mb-2"/>

        <label class="block font-semibold">Descripcion</label>
        <textarea name="apartado_descripcion[]" rows="2" class="w-full border p-2 rounded mb-2"></textarea>

        <div id="recursos-${apartado_Indice}" class="mb-2">
        </div>

        <button type="button" class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1 rounded mb-2" onclick="agregarRecurso(${apartado_Indice})">
          Añadir Recurso
        </button>
      `;
        apartados.appendChild(div);
        apartado_Indice++;
    }
    //Esta funcion lo que hace es crear un recurso dentro de un apartado
    function agregarRecurso(indice) {
        const recursos = document.getElementById(`recursos-${indice}`);
        const recurso = document.createElement('div');
        recurso.className = "mb-3";
        recurso.innerHTML = `
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-1">
          <select name="tipo_recurso[${indice}][]" class="border p-2 rounded">
            <option value="video">Video</option>
            <option value="documento">Documento</option>
          </select>
          <input type="text" name="titulo_recurso[${indice}][]" placeholder="Titulo" class="border p-2 rounded" required/>
          <input type="text" name="url_recurso[${indice}][]" placeholder="URL" class="border p-2 rounded" required/>
        </div>
      `;
        recursos.appendChild(recurso);
    }
</script>
</body>
</html>