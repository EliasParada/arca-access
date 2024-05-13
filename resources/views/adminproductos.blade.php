<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.theme.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.js"></script>
    <title>Administrar Productos</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .contenedor-modal {
            display: flex;
            gap: 2rem;
            align-items: center;
            justify-content: space-around;
        }

        .content-modal {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 30px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 30px 30px 0 0;
        }

        .btn-outline-success {
            color: #28a745;
            border-color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: #fff;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
            background-color: #007bff;
            color: #fff;
        }

        .table-bordered tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-bordered tbody tr:last-of-type td {
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered tbody tr:hover td,
        .table-bordered tbody tr:hover th {
            background-color: #f8f9fa;
        }

        .card-img-top {
            border-radius: 50px;
            padding: 20px;
            height: 250px;
            width: 250px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>

<body>
    <div style="width: 100%; text-align: center;">

    <h1 class="text-2xl font-semibold m-auto mb-4">Listado de Productos</h1>
    </div>

    <div class="contenedor-modal">
        <div style="display: flex; flex-direction: column; justify-content: flex-start;">
            <div class="m-4">
                <a href="{{ route('pedidos') }}" class="btn-primary btn">Ver pedidos</a>
            </div>
            
            <div class="m-4">
                <a href="{{ route('home') }}" class="btn-primary btn">Ver tienda</a>
            </div>
        </div>
        <div class="content-modal">
            <div class="card">
                <div class="card-header">
                    Datos de productos
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data" id="product-form">
                        @csrf
                        <div style="display:none;" class="form-group">
                            <label for="txtID">ID:</label>
                            <input disabled type="text" class="form-control" name="txtID" id="txtID" placeholder="ID">
                        </div>
                        <input type="hidden" name="accion" value="insert">

                        <div class="form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input required type="text" class="form-control" name="nombre" id="txtNombre" placeholder="Nombre del producto">
                        </div>

                        <div class="form-group">
                            <label for="txtDescripcion">Descripcion:</label>
                            <input required type="text" class="form-control" name="descripcion" id="txtDescripcion" placeholder="Descripcion del producto">
                        </div>
                        <div class="form-group">
                            <label for="txtCategoria">Cayegoría:</label>
                            <select name="categoria" id="txtCategoria" class="form-control">
                                <option value="Relojes">Relojes</option>
                                <option value="Cargadores">Cargadores</option>
                                <option value="Protectores">Protectores</option>
                                <option value="Audifonos">Audifonos</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtproveedor">Nombre del proveedor:</label>
                            <input required type="text" class="form-control" name="proveedor" id="txtproveedor" placeholder="proveedor">
                        </div>



                        <div class="form-group">
                            <div class="form-group">
                                <label for="txtfecha">Fecha de publicacion</label>
                                <input required type="date" class="form-control" name="fecha" id="txtfecha">
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="txtPrecio">Precio:</label>
                            <input required type="text" class="form-control" name="precio" id="txtPrecio" placeholder="Precio del producto">
                        </div>

                        <div class="form-group">
                            <label for="txtimagen">Imagen o foto del producto:</label>
                            <input required type="file" class="form-control" name="imagen" id="txtimagen" placeholder="">
                        </div>

                        <div style="margin-top: 10px;" class="btn-group" role="group" aria-label="">
                            <button style="margin-right: 15px;" type="submit" name="accion" value="Agregar" id="btnAgregar" class="btn btn-success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="card col-sm-5 p-3" style="max-height: 95vh; overflow: auto;">
            <table class="table table-bordered" id="product-table">
                <caption></caption>
                <thead>
                    <tr>
                        <th scope="col">BUSCAR:</th>
                        <th scope="col" colspan="14">
                            <form class="d-flex" role="search" id="searchForm" action="{{ route('productos') }}" method="get">
                                <input class="form-control me-2" type="search" name="search" placeholder="Buscar producto" aria-label="Search" id="searchInput">
                                <button class="btn btn-outline-success" type="submit"><em class="fa-solid fa-magnifying-glass"></em> buscar</button>
                                <br>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Fecha de publicacion</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->nombre }}</td>
                        <td>{{ $product->descripcion }}</td>
                        <td>{{ $product->proveedor }}</td>
                        <td>{{ $product->fecha }}</td>
                        <td>{{ $product->precio }}</td>
                        <td>
                            <img src="{{ asset('image/' . $product->imagen) }}" alt="{{ $product->nombre }}" style="width: 100px; height: auto;">
                        </td>
                        <td>
                            <form action="{{ route('productos.destroy', $product->id) }}" method="POST" id="delete-form-{{ $product->id }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $product->id }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(productId) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                document.getElementById('delete-form-' + productId).submit();
            }
        }
    </script>
</body>

</html>
