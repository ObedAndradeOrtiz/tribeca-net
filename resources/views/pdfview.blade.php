<!DOCTYPE html>
<html>

<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>
    @php
        $usuario = DB::table('users')->where('id', $idusuario)->get();

    @endphp
    @foreach ($usuario as $item)
        <h1>HISTORIAL LLAMADAS AGENDADAS</h1>
        <h2>NOMBRE: {{ $item->name }}</h2>
        @php
            $misllamada = DB::table('calls')
                ->where('responsable', $item->name)
                ->whereDate('fecha', now()->toDateString()) // Filtra por la fecha actual
                ->orderBy('area')
                ->get();
            $cantidad = DB::table('calls')
                ->where('responsable', $item->name)
                ->where('estado', '!=', 'llamadas')
                ->whereDate('fecha', now()->toDateString())
                ->count();
            $misagendados = DB::table('calls')
                ->where('responsable', $item->name)
                ->where('estado', '!=', 'llamadas')
                ->whereDate('fecha', now()->toDateString())
                ->orderBy('area')
                ->get();
        @endphp
    @endforeach
    <h2>FECHA: <?php echo date('Y-m-d'); ?></h2>
    <h2>CANTIDAD: {{ $cantidad }}</h2>
    <table id="customers">
        <tr>
            <th>SUCURSAL</th>
            <th>NOMBRE CLIENTE</th>
            @foreach ($misagendados as $item)
        <tr>
            <td>{{ $item->area }}</td>
            <td>{{ $item->empresa }}</td>
        </tr>
        @endforeach
    </table>
    <h1>HISTORIAL LLAMADAS REALIZADAS</h1>
    <h2>FECHA: <?php echo date('Y-m-d'); ?></h2>
    @foreach ($usuario as $item)
        @php
            $cantidad = DB::table('calls')
                ->where('responsable', $item->name)
                ->whereDate('fecha', now()->toDateString())
                ->count();
        @endphp
    @endforeach
    <h2>CANTIDAD: {{ $cantidad }}</h2>
    <table id="customers">
        <tr>
            <th>SUCURSAL</th>
            <th>NOMBRE CLIENTE</th>
            @foreach ($misllamada as $item)
        <tr>
            <td>{{ $item->area }}</td>
            <td>{{ $item->empresa }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>
