<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF atestados</title>
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
    <h1>Consulta PDF: atestados</h1>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Data de início</th>
                <th>Data de término</th>
                <th>Dias ausentes</th>
                <th>Causa social</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attest as $attests)
                <tr>
                    <td>{{ $attests->code }}</td>
                    <td>{{ $attests->name }}</td>
                    <td>{{ $attests->adjuntancy }}</td>
                    <td>{{ $attests->start_date }}</td>
                    <td>{{ $attests->end_date }}</td>
                    <td>{{ $attests->total_days }}</td>
                    <td>{{ $attests->cause }}</td>
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
