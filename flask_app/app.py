from flask import Flask, render_template, redirect, url_for
from dotenv import load_dotenv
import os

load_dotenv()

app = Flask(__name__)
app.secret_key = os.getenv("SECRET_KEY", "dev-secret-key")

# =============================================================
# Mock data — datos de demostración (sin base de datos real)
# =============================================================

CATEGORIAS = [
    {"id": 1, "nombre": "Motor"},
    {"id": 2, "nombre": "Frenos"},
    {"id": 3, "nombre": "Suspensión"},
    {"id": 4, "nombre": "Transmisión"},
    {"id": 5, "nombre": "Eléctrico"},
    {"id": 6, "nombre": "Carrocería"},
]

MARCAS = ["Bosch", "Brembo", "Monroe", "Gates", "NGK", "ATE", "Modine", "Delphi"]

AUTOPARTES = [
    {"id": 1, "nombre": "Filtro de aceite",        "categoria": "Motor",       "marca": "Bosch",   "precio": 45.00,    "stock": 45, "activo": True,  "estado": "Disponible"},
    {"id": 2, "nombre": "Pastillas de freno",       "categoria": "Frenos",      "marca": "Brembo",  "precio": 320.00,   "stock": 12, "activo": True,  "estado": "Disponible"},
    {"id": 3, "nombre": "Amortiguador delantero",   "categoria": "Suspensión",  "marca": "Monroe",  "precio": 850.00,   "stock": 3,  "activo": True,  "estado": "Bajo stock"},
    {"id": 4, "nombre": "Banda de distribución",    "categoria": "Motor",       "marca": "Gates",   "precio": 220.00,   "stock": 0,  "activo": True,  "estado": "Sin stock"},
    {"id": 5, "nombre": "Bujía de encendido",       "categoria": "Motor",       "marca": "NGK",     "precio": 35.00,    "stock": 80, "activo": True,  "estado": "Disponible"},
    {"id": 6, "nombre": "Alternador",               "categoria": "Eléctrico",   "marca": "Bosch",   "precio": 1200.00,  "stock": 8,  "activo": True,  "estado": "Disponible"},
    {"id": 7, "nombre": "Disco de freno",           "categoria": "Frenos",      "marca": "ATE",     "precio": 480.00,   "stock": 2,  "activo": False, "estado": "Bajo stock"},
    {"id": 8, "nombre": "Radiador de enfriamiento", "categoria": "Motor",       "marca": "Modine",  "precio": 1800.00,  "stock": 15, "activo": True,  "estado": "Disponible"},
]

INVENTARIOS = [
    {"id": 1, "autoparte": "Filtro de aceite",        "categoria": "Motor",      "stock_actual": 45, "stock_minimo": 10, "estado": "En stock",   "fecha_actualizacion": "2025-02-10"},
    {"id": 2, "autoparte": "Pastillas de freno",       "categoria": "Frenos",     "stock_actual": 12, "stock_minimo": 5,  "estado": "En stock",   "fecha_actualizacion": "2025-02-08"},
    {"id": 3, "autoparte": "Amortiguador delantero",   "categoria": "Suspensión", "stock_actual": 3,  "stock_minimo": 5,  "estado": "Bajo stock", "fecha_actualizacion": "2025-02-15"},
    {"id": 4, "autoparte": "Banda de distribución",    "categoria": "Motor",      "stock_actual": 0,  "stock_minimo": 3,  "estado": "Sin stock",  "fecha_actualizacion": "2025-02-01"},
    {"id": 5, "autoparte": "Bujía de encendido",       "categoria": "Motor",      "stock_actual": 80, "stock_minimo": 20, "estado": "En stock",   "fecha_actualizacion": "2025-02-12"},
    {"id": 6, "autoparte": "Alternador",               "categoria": "Eléctrico",  "stock_actual": 8,  "stock_minimo": 4,  "estado": "En stock",   "fecha_actualizacion": "2025-02-14"},
    {"id": 7, "autoparte": "Disco de freno",           "categoria": "Frenos",     "stock_actual": 2,  "stock_minimo": 6,  "estado": "Bajo stock", "fecha_actualizacion": "2025-02-09"},
    {"id": 8, "autoparte": "Radiador de enfriamiento", "categoria": "Motor",      "stock_actual": 15, "stock_minimo": 3,  "estado": "En stock",   "fecha_actualizacion": "2025-02-11"},
]

ESTADOS_PEDIDO = ["CREADO", "CONFIRMADO", "SURTIDO", "ENVIADO", "CANCELADO"]

PEDIDOS = [
    {"id": 1,  "cliente": "Juan Pérez",      "telefono": "442-123-4567", "email": "juan@ejemplo.com",    "fecha": "2025-02-01", "estado": "CONFIRMADO", "total": 410.00},
    {"id": 2,  "cliente": "María López",     "telefono": "442-234-5678", "email": "maria@ejemplo.com",   "fecha": "2025-02-05", "estado": "ENVIADO",    "total": 1200.00},
    {"id": 3,  "cliente": "Carlos Ruiz",     "telefono": "442-345-6789", "email": "carlos@ejemplo.com",  "fecha": "2025-02-08", "estado": "CREADO",     "total": 850.00},
    {"id": 4,  "cliente": "Ana Martínez",    "telefono": "442-456-7890", "email": "ana@ejemplo.com",     "fecha": "2025-02-10", "estado": "CANCELADO",  "total": 220.00},
    {"id": 5,  "cliente": "Roberto Sánchez", "telefono": "442-567-8901", "email": "roberto@ejemplo.com", "fecha": "2025-02-12", "estado": "SURTIDO",    "total": 480.00},
    {"id": 6,  "cliente": "Laura Díaz",      "telefono": "442-678-9012", "email": "laura@ejemplo.com",   "fecha": "2025-02-15", "estado": "CREADO",     "total": 1835.00},
    {"id": 7,  "cliente": "Pedro Gómez",     "telefono": "442-789-0123", "email": "pedro@ejemplo.com",   "fecha": "2025-02-18", "estado": "CONFIRMADO", "total": 665.00},
    {"id": 8,  "cliente": "Sofía Herrera",   "telefono": "442-890-1234", "email": "sofia@ejemplo.com",   "fecha": "2025-02-20", "estado": "ENVIADO",    "total": 3000.00},
]

DETALLE_PEDIDO = {
    1: {
        "pedido": PEDIDOS[0],
        "items": [
            {"nombre": "Filtro de aceite",  "cantidad": 2, "precio_unitario": 45.00,  "subtotal": 90.00},
            {"nombre": "Pastillas de freno","cantidad": 1, "precio_unitario": 320.00, "subtotal": 320.00},
        ],
        "total": 410.00,
    },
    2: {
        "pedido": PEDIDOS[1],
        "items": [
            {"nombre": "Alternador",        "cantidad": 1, "precio_unitario": 1200.00, "subtotal": 1200.00},
        ],
        "total": 1200.00,
    },
    3: {
        "pedido": PEDIDOS[2],
        "items": [
            {"nombre": "Amortiguador delantero", "cantidad": 1, "precio_unitario": 850.00, "subtotal": 850.00},
        ],
        "total": 850.00,
    },
    4: {
        "pedido": PEDIDOS[3],
        "items": [
            {"nombre": "Banda de distribución", "cantidad": 1, "precio_unitario": 220.00, "subtotal": 220.00},
        ],
        "total": 220.00,
    },
    5: {
        "pedido": PEDIDOS[4],
        "items": [
            {"nombre": "Disco de freno", "cantidad": 1, "precio_unitario": 480.00, "subtotal": 480.00},
        ],
        "total": 480.00,
    },
    6: {
        "pedido": PEDIDOS[5],
        "items": [
            {"nombre": "Radiador de enfriamiento", "cantidad": 1, "precio_unitario": 1800.00, "subtotal": 1800.00},
            {"nombre": "Bujía de encendido",        "cantidad": 1, "precio_unitario":   35.00, "subtotal":   35.00},
        ],
        "total": 1835.00,
    },
    7: {
        "pedido": PEDIDOS[6],
        "items": [
            {"nombre": "Pastillas de freno", "cantidad": 1, "precio_unitario": 320.00, "subtotal": 320.00},
            {"nombre": "Disco de freno",     "cantidad": 1, "precio_unitario": 480.00, "subtotal": 480.00},
        ],
        "total": 800.00,
    },
    8: {
        "pedido": PEDIDOS[7],
        "items": [
            {"nombre": "Radiador de enfriamiento", "cantidad": 1, "precio_unitario": 1800.00, "subtotal": 1800.00},
            {"nombre": "Alternador",               "cantidad": 1, "precio_unitario": 1200.00, "subtotal": 1200.00},
        ],
        "total": 3000.00,
    },
}

# =============================================================
# Rutas
# =============================================================

@app.route("/")
def index():
    return redirect(url_for("login"))


@app.route("/login")
def login():
    return render_template("auth/login.html", error=None)


@app.route("/autopartes")
def autopartes_lista():
    en_stock    = sum(1 for a in AUTOPARTES if a["estado"] == "Disponible")
    bajo_stock  = sum(1 for a in AUTOPARTES if a["estado"] == "Bajo stock")
    sin_stock   = sum(1 for a in AUTOPARTES if a["estado"] == "Sin stock")
    total_cats  = len(CATEGORIAS)
    total_marcas = len(set(a["marca"] for a in AUTOPARTES))

    return render_template(
        "autopartes/lista.html",
        autopartes=AUTOPARTES,
        categorias=CATEGORIAS,
        marcas=MARCAS,
        en_stock=en_stock,
        bajo_stock=bajo_stock,
        sin_stock=sin_stock,
        total_cats=total_cats,
        total_marcas=total_marcas,
    )


@app.route("/autopartes/nueva")
def autopartes_nueva():
    return render_template(
        "autopartes/formulario.html",
        autoparte=None,
        categorias=CATEGORIAS,
        modo="nueva",
    )


@app.route("/autopartes/<int:autoparte_id>/editar")
def autopartes_editar(autoparte_id):
    autoparte = next((a for a in AUTOPARTES if a["id"] == autoparte_id), None)
    return render_template(
        "autopartes/formulario.html",
        autoparte=autoparte,
        categorias=CATEGORIAS,
        modo="editar",
    )


@app.route("/inventarios")
def inventarios_lista():
    return render_template(
        "inventarios/lista.html",
        inventarios=INVENTARIOS,
        categorias=CATEGORIAS,
    )


@app.route("/pedidos")
def pedidos_lista():
    completados = sum(1 for p in PEDIDOS if p["estado"] in ("ENVIADO", "SURTIDO"))
    pendientes  = sum(1 for p in PEDIDOS if p["estado"] in ("CREADO", "CONFIRMADO"))
    cancelados  = sum(1 for p in PEDIDOS if p["estado"] == "CANCELADO")

    return render_template(
        "pedidos/lista.html",
        pedidos=PEDIDOS,
        estados=ESTADOS_PEDIDO,
        completados=completados,
        pendientes=pendientes,
        cancelados=cancelados,
        total_pedidos=len(PEDIDOS),
    )


@app.route("/pedidos/<int:pedido_id>")
def pedidos_detalle(pedido_id):
    detalle = DETALLE_PEDIDO.get(pedido_id)
    return render_template(
        "pedidos/detalle.html",
        detalle=detalle,
        estados=ESTADOS_PEDIDO,
        pedido_id=pedido_id,
    )


if __name__ == "__main__":
    app.run(debug=True)
