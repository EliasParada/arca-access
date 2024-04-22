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
                @if (count($carrito) > 0)
                    <div id="carrito-productos" class="carrito-productos">
                        @foreach ($carrito as $producto)
                            <div class="carrito-producto">
                                <img class="carrito-producto-imagen" src="{{ asset('image/' .$producto['imagenes']. '') }}" alt="{{ $producto['nombre'] }}">
                                <div class="carrito-producto-titulo">
                                    <small>Título</small>
                                    <h3>{{ $producto['nombre'] }}</h3>
                                </div>
                                <div class="carrito-producto-cantidad">
                                    <small>Cantidad</small>
                                    <p>{{ $producto['cantidad'] }}</p>
                                </div>
                                <div class="carrito-producto-precio">
                                    <small>Precio</small>
                                    <p>${{ $producto['precio_unidad'] }}</p>
                                </div>
                                <div class="carrito-producto-subtotal">
                                    <small>Subtotal</small>
                                    <p>${{ $producto['precio_unidad'] * $producto['cantidad'] }}</p>
                                </div>
                                <form action="{{ route('carrito.eliminar', $producto['producto_id']) }}" method="POST">
                                    @csrf
                                    <button class="carrito-producto-eliminar" id=""><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p id="carrito-vacio" class="carrito-vacio">Tu carrito está vacío. <i class="bi bi-emoji-frown"></i></p>
                @endif

                <div id="carrito-acciones" class="carrito-acciones">
                    <div class="carrito-acciones-izquierda">
                        <form action="{{ route('carrito.vaciar') }}" method="POST">
                            @csrf
                            <button type="submit" id="carrito-acciones-vaciar" class="carrito-acciones-vaciar">Vaciar carrito</button>
                        </form>
                    </div>
                    <div class="carrito-acciones-derecha">
                        <div class="carrito-acciones-total">
                            <p>Total:</p>
                            <p id="total">$3000</p>
                        </div>
                        <button id="carrito-acciones-comprar" class="carrito-acciones-comprar">Comprar ahora</button>
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
        function confirmDelete(productId) {
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'question',
                html: `Se van a borrar ${productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0)} productos.`,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    productosEnCarrito.length = 0;
                    localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
                    cargarProductosCarrito();
                }
            })
        }
    </script>

    @if(session('success'))
        <script>
            Toastify({
                text: "Producto eliminado",
                duration: 3000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                background: "linear-gradient(to right, #4b33a8, #785ce9)",
                borderRadius: "2rem",
                textTransform: "uppercase",
                fontSize: ".75rem"
                },
                offset: {
                    x: '1.5rem', // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: '1.5rem' // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
                onClick: function(){} // Callback after click
            }).showToast();
        </script>
    @endif
</body>
</html>