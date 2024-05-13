<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArcaAcces</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <style>
        .modal-backdrop {
            display: none !important;
        }
        .modal-footer {
            justify-content: flex-start;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <header class="header-mobile">
            <h1 class="logo">ArcaAcces</h1>
            <button class="open-menu" id="open-menu">
                <i class="bi bi-list"></i>
            </button>
        </header>
        <aside>
            <button class="close-menu" id="close-menu">
                <i class="bi bi-x"></i>
            </button>
            <div style="display: flex; justify-content: space-between; box-sizing: border-box; padding: 1rem; align-items: center;">
                <img src="/img/logo.jpeg" alt="" style="border-radius: 100%; width: 6rem; height: 6rem;" class="logoo">

                <div class="icono-perfil">
                    @if (Auth::check())
                        <img src="{{ asset('image/' . Auth::user()->foto. '') }}" alt="Icono de perfil" class="profile-icon" data-bs-toggle="modal" id="modal.btn" data-bs-target="#Modalusuario">
                    @else
                        <a href="login">
                            <img src="/img/icono2.jpeg" alt="Icono de perfil" class="profile-icon">
                        </a>
                    @endif
                </div>
            </div>
            
            <!--INCIO DE VENTANA USUARIO-->
            
            
            <!--FIN DE VENTANA USUARIO-->
            <nav>
                <ul class="menu">
                    <li>
                        <button id="todos" class="boton-menu boton-categoria active"><i class="bi bi-hand-index-thumb-fill"></i> Todos los productos</button>
                    </li>
                    <li>
                        <button id="Relojes" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Relojes</button>
                    </li>
                    <li>
                        <button id="Cargadores" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Cargadores</button>
                    </li>
                    <li>
                        <button id="Protectores" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Protectores</button>
                    </li>
                    <li>
                        <button id="Audifonos" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Audifonos</button>
                    </li>
                    
                    <li>
                        <a class="boton-menu boton-carrito" href="{{ route('carrito') }}">
                            <i class="bi bi-cart-fill"></i> Carrito <span id="numerito" class="numerito">
                                @php
                                    $totalProductos = 0;
                                    foreach ($carrito as $producto) {
                                        $totalProductos += $producto['cantidad'];
                                    }
                                    echo $totalProductos;
                                @endphp
                            </span>
                        </a>
                    </li>
                    @if (Auth::check() && Auth::user()->admin == 1)
                    <li>
                    <a class="boton-menu boton-carrito" href="{{ route('productos') }}" style="margin: 0; padding-top: 0;">
                            <i class="bi bi-hand-index-thumb"></i> Administrador
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© 2024 Arca Acces</p>
            </footer>
        </aside>
        <main>
            <form class="d-flex" role="search" id="searchForm" action="{{ route('home') }}" method="get">
                <input class="form-control me-2" type="search" name="search" placeholder="Buscar producto" aria-label="Search" id="searchInput">
                <button class="btn btn-outline-success" type="submit"><em class="fa-solid fa-magnifying-glass"></em> buscar</button>
                <br>
            </form>
            <h2 class="titulo-principal" id="titulo-principal">Todos los productos</h2>
            <div id="contenedor-productos" class="contenedor-productos">
                <?php foreach($products as $product): ?>
                    <div class="producto producto-card" data-categoria="<?= $product->categoria ?>">
                        <img class="producto-imagen" src="{{ asset('image/' .$product->imagen. '') }}" alt="<?= $product->nombre ?>">
                        <div class="producto-detalles">
                            <h3 class="producto-titulo"><?= $product->nombre ?></h3>
                            <p class="producto-precio">$<?= $product->precio ?></p>
                            <form action="{{ route('carrito.store') }}" method="POST" class="w-3/4 px-4 flex gap-4">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <button class="producto-agregar" type="submit" >Agregar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>


    <div class="container-fluid">
    <div class="row p-5 pb-2 bg-dark text-white">
        <div class="col-xs-12 col-md-6 col-lg-3">
        <img alt="logo" src="/img/logo.jpeg" style="height: 100px; border-radius: 100%;">

        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
        <p class="h5 text-white">Sobre nosotros</p>
        <div class="mb-2">
            <span>Somos una empresa que busca facilitar a los usuarios sobre la busqueda de productos en el salvador</span>
        </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
        <p class="h5 text-white">Acerca de</p>
        <div class="mb-2">
            <a class="text-white text-decoration-none" href="#">politicas y privacidad</a>
        </div>
        <div class="mb-2">
            <a class="text-white text-decoration-none" href="#">Terminos y condiciones</a>
        </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-3">
        <p class="h5 text-white">Redes sociales</p>
        <div class="mb-2">
            <em class="fa-brands fa-facebook-f"></em>
            <a class="text-white text-decoration-none" href="#"> Facebook</a>
        </div>
        <div class="mb-2">
            <em class="fa-brands fa-instagram"></em>
            <a class="text-white text-decoration-none" href="#"> Instagram</a>
        </div>
        <div class="mb-2">
            <em class="fa-brands fa-twitter"></em>
            <a class="text-white text-decoration-none" href="#">Twitter</a>
        </div>

        </div>
        <div class="col-xs-12 pt-3">

        <p class="text-white text-center"> CopyRight - All rights reserved 2023</p>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modalusuario" aria-labelledby="ModalLabelusuario" aria-hidden="true" style="z-index: 1000;">
        <div class="modal-dialog">
            <div style="background-color: rgba(0, 0, 0, 0.6); color: #ffffff;" class="modal-content">
                <div class="modal-header" style="justify-content: flex-start;">
                    <a class="navbar-brand p-0" href="#">
                    <img src="img/logo2.png" style="height: 70px; border: 2px solid #fff; border-radius: 50%;">
                    </a>
                    <a style="text-decoration: none; color: white; float: rith; display: block; padding-top: 9px;" href="#">
                    <h5> Juan Carlos</h5>

                    </a>
                </div>
                
                <div class="modal-body">
                    <!-- Button Mis Citas reservadas -->
                    <button style="color: #fff; background: transparent; border:none;" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <h5 style="font-weight: 300;"> Información de cuenta</h5>
                    </button>
                </div>
                <div class="modal-footer">
                    <!-- Button Mis marcadores -->
                    <button style="color: #fff; background: transparent; border:none; margin-right: 299px;" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <h5 style="font-weight: 300;">Historial de pedidos</h5>
                    </button>
                </div>
                
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button style="color: #fff; background: transparent; border:none; margin-right: 320px;" type="submit">
                    <h5 style="font-weight: 300;"><i class="fa-solid fa-arrow-right-from-bracket"></i> <a style="text-decoration: none; color: white;">Cerrar sesion</a></h5>
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- <script src="./js/main.js"></script> -->
    <script src="./js/menu.js"></script>

    @if(session('success'))
        <script>
            Toastify({
                text: "Producto agregado",
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