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
            <img src="{{asset('/img/logo.jpeg')}}" alt="" style="border-radius: 100%; width: 6rem; height: 6rem;" class="logoo">
            <h1 class="logo">ArcaAcces</h1>
            <button class="open-menu" id="open-menu">
                <i class="bi bi-list"></i>
            </button>
        </header>
        <div class="wrapper" style="display: flex; grid-template-columns: none;">
            <header class="header">
                <h1 class="logo" style="position: relative; height: fit-content;"><a href="/" style="display: flex; gap: 1rem; justify-content: center; align-items: center; width: 100%;">
                    <img src="{{asset('/img/logo.jpeg')}}" alt="" style="position: relative; border-radius: 100%; width: 6rem; height: 6rem; top: inherit; margin: .5rem;" class="logoo">
                    <span>Regresar</span>
                </a></h1>
            </header>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h2>Misión</h2>
                <p>Ser la empresa líder en facilitar a los usuarios la búsqueda y adquisición de productos en El Salvador, brindando una experiencia de compra conveniente y segura.</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <h2>Visión</h2>
                <p>Convertirnos en la plataforma preferida por los salvadoreños para encontrar y comprar productos, ofreciendo un servicio excepcional y una amplia variedad de productos de calidad.</p>
            </div>
        </div>
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
    

</body>
</html>