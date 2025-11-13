<?php
global $meses, $ingresos, $numeroUsuarios, $numeroCursos, $cursoMasVendido, $precioTotalCursos, $comprasRealizadasHoy, $datos;
//Importamos las funciones del backend
require '../../backend/Administrador/funcion_estadisticas.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js  -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
<!-- Video del fondo  -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!--Navegador -->
<?php require '../partes_pagina/Administrador/Navegador.php' ?>


<main class="pt-32 pb-10 px-4 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Usuarios registrados los ultimos 5 dias -->
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">Usuarios Registrados (últimos 5 dias)</h2>
            <ul class="space-y-2">
                <?php if (!empty($usuariosRecientes)): ?>
                    <?php foreach ($usuariosRecientes as $usuario): ?>
                        <li class="flex justify-between text-sm">
                            <span><?= htmlspecialchars($usuario['nombre']) ?></span>
                            <span class="text-gray-500"><?= date('d/m/Y', strtotime($usuario['fecha'])) ?></span>
                        </li>
                    <?php endforeach; ?>
                    <!-- Notificacion de errores-->
                <?php else: ?>
                    <div class="p-4 bg-yellow-200 text-center rounded-lg text-sm">
                        <img src="../Imagenes/advertencia.png" alt="Advertencia" class="w-5 h-5 inline mr-2">
                        No ha habido usuarios nuevos
                    </div>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Estadisticas generales-->
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">Estadisticas</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span>Total de usuarios</span><span><?= $numeroUsuarios ?></span></div>
                <div class="flex justify-between"><span>Total de cursos</span><span><?= $numeroCursos ?></span></div>
                <div class="flex justify-between"><span>Curso mas vendido</span><span><?= $cursoMasVendido ?></span></div>
            </div>
        </div>

        <!-- Estadisticas sobre la pagina web -->
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">LeaToMaster</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span>Visitas</span><span><?= $_SESSION['contador_visitas'] ?></span></div>
                <div class="flex justify-between"><span>Total ingresos</span><span><?= $precioTotalCursos ?> €</span></div>
                <div class="flex justify-between"><span>Compras hoy</span><span><?= $comprasRealizadasHoy ?></span></div>
            </div>
        </div>
    </div>

    <!-- Grafico y tabla de los paises que compran -->
    <div class="mt-10 bg-white p-4 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold text-gray-700 mb-6 text-center">Paises que compran</h2>
        <?php if (!empty($datos) && is_array($datos)): ?>
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">

                <!-- Grafica de los paises-->
                <div class="w-full md:w-1/2">
                    <canvas id="graficoQueso"></canvas>
                </div>

                <!-- Tabla de los paises-->
                <div class="w-full md:w-1/2 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Pais</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Numero de compras</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        <?php foreach ($datos as $dato): ?>
                            <tr>
                                <td class="px-4 py-2"><?= htmlspecialchars($dato['pais']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($dato['numero_de_compras']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Notificacion de errores-->
        <?php else: ?>
            <div class="w-full text-center p-4 bg-yellow-200 rounded-lg flex items-center justify-center">
                <img src="../Imagenes/advertencia.png" alt="Advertencia" class="w-5 h-5 mr-2">
                <p class="text-sm text-gray-700">No hay datos registrados</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Script para generar un grafico de pastel que muestra las compras por pais -->
<script>
    const apartado = document.getElementById('graficoQueso').getContext('2d');
    const chart = new Chart(apartado, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($datos, 'pais')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($datos, 'numero_de_compras')) ?>,
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#6B7280', '#14B8A6'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function (info) {
                            const pais = info.label || '';
                            const compras = info.raw || 0;
                            return `${pais}: ${compras} compras`;
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>
