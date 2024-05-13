<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.theme.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.js"></script>
    <title>Administrar Pedidos</title>
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
    
    <div class="contenedor-modal" style="display: flex; gap: 2rem; align-items: center; justify-content: space-around;">
         
    <div class="container mx-auto mt-8">
    <h1 class="text-2xl font-semibold mb-4">Listado de Facturas</h1>

    <div class="">
            <a href="{{ route('pedidos') }}" class="btn-primary btn">Ver productos</a>
        </div>

    @if ($facturas->isNotEmpty())
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="px-4 py-2">Número de Factura</th>
                    <th class="px-4 py-2">Cliente</th>
                    <th class="px-4 py-2">Detalles de la Compra</th>
                    <th class="px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $factura)
                <tr>
                    <td class="px-4 py-2">{{ $factura->nombre }}</td>
                    <td class="px-4 py-2">{{ $factura->usuarios->lastname }}, {{ $factura->usuarios->name }} ({{ $factura->usuarios->email }})</td>
                    <td class="px-4 py-2">
                        <ul>
                            @foreach ($factura->detalles as $detalle)
                            <li>{{ $detalle->cantidad }} x {{ $detalle->productos->nombre }} - ${{ $detalle->productos->precio }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-4 py-2">${{ $factura->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No hay facturas disponibles.</p>
    @endif
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