<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arca Acces</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./css/main.css">
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
                        <a class="boton-menu boton-volver" href="/">
                            <i class="bi bi-arrow-return-left"></i> Seguir comprando
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu boton-carrito active" href="./carrito.html">
                            <i class="bi bi-cart-fill"></i> Carrito
                        </a>
                    </li>
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© 2022 Arca Acces</p>
            </footer>
        </aside>
        <main>
            <h2 class="titulo-principal">Carrito</h2>
            <div class="contenedor-carrito">
            @csrf
                @if (count($carrito) > 0)
                    <div id="carrito-productos" class="carrito-productos">
                        @foreach ($carrito as $producto)
                            <div class="carrito-producto" data-product-id="{{ $producto['producto_id'] }}">
                                <img class="carrito-producto-imagen" src="{{ asset('image/' .$producto['imagenes']. '') }}" alt="{{ $producto['nombre'] }}">
                                <div class="carrito-producto-titulo">
                                    <small>Título</small>
                                    <h3>{{ $producto['nombre'] }}</h3>
                                </div>
                                <div class="carrito-producto-cantidad">
                                    <small>Cantidad</small>
                                    <div class="cantidad-container">
                                        <button class="btn-cantidad btn-decremento" onclick="decrementarCantidad('{{ $producto['producto_id'] }}', '{{ $producto['precio_unidad'] }}')">-</button>
                                        <p class="cantidad">{{ $producto['cantidad'] }}</p>
                                        <button class="btn-cantidad btn-incremento" onclick="incrementarCantidad('{{ $producto['producto_id'] }}', '{{ $producto['precio_unidad'] }}')">+</button>
                                    </div>
                                </div>
                                <div class="carrito-producto-precio">
                                    <small>Precio</small>
                                    <p>${{ $producto['precio_unidad'] }}</p>
                                </div>
                                <div class="carrito-producto-subtotal">
                                    <small>Subtotal</small>
                                    <p>${{ $producto['precio_unidad'] * $producto['cantidad'] }}</p>
                                </div>
                                <form action="{{ route('carrito.eliminar', $producto['producto_id']) }}" id="eliminar-producto-{{ $producto['producto_id'] }}" method="POST">
                                    @csrf
                                    <button class="carrito-producto-eliminar" id=""  onclick="confirmDelete('{{ $producto['producto_id'] }}')" type="button"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p id="carrito-vacio" class="carrito-vacio">Tu carrito está vacío. <i class="bi bi-emoji-frown"></i></p>
                @endif

                <div id="carrito-acciones" class="carrito-acciones">
                    <div class="carrito-acciones-izquierda">
                        <form action="{{ route('carrito.vaciar') }}" method="POST" id="vaciar">
                            @csrf
                            <button id="carrito-acciones-vaciar" class="carrito-acciones-vaciar"  onclick="vaciarCarrito()" type="button">Vaciar carrito</button>
                        </form>
                    </div>
                    <div class="carrito-acciones-derecha">
                        <div class="carrito-acciones-total">
                            <p>Total:</p>
                            @php
                                $total = 0;
                                $carrito = session('carrito', []);
                                @endphp

                                @if (count($carrito) > 0)
                                    @foreach ($carrito as $producto)
                                        @php
                                            $subtotal = $producto['precio_unidad'] * $producto['cantidad'];
                                            $total += $subtotal;
                                        @endphp
                                    @endforeach
                                @endif
                            <p id="total">${{ $total }}</p>
                        </div>
                        <form action="{{ route('cobrar') }}" method="post">
                            @csrf
                            <button class="carrito-acciones-comprar">Comprar ahora</button>
                        </form>
                    </div>
                </div>

                <p id="carrito-comprado" class="carrito-comprado disabled">Muchas gracias por tu compra. <i class="bi bi-emoji-laughing"></i></p>

            </div>
        </main>
    </div>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="./js/carrito.js"></script> -->
    <script src="./js/menu.js"></script>
    <script>
        function getTotalPrecio() {
            let total = 0;
            document.querySelectorAll('.carrito-producto').forEach((producto) => {
                let precio = parseFloat(producto.querySelector('.carrito-producto-subtotal p').textContent.replace('$', ''));
                total += precio;
            });
            return total.toFixed(2);
        }

        let updatingCart = false;

        function incrementarCantidad(productId, precio) {
            if (updatingCart) return;

            document.querySelectorAll('.btn-cantidad').forEach((btn) => {
                btn.disabled = true;
            });
            updatingCart = true;
            fetch(`/carrito/${productId}/incrementar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Hubo un problema al incrementar la cantidad.');
                }
                return response.json();
            })
            .then(data => {
                let cantidadElement = document.querySelector(`.carrito-productos [data-product-id="${productId}"] .cantidad`);
                let subTotal = document.querySelector(`.carrito-productos [data-product-id="${productId}"] > .carrito-producto-subtotal > p`);
                cantidadElement.textContent = data.cantidad;
                subTotal.textContent = '$' + (precio * data.cantidad);
                document.querySelector('#total').textContent = '$' + getTotalPrecio();
                document.querySelectorAll('.btn-cantidad').forEach((btn) => {
                    btn.disabled = false;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                updatingCart = false;
            });
        }

        function decrementarCantidad(productId, precio) {
            if (updatingCart) return;

            document.querySelectorAll('.btn-cantidad').forEach((btn) => {
                btn.disabled = true;
            });

            updatingCart = true;
            fetch(`/carrito/${productId}/decrementar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Hubo un problema al decrementar la cantidad.');
                }
                return response.json();
            })
            .then(data => {
                let cantidadElement = document.querySelector(`.carrito-productos [data-product-id="${productId}"] .cantidad`);
                let subTotal = document.querySelector(`.carrito-productos [data-product-id="${productId}"] > .carrito-producto-subtotal > p`);
                cantidadElement.textContent = data.cantidad;
                subTotal.textContent = '$' + (precio * data.cantidad);
                document.querySelector('#total').textContent = '$' + getTotalPrecio();
                document.querySelectorAll('.btn-cantidad').forEach((btn) => {
                    btn.disabled = false;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                updatingCart = false;
            });
        }

        function vaciarCarrito() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('vaciar').submit();
                }
            });
        }

        function confirmDelete(productId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`eliminar-producto-${productId}`).submit();
                }
            });
        }
    </script>

    @if(session('success'))
        <script>
            Toastify({
                text: "Producto eliminado",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                background: "linear-gradient(to right, #4b33a8, #785ce9)",
                borderRadius: "2rem",
                textTransform: "uppercase",
                fontSize: ".75rem"
                },
                offset: {
                    x: '1.5rem',
                    y: '1.5rem'
                },
                onClick: function(){}
            }).showToast();
        </script>
    @endif
</body>
</html>