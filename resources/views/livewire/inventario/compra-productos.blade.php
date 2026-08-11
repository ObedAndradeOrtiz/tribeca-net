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

    <div class="text-lg font-medium text-gray-900 mb-4">
        Compra de productos:
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <label for="sucursal">Sucursal: </label>
            <select class="form-control form-control-lg" wire:model="sucursalseleccionada">
                <option value="{{ $areas->id }}">{{ $areas->area }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <div class="mb-4">
                <label for="cartera">Cartera de egreso:</label>
                <select class="form-control form-select-lg" wire:model="cartera">
                    <option value="Caja">Caja central</option>
                    <option value="Externo">Externo</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div>
                <label>Modo de pago: </label>
                <select class="form-control form-select-lg" wire:model="modo">
                    <option value="efectivo">Efectivo</option>
                    <option value="qr">QR</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="cantidad">Cantidad de gasto: </label>
                <input type="number" class="form-control" wire:model="nombre" placeholder="Escriba la cantidad...">

            </div>
        </div>
        <div class="col-md-2">
                <div class="mb-4 mt-4 py-2">
                    <button wire:click="realizarfarmacia" class="btn btn-warning">Comprar</button>
                </div>
        </div>
    </div>
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>PRODUCTO SELECCIONADO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cantidades as $id => $cantidad)
                    @php
                        $producto = DB::table('productos')->select('nombre')->where('id', $id)->first();
                    @endphp
                    @if ($producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $cantidad }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex mb-4">
        <input type="text" class="form-control" wire:model.defer="search" placeholder="Buscar productos...">
        <button class="btn btn-warning ml-2" wire:click="buscar">Buscar</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td>
                            <input type="number" class="form-control" wire:model="cantidades.{{ $producto->id }}"
                                min="0">
                        </td>
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
