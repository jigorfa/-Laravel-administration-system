<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF atrasos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Consulta PDF: atrasos</h1>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Data do atraso</th>
                <th>Hora de chegada</th>
                <th>Hora de saída</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendance as $attendances)
                <tr>
                    <td>{{ $attendances->code }}</td>
                    <td>{{ $attendances->name }}</td>
                    <td>{{ $attendances->adjuntancy }}</td>
                    <td>{{ $attendances->delay_date }}</td>
                    <td>{{ $attendances->arrival }}</td>
                    <td>{{ $attendances->leave }}</td>
                    <td>{{ $attendances->motive }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="color: red;">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
