<?php

namespace App\Http\Controllers;

class AutopartesController extends Controller
{
    private array $categorias = [
        ['id' => 1, 'nombre' => 'Motor'],
        ['id' => 2, 'nombre' => 'Frenos'],
        ['id' => 3, 'nombre' => 'Suspensión'],
        ['id' => 4, 'nombre' => 'Transmisión'],
        ['id' => 5, 'nombre' => 'Eléctrico'],
        ['id' => 6, 'nombre' => 'Carrocería'],
    ];

    private array $marcas = ['Bosch', 'Brembo', 'Monroe', 'Gates', 'NGK', 'ATE', 'Modine', 'Delphi'];

    private array $autopartes = [
        ['id' => 1, 'nombre' => 'Filtro de aceite',        'categoria' => 'Motor',      'marca' => 'Bosch',  'precio' => 45.00,   'stock' => 45, 'activo' => true,  'estado' => 'Disponible'],
        ['id' => 2, 'nombre' => 'Pastillas de freno',       'categoria' => 'Frenos',     'marca' => 'Brembo', 'precio' => 320.00,  'stock' => 12, 'activo' => true,  'estado' => 'Disponible'],
        ['id' => 3, 'nombre' => 'Amortiguador delantero',   'categoria' => 'Suspensión', 'marca' => 'Monroe', 'precio' => 850.00,  'stock' => 3,  'activo' => true,  'estado' => 'Bajo stock'],
        ['id' => 4, 'nombre' => 'Banda de distribución',    'categoria' => 'Motor',      'marca' => 'Gates',  'precio' => 220.00,  'stock' => 0,  'activo' => true,  'estado' => 'Sin stock'],
        ['id' => 5, 'nombre' => 'Bujía de encendido',       'categoria' => 'Motor',      'marca' => 'NGK',    'precio' => 35.00,   'stock' => 80, 'activo' => true,  'estado' => 'Disponible'],
        ['id' => 6, 'nombre' => 'Alternador',               'categoria' => 'Eléctrico',  'marca' => 'Bosch',  'precio' => 1200.00, 'stock' => 8,  'activo' => true,  'estado' => 'Disponible'],
        ['id' => 7, 'nombre' => 'Disco de freno',           'categoria' => 'Frenos',     'marca' => 'ATE',    'precio' => 480.00,  'stock' => 2,  'activo' => false, 'estado' => 'Bajo stock'],
        ['id' => 8, 'nombre' => 'Radiador de enfriamiento', 'categoria' => 'Motor',      'marca' => 'Modine', 'precio' => 1800.00, 'stock' => 15, 'activo' => true,  'estado' => 'Disponible'],
    ];

    public function index()
    {
        $autopartes   = $this->autopartes;
        $en_stock     = count(array_filter($autopartes, fn ($a) => $a['estado'] === 'Disponible'));
        $bajo_stock   = count(array_filter($autopartes, fn ($a) => $a['estado'] === 'Bajo stock'));
        $sin_stock    = count(array_filter($autopartes, fn ($a) => $a['estado'] === 'Sin stock'));
        $total_cats   = count($this->categorias);
        $total_marcas = count(array_unique(array_column($autopartes, 'marca')));

        return view('autopartes.index', [
            'autopartes'   => $autopartes,
            'categorias'   => $this->categorias,
            'marcas'       => $this->marcas,
            'en_stock'     => $en_stock,
            'bajo_stock'   => $bajo_stock,
            'sin_stock'    => $sin_stock,
            'total_cats'   => $total_cats,
            'total_marcas' => $total_marcas,
        ]);
    }

    public function create()
    {
        return view('autopartes.form', [
            'autoparte'  => null,
            'categorias' => $this->categorias,
            'modo'       => 'nueva',
        ]);
    }

    public function edit(int $id)
    {
        $autoparte = collect($this->autopartes)->firstWhere('id', $id);

        return view('autopartes.form', [
            'autoparte'  => $autoparte,
            'categorias' => $this->categorias,
            'modo'       => 'editar',
        ]);
    }
}
