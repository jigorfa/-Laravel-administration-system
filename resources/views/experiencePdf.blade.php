<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF funcionários</title>
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
    <h1>Consulta PDF: funcionários</h1>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Situação</th>
                <th>Cargo</th>
                <th>Admissão</th>
                <th>1º Contrato</th>
                <th>2º Contrato</th>
                <th>Salário (R$)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($experience as $experiences)
                <tr>
                    <td>{{ $experiences->code }}</td>
                    <td>{{ $experiences->name }}</td>
                    <td>{{ $experiences->situation->name }}</td>
                    <td>{{ $experiences->adjuntancy }}</td>
                    <td>{{ $experiences->admission }}</td>
                    <td>{{ $experiences->contract1 }}</td>
                    <td>{{ $experiences->contract2 }}</td>
                    <td>{{ 'R$ ' . number_format($experiences->salary, 2, ',', '.') }}</td>
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
