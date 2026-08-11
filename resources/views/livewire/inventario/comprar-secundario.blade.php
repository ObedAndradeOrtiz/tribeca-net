<div class="container px-6 py-4">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('myButton').click();
            }, 1);
        });
    </script>

    <style>
        .list-group-item {
            cursor: pointer;
            z-index: 1000;
        }

        .list-group-item:hover {
            background-color: #0a0a0a3f;
        }

        # {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
        }

        # .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #52b1e5;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="mb-4 text-lg font-medium text-gray-900">
        Venta de productos:
    </div>

    <div class="mb-4 row">
        <div class="col-md-6">
            <label for="motivo">Motivo de uso: </label>
            <select class="form-control form-control-lg" wire:model="motivo">
                <option value="compra">Cargo a la habitación</option>
                <option value="personal">Uso interno</option>
                <option value="farmacia">Venta directa</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="sucursal">Sucursal: </label>
            <select class="form-control form-control-lg" wire:model="sucursalseleccionada">
                @foreach ($areas as $item)
                    <option value="{{ $item->id }}">{{ $item->area }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($motivo == 'compra')
    <div class="mb-4" style="position: relative;">
        <label for="">Lista de habitaciones</label>
        <input type="text" class="form-control" wire:model="searchcliente" placeholder="Buscar habitación...">
        @if(!empty($searchcliente))
        <ul class="mt-2 list-group">
            @forelse($clientes as $cliente)
                <li wire:click="seleccionarhabitacion({{ $cliente->id }})" class="list-group-item">
                    {{ $cliente->nombre }}
                </li>
            @empty
                <li class="list-group-item">No se encontraron resultados</li>
            @endforelse
        </ul>
        @endif
    </div>
    @endif

    @if ($motivo == 'farmacia')
    <div class="mb-4">
        <label for="nombre">Nombre: </label>
        <input type="text" class="form-control" wire:model="nombre" placeholder="Escriba el nombre...">
        <div class="mt-2 d-flex justify-content-between">
            <label class="h5">Modo de pago: </label>
            <select class="form-control form-control-lg" wire:model="modo">
                <option value="efectivo">Efectivo</option>
                <option value="qr">QR</option>
            </select>
        </div>
        <div class="mt-2 d-flex justify-content-end">
            <label class="h5">Total: {{ $pagar }}</label>
        </div>
    </div>
    @endif

    @if ($motivo == 'traspaso')
    <div class="mb-4">
        <label for="areaseleccionada">Lista de sucursales: </label>
        <select class="form-control form-control-lg" wire:model="areaseleccionada">
            <option>Seleccione sucursal</option>
            @foreach ($areas as $item)
                <option value="{{ $item->area }}">{{ $item->area }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="mb-4 table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>PRODUCTO SELECCIONADO</th>
                    <th>PRECIO</th>
                    <th>CANTIDAD</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cantidades as $id => $cantidad)
                    @php
                        $producto = DB::table('productos')->select('nombre')->where('id', $id)->first();
                    @endphp
                    @if ($producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ floatval($this->precios[$id]) }}</td>
                            <td>{{ $cantidad }}</td>
                            <td>{{ floatval($this->precios[$id]) * $cantidad }}</td>
                            @php
                                $total += floatval($this->precios[$id]) * $cantidad;
                            @endphp
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="3" class="text-right">TOTAL</td>
                    <td>{{ $total }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        <div class="d-flex justify-content-end">
            @if ($motivo == 'traspaso')
                <button wire:click="realizartraspaso" class="btn btn-success">Traspasar</button>
            @endif
            @if ($motivo == 'compra' || $motivo == 'personal')
                @if ($motivo == 'compra')
                @if ($habitacion)
                <h2>CARGO A HABITACION: {{$habitacion->nombre}}</h2>
                @endif

                @endif
                <button wire:click="realizarCompra" class="ml-1 btn btn-warning">Registrar</button>
            @endif
            @if ($motivo == 'farmacia')
                <button wire:click="realizarfarmacia" class="btn btn-warning">Vender</button>
            @endif
        </div>
    </div>

    <div class="mb-4">
        <input class="mt-1 form-control" type="text" wire:model="search" placeholder="Buscar productos...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>
                            <input type="number" class="form-control" wire:model="cantidades.{{ $producto->id }}" min="0">
                        </td>
                        <td>
                            <input type="number" class="form-control" wire:model="precios.{{ $producto->id }}" value="{{ $producto->precio }}">
                        </td>
                        <td>{{ $producto->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $productos->links() }}
        </div>
    </div>
</div>

<div id="">
    <div class="spinner"></div>
</div>

<script>
    document.addEventListener("livewire:load", function() {
        Livewire.hook('message.sent', function() {
            document.getElementById('').style.display = 'flex';
        });

        Livewire.hook('message.processed', function() {
            document.getElementById('').style.display = 'none';
        });
    });
</script>
