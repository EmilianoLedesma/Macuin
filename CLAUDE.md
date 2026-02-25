# CLAUDE.md — MACUIN Platform

This file provides context and instructions for Claude Code when working on this project.
Read this file completely before making any changes.

---

## Project Overview

MACUIN is a web platform for an auto parts distribution company. It solves inventory duplication and order inconsistency problems through a decoupled three-component architecture:

- **FastAPI (API Central)** — business logic, validations, JWT authentication
- **Flask (Internal Client)** — admin panel for internal staff (sales, warehouse)
- **Laravel (External Client)** — customer-facing portal

All components share a single MySQL database. This is a university project for Universidad Politécnica de Querétaro, subject: Tecnologías y Aplicaciones en Internet.

**Current deliverable scope:** Flask internal client (static templates), MySQL schema, Docker infrastructure, and GitHub repository setup.

---

## Architecture

```
                    ┌─────────────────────┐
                    │   API Central        │
                    │   FastAPI (Python)   │
                    │   Port: 8000         │
                    └──────────┬──────────┘
                               │
              ┌────────────────┼────────────────┐
              │                                  │
   ┌──────────▼──────────┐          ┌───────────▼───────────┐
   │  Internal Client    │          │  External Client       │
   │  Flask (Python)     │          │  Laravel (PHP)         │
   │  Port: 5000         │          │  Port: 8080            │
   └─────────────────────┘          └───────────────────────┘
                               │
                    ┌──────────▼──────────┐
                    │   MySQL 8.0          │
                    │   Port: 3306         │
                    └─────────────────────┘
```

---

## Tech Stack

| Component | Technology | Version |
|---|---|---|
| Internal client | Flask | 3.0.0 |
| External client | Laravel | 10.x |
| API | FastAPI | TBD |
| Database | MySQL | 8.0 |
| DB Interface | phpMyAdmin | latest |
| Containerization | Docker + Compose | latest |

---

## Repository Structure

```
macuin/
├── CLAUDE.md                      # This file
├── README.md                      # Project documentation
├── docker-compose.yml             # All services definition
├── .env.example                   # Environment variables template
├── .gitignore
├── database/
│   ├── schema_clean.sql           # Active schema (use this)
│   └── schema_original.sql        # Original reference (do not modify)
├── docs/
│   └── diagrams/                  # Architecture and ER diagrams
├── flask_app/
│   ├── Dockerfile
│   ├── requirements.txt
│   ├── app.py
│   ├── static/css/style.css
│   └── templates/
│       ├── base.html
│       ├── auth/login.html
│       ├── autopartes/lista.html
│       ├── autopartes/formulario.html
│       ├── inventarios/lista.html
│       ├── pedidos/lista.html
│       └── pedidos/detalle.html
└── laravel_app/                   # Reserved for future deliverable
```

---

## Key Commands

```bash
# Start all services
docker-compose up --build

# Start in background
docker-compose up -d --build

# Stop all services
docker-compose down

# Stop and remove volumes (reset database)
docker-compose down -v

# View Flask logs
docker-compose logs flask

# View MySQL logs
docker-compose logs db

# Access MySQL container directly
docker exec -it macuin_db mysql -u root -p

# Rebuild only Flask container
docker-compose up --build flask
```

---

## Environment Variables

Copy `.env.example` to `.env` before running. Never commit `.env` to the repository.

Required variables:
- `MYSQL_ROOT_PASSWORD` — MySQL root password
- `MYSQL_DATABASE` — database name (`autopartes_db`)
- `MYSQL_USER` — application user
- `MYSQL_PASSWORD` — application user password
- `FLASK_ENV` — `development` or `production`
- `SECRET_KEY` — Flask secret key for sessions

---

## Database

### Active Schema

Always use `database/schema_clean.sql`. The original file is kept only as reference.

### Core Tables

| Table | Description |
|---|---|
| `roles` | User role catalog |
| `usuarios` | System users (internal and external) |
| `categorias` | Auto parts categories |
| `autopartes` | Product catalog |
| `inventarios` | Stock per part (1:1 with autopartes) |
| `estados_pedido` | Order status catalog |
| `pedidos` | Orders placed by users |
| `detalle_pedido` | Order line items |

### Seeded Data

The `estados_pedido` table is pre-seeded with: `CREADO`, `CONFIRMADO`, `SURTIDO`, `ENVIADO`, `CANCELADO`.

---

## Flask Application

### Routes

| Route | Template | Description |
|---|---|---|
| `/` | — | Redirects to `/login` |
| `/login` | `auth/login.html` | Login screen |
| `/autopartes` | `autopartes/lista.html` | Parts list |
| `/autopartes/nueva` | `autopartes/formulario.html` | New part form |
| `/autopartes/<id>/editar` | `autopartes/formulario.html` | Edit part form |
| `/inventarios` | `inventarios/lista.html` | Inventory management |
| `/pedidos` | `pedidos/lista.html` | Orders list |
| `/pedidos/<id>` | `pedidos/detalle.html` | Order detail |

### Mock Data

All templates receive mock data defined in `app.py` via `render_template`. No real database queries in the current deliverable. Authentication is not enforced; all routes are directly accessible.

---

## Design System

### Colors

| Name | Hex | Usage |
|---|---|---|
| Primary red | `#C0392B` | Buttons, active states, header accents |
| Dark | `#1a1a1a` | Sidebar background, headings |
| Light background | `#f4f4f4` | Page background |
| Mid gray | `#cccccc` | Borders, dividers |
| White | `#ffffff` | Cards, table backgrounds |
| Success green | `#27ae60` | In-stock status |
| Warning orange | `#e67e22` | Low-stock status |
| Error red | `#c0392b` | Out-of-stock, error messages |

### Rules

- No gradients anywhere
- No external icon libraries (no Font Awesome, Heroicons, etc.)
- No external fonts (use `font-family: system-ui, -apple-system, sans-serif`)
- No CSS frameworks (no Bootstrap, Tailwind, Bulma)
- Single CSS file: `flask_app/static/css/style.css`
- Sidebar fixed width: 220px
- Status indicators use text color or cell background only

---

## Code Conventions

### Python / Flask

- Follow PEP 8 style guide
- Use `render_template` for all views
- Mock data defined at the top of `app.py` as constants or module-level variables
- No business logic in templates; pass computed values from `app.py`

### HTML / Jinja2

- All templates extend `base.html`
- Use Jinja2 blocks: `{% block title %}`, `{% block content %}`
- No inline styles; all styling via `style.css`
- Semantic HTML: use `<nav>`, `<main>`, `<section>`, `<table>`, `<form>` correctly

### CSS

- BEM-style class naming: `.sidebar`, `.sidebar__nav`, `.sidebar__nav--active`
- No inline styles in HTML
- Mobile breakpoint at 768px

### Git

- Commit messages in English following Conventional Commits
- `feat:` new features, `fix:` bug fixes, `docs:` documentation, `chore:` config and infrastructure
- All commits to `main` branch for this deliverable

---

## What NOT to Do

- Do not modify `database/schema_original.sql`
- Do not commit `.env` to the repository
- Do not use any external CSS framework or icon library
- Do not implement real authentication logic in Flask templates
- Do not add business logic to Jinja2 templates
- Do not use gradients or external fonts
- Do not create the `laravel_app` contents yet — leave the directory with a `.gitkeep`
- Do not skip reading the frontend-design skill files before writing HTML or CSS

---

## Skills to Read Before Starting

Before writing any HTML, CSS, or frontend code:

```
/mnt/skills/public/frontend-design/SKILL.md
/mnt/skills/user/frontend-design/SKILL.md
```

---

## Team

| Name | Role |
|---|---|
| Artemio Hurtado Hernández | Developer |
| María Guadalupe Jiménez Ruiz | Developer |
| Diego Antonio García García | Developer |
| Emiliano Ledesma Ledesma | Developer |

Professor: Iván Isay Guerra López
Institution: Universidad Politécnica de Querétaro — S204
Subject: Tecnologías y Aplicaciones en Internet
