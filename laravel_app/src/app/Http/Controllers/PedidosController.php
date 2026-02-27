<?php

namespace App\Http\Controllers;

class PedidosController extends Controller
{
    private array $estados = ['CREADO', 'CONFIRMADO', 'SURTIDO', 'ENVIADO', 'CANCELADO'];

    private array $pedidos = [
        ['id' => 1, 'cliente' => 'Juan Pérez',      'telefono' => '442-123-4567', 'email' => 'juan@ejemplo.com',    'fecha' => '2025-02-01', 'estado' => 'CONFIRMADO', 'total' => 410.00],
        ['id' => 2, 'cliente' => 'María López',     'telefono' => '442-234-5678', 'email' => 'maria@ejemplo.com',   'fecha' => '2025-02-05', 'estado' => 'ENVIADO',    'total' => 1200.00],
        ['id' => 3, 'cliente' => 'Carlos Ruiz',     'telefono' => '442-345-6789', 'email' => 'carlos@ejemplo.com',  'fecha' => '2025-02-08', 'estado' => 'CREADO',     'total' => 850.00],
        ['id' => 4, 'cliente' => 'Ana Martínez',    'telefono' => '442-456-7890', 'email' => 'ana@ejemplo.com',     'fecha' => '2025-02-10', 'estado' => 'CANCELADO',  'total' => 220.00],
        ['id' => 5, 'cliente' => 'Roberto Sánchez', 'telefono' => '442-567-8901', 'email' => 'roberto@ejemplo.com', 'fecha' => '2025-02-12', 'estado' => 'SURTIDO',    'total' => 480.00],
        ['id' => 6, 'cliente' => 'Laura Díaz',      'telefono' => '442-678-9012', 'email' => 'laura@ejemplo.com',   'fecha' => '2025-02-15', 'estado' => 'CREADO',     'total' => 1835.00],
        ['id' => 7, 'cliente' => 'Pedro Gómez',     'telefono' => '442-789-0123', 'email' => 'pedro@ejemplo.com',   'fecha' => '2025-02-18', 'estado' => 'CONFIRMADO', 'total' => 665.00],
        ['id' => 8, 'cliente' => 'Sofía Herrera',   'telefono' => '442-890-1234', 'email' => 'sofia@ejemplo.com',   'fecha' => '2025-02-20', 'estado' => 'ENVIADO',    'total' => 3000.00],
    ];

    private array $detallePedido;

    public function __construct()
    {
        $this->detallePedido = [
            1 => [
                'pedido' => $this->pedidos[0],
                'items'  => [
                    ['nombre' => 'Filtro de aceite',  'cantidad' => 2, 'precio_unitario' => 45.00,  'subtotal' => 90.00],
                    ['nombre' => 'Pastillas de freno', 'cantidad' => 1, 'precio_unitario' => 320.00, 'subtotal' => 320.00],
                ],
                'total'  => 410.00,
            ],
            2 => [
                'pedido' => $this->pedidos[1],
                'items'  => [
                    ['nombre' => 'Alternador', 'cantidad' => 1, 'precio_unitario' => 1200.00, 'subtotal' => 1200.00],
                ],
                'total'  => 1200.00,
            ],
            3 => [
                'pedido' => $this->pedidos[2],
                'items'  => [
                    ['nombre' => 'Amortiguador delantero', 'cantidad' => 1, 'precio_unitario' => 850.00, 'subtotal' => 850.00],
                ],
                'total'  => 850.00,
            ],
            4 => [
                'pedido' => $this->pedidos[3],
                'items'  => [
                    ['nombre' => 'Banda de distribución', 'cantidad' => 1, 'precio_unitario' => 220.00, 'subtotal' => 220.00],
                ],
                'total'  => 220.00,
            ],
            5 => [
                'pedido' => $this->pedidos[4],
                'items'  => [
                    ['nombre' => 'Disco de freno', 'cantidad' => 1, 'precio_unitario' => 480.00, 'subtotal' => 480.00],
                ],
                'total'  => 480.00,
            ],
            6 => [
                'pedido' => $this->pedidos[5],
                'items'  => [
                    ['nombre' => 'Radiador de enfriamiento', 'cantidad' => 1, 'precio_unitario' => 1800.00, 'subtotal' => 1800.00],
                    ['nombre' => 'Bujía de encendido',       'cantidad' => 1, 'precio_unitario' =>   35.00, 'subtotal' =>   35.00],
                ],
                'total'  => 1835.00,
            ],
            7 => [
                'pedido' => $this->pedidos[6],
                'items'  => [
                    ['nombre' => 'Pastillas de freno', 'cantidad' => 1, 'precio_unitario' => 320.00, 'subtotal' => 320.00],
                    ['nombre' => 'Disco de freno',     'cantidad' => 1, 'precio_unitario' => 480.00, 'subtotal' => 480.00],
                ],
                'total'  => 800.00,
            ],
            8 => [
                'pedido' => $this->pedidos[7],
                'items'  => [
                    ['nombre' => 'Radiador de enfriamiento', 'cantidad' => 1, 'precio_unitario' => 1800.00, 'subtotal' => 1800.00],
                    ['nombre' => 'Alternador',               'cantidad' => 1, 'precio_unitario' => 1200.00, 'subtotal' => 1200.00],
                ],
                'total'  => 3000.00,
            ],
        ];
    }

    public function index()
    {
        $pedidos     = $this->pedidos;
        $completados = count(array_filter($pedidos, fn ($p) => in_array($p['estado'], ['ENVIADO', 'SURTIDO'])));
        $pendientes  = count(array_filter($pedidos, fn ($p) => in_array($p['estado'], ['CREADO', 'CONFIRMADO'])));
        $cancelados  = count(array_filter($pedidos, fn ($p) => $p['estado'] === 'CANCELADO'));

        return view('pedidos.index', [
            'pedidos'       => $pedidos,
            'estados'       => $this->estados,
            'completados'   => $completados,
            'pendientes'    => $pendientes,
            'cancelados'    => $cancelados,
            'total_pedidos' => count($pedidos),
        ]);
    }

    public function show(int $id)
    {
        $detalle = $this->detallePedido[$id] ?? null;

        return view('pedidos.show', [
            'detalle'   => $detalle,
            'estados'   => $this->estados,
            'pedido_id' => $id,
        ]);
    }
}
