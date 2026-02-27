<?php

namespace App\Http\Controllers;

class InventariosController extends Controller
{
    private array $categorias = [
        ['id' => 1, 'nombre' => 'Motor'],
        ['id' => 2, 'nombre' => 'Frenos'],
        ['id' => 3, 'nombre' => 'Suspensión'],
        ['id' => 4, 'nombre' => 'Transmisión'],
        ['id' => 5, 'nombre' => 'Eléctrico'],
        ['id' => 6, 'nombre' => 'Carrocería'],
    ];

    private array $inventarios = [
        ['id' => 1, 'autoparte' => 'Filtro de aceite',        'categoria' => 'Motor',      'stock_actual' => 45, 'stock_minimo' => 10, 'estado' => 'En stock',   'fecha_actualizacion' => '2025-02-10'],
        ['id' => 2, 'autoparte' => 'Pastillas de freno',       'categoria' => 'Frenos',     'stock_actual' => 12, 'stock_minimo' => 5,  'estado' => 'En stock',   'fecha_actualizacion' => '2025-02-08'],
        ['id' => 3, 'autoparte' => 'Amortiguador delantero',   'categoria' => 'Suspensión', 'stock_actual' => 3,  'stock_minimo' => 5,  'estado' => 'Bajo stock', 'fecha_actualizacion' => '2025-02-15'],
        ['id' => 4, 'autoparte' => 'Banda de distribución',    'categoria' => 'Motor',      'stock_actual' => 0,  'stock_minimo' => 3,  'estado' => 'Sin stock',  'fecha_actualizacion' => '2025-02-01'],
        ['id' => 5, 'autoparte' => 'Bujía de encendido',       'categoria' => 'Motor',      'stock_actual' => 80, 'stock_minimo' => 20, 'estado' => 'En stock',   'fecha_actualizacion' => '2025-02-12'],
        ['id' => 6, 'autoparte' => 'Alternador',               'categoria' => 'Eléctrico',  'stock_actual' => 8,  'stock_minimo' => 4,  'estado' => 'En stock',   'fecha_actualizacion' => '2025-02-14'],
        ['id' => 7, 'autoparte' => 'Disco de freno',           'categoria' => 'Frenos',     'stock_actual' => 2,  'stock_minimo' => 6,  'estado' => 'Bajo stock', 'fecha_actualizacion' => '2025-02-09'],
        ['id' => 8, 'autoparte' => 'Radiador de enfriamiento', 'categoria' => 'Motor',      'stock_actual' => 15, 'stock_minimo' => 3,  'estado' => 'En stock',   'fecha_actualizacion' => '2025-02-11'],
    ];

    public function index()
    {
        return view('inventarios.index', [
            'inventarios' => $this->inventarios,
            'categorias'  => $this->categorias,
        ]);
    }
}
