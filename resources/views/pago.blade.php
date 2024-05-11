<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arca Acces</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div class="wrapper">
        <header class="header-mobile">
            <h1 class="logo">Arca Acces</h1>
            <button class="open-menu" id="open-menu">
                <i class="bi bi-list"></i>
            </button>
        </header>
        <aside>
            <button class="close-menu" id="close-menu">
                <i class="bi bi-x"></i>
            </button>
            <header>
                <h1 class="logo">Arca Acces</h1>
            </header>
            <nav>
                <ul>
                    <li>
                        <a class="boton-menu boton-volver" href="{{ route('home') }}">
                            <i class="bi bi-arrow-return-left"></i> Seguir comprando
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu boton-carrito active" href="">
                            <i class="bi bi-cart-fill"></i> Pago
                        </a>
                    </li>
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© 2022 Arca Acces</p>
            </footer>
        </aside>
        <main>
            <h2 class="titulo-principal">Pago</h2>
            <div class="contenedor-carrito">
                @if ($estado === 'COMPLETED')
                    <div class="alert alert-success" role="alert">
                        ¡El pago se ha completado correctamente!
                        <p id="carrito-comprado" class="carrito-comprado">Muchas gracias por tu compra. <i class="bi bi-emoji-laughing"></i></p>
                    </div>
                @elseif ($estado === 'VERIFYING')
                    <div class="alert alert-info" role="alert">
                        El pago está siendo verificado. Por favor, espere.
                    </div>
                @elseif ($estado === 'REVOKED')
                    <div class="alert alert-danger" role="alert">
                        ¡La transacción ha sido denegada por Pagadito!
                    </div>
                @elseif ($estado === 'FAILED')
                    <div class="alert alert-danger" role="alert">
                        ¡La transacción ha fallado! Por favor, inténtelo de nuevo más tarde.
                    </div>
                @elseif ($estado === 'CANCELED')
                    <div class="alert alert-warning" role="alert">
                        ¡La transacción ha sido cancelada por el usuario!
                    </div>
                @elseif ($estado === 'EXPIRED')
                    <div class="alert alert-warning" role="alert">
                        ¡La transacción ha expirado! Por favor, vuelva a intentarlo.
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        ¡Ha ocurrido un error inesperado! Por favor, póngase en contacto con el soporte técnico.
                    </div>
                @endif

                @if (isset($error))
                    <div class="alert alert-danger" role="alert">
                        ¡Ha ocurrido un error: {{ $error }}!
                    </div>
                @endif

                @if ($factura)
                    <p id="carrito-comprado" class="carrito-comprado">Factura #: {{ $factura->nombre }}</p>
                    <p>Detalles de la compra:</p>
                    <p>Cliente: {{ $factura->usuarios->lastname }}, {{ $factura->usuarios->name }}</p>
                    <ul>
                        @foreach ($factura->detalles as $detalle)
                            <li>{{ $detalle->cantidad }} x {{ $detalle->productos->nombre }} - ${{ $detalle->productos->precio }}</li>
                        @endforeach
                    </ul>
                    <p>Total: ${{ $factura->total }}</p>
                @endif

            </div>
        </main>
    </div>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="./js/carrito.js"></script> -->
    <script src="./js/menu.js"></script>
    
</body>
</html>