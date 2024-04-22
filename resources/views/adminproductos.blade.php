<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.theme.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.js"></script>
    <title>Document</title>
</head>
<body>
    <style>
        .boton-modal label {
            padding: 10px 15px;
            background-color: #5488a3;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: all 300ms ease;
        }

        .boton-modal label:hover {
            background-color: #18E583;
        }

    

        .contenedor-modal .content-modal {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #fff;
            border-radius: 4px;
        }

        .content-modal h2 {
            margin-bottom: 15px;
        }

    
        
    </style>
    
    <div class="contenedor-modal">
        <div style="border-radius:30px;" class="content-modal">
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
                            <input required type="text" class="form-control" name="categoria" id="txtCategoria" placeholder="categoria">
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
                            <!-- <button disabled style="margin-right: 15px;" type="submit" name="accion" value="Modificar" id="btnActualizar" class="btn btn-warning">Modificar</button>
                            <button type="button" name="accion" value="Cancelar" id="btnLimpiar" class="btn btn-info">Cancelar</button> -->
                        </div>
                    </form>
                </div>
            </div>
        
        </div>
        <div style="float: right; border: none; background: white; height: 550px; max-height: 550px; overflow: auto; width: 700px; margin-right: 60px; margin-top: -35%;" class="card col-sm-5 p-3">
            <table class="table table-bordered" id="product-table">
                <caption></caption>
                <thead>
                    <tr>
                        <th scope="col">BUSCAR:</th>
                        <th scope="col" colspan="14">
                            <input id="txtBuscar" style="background: transparent;" type="text" class="form-control" placeholder="Buscar por nombre">
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
    <!--fin de ventana naval-->
    <style>
        .card-img-top {
            border-radius: 50px;
            padding: 20px;
            height: 250px;
            width: 250px;
        }
    
        .card {
            border-radius: 30px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
        }
    </style>
    <h2></h2>

    <script>
        function confirmDelete(productId) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                document.getElementById('delete-form-' + productId).submit();
            }
        }
    </script>
</body>
</html>