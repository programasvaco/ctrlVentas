<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Ventas - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Control de Ventas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Menú Clientes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="clientesDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-people-fill me-1"></i>Clientes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Lista de Clientes</a></li>
                            <li><a class="dropdown-item" href="{{ route('cxc.index') }}">Cuentas por Cobrar</a></li>
                        </ul>
                    </li>
                    <!-- Menú Inventario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="inventarioDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-box-seam-fill me-1"></i>Inventario
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('articulos.index') }}">Artículos</a></li>
                            <li><a class="dropdown-item" href="{{ route('inventarios.index') }}">Existencias</a></li>
                            <li><a class="dropdown-item" href="{{ route('kardex.index') }}">Kardex</a></li>
                        </ul>
                    </li>
                    <!-- Ventas -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ventas.index') }}">
                            <i class="bi bi-cash-stack me-1"></i>Ventas
                        </a>
                    </li>
                    <!-- Menú Compras -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="comprasDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-cart4-fill me-1"></i>Compras
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('proveedores.index') }}">Proveedores</a></li>
                            <li><a class="dropdown-item" href="{{ route('compras.index') }}">Registro de Compras</a></li>
                            <li><a class="dropdown-item" href="{{ route('cxp.index') }}">Cuentas por Pagar</a></li>
                        </ul>
                    </li>
                    <!-- Menú Reportes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-graph-up me-1"></i>Reportes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('caja.index') }}">Movimientos de Caja</a></li>
                            <li><a class="dropdown-item" href="{{ route('cortes.index') }}">Cortes de Caja</a></li>
                        </ul>
                    </li>
                </ul>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>