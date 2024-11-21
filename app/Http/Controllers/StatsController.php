<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrega;
use App\Models\Grupo;

use function PHPUnit\Framework\isNull;

class StatsController extends Controller
{
    public function index()
    {
        /* $data = [
            'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril'],
            'datasets' => [
                [
                    'label' => 'Ventas',
                    'data' => [150, 200, 180, 220],
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                ],
            ],
        ]; */

        $data = [
            'labels' => ['Completadas', 'Pendientes'],
            'datasets' => [
                [
                    'label' => 'Estado de Entregas',
                    'data' => [Entrega::whereNull('archivo')->count(), Entrega::whereNotNull('archivo')->count()],
                    'backgroundColor' => ['#36A2EB', '#FF6384'],
                ],
            ],
        ];

        /* // Obtener los grupos con sus calificaciones
        $data = Grupo::with(['materia', 'calificaciones'])->get()->map(function ($grupo) {
            return [
                'label' => $grupo->materia->nombre, // Nombre de la materia del grupo
                'average' => $grupo->calificaciones->avg('calificacion'), // Promedio de las calificaciones del grupo
            ];
        });

        $data = [
            'labels' => $data->pluck('label'), // Nombres de las materias
            'datasets' => [
                [
                    'label' => 'Promedio de Calificaciones',
                    'data' => $data->pluck('average'), // Promedios por materia
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'], // Colores para las barras
                ],
            ],
        ];
 */
        /* $data = Grupo::with(['materia', 'calificaciones'])->get()->map(function ($grupo, $index) {
            return [
                'x' => $index + 1, // Posición del grupo en el eje X (puedes usar otro criterio para X)
                'y' => $grupo->calificaciones->avg('calificacion'), // Promedio de calificaciones en el eje Y
            ];
        });
        
        $data = [
            'datasets' => [
                [
                    'label' => 'Promedio de Calificaciones',
                    'data' => $data->toArray(), // Array con objetos {x, y}
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)', // Color de los puntos
                ],
            ],
        ]; */
        

        return view('profesor.stats', compact('data'));
    }
}
