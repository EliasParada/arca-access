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
    <style>
        .contenedor-carrito {
            max-width: 600px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group p {
            margin: 0;
            font-weight: bold;
        }
        .form-group label input[type="radio"] {
            margin-right: 10px;
        }
        button[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
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
                        <a class="boton-menu boton-volver" href="{{ route('carrito') }}">
                            <i class="bi bi-arrow-return-left"></i> Carrito
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu boton-carrito active" href="">
                            <i class="bi bi-cart-fill"></i> Metodo de pago
                        </a>
                    </li>
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© 2022 Arca Acces</p>
            </footer>
        </aside>
        <main>
            <h2 class="titulo-principal">Continuar con el pago</h2>
            <div class="contenedor-carrito">
                <form action="{{ route('cobrar') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="direccion">Dirección de entrega:</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <p>Selecciona un método de pago:</p>
                        <label>
                            <input type="radio" name="metodo_pago" value="pagadito" checked>
                            Pago en línea por Pagadito
                        </label><br>
                        <label>
                            <input type="radio" name="metodo_pago" value="contraentrega">
                            Pago contra entrega
                        </label>
                    </div>
                    <button type="submit">Realizar Pago</button>
                </form>
            </div>
        </main>
    </div>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="./js/carrito.js"></script> -->
    <script src="./js/menu.js"></script>
    
</body>
</html>