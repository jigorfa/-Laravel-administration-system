<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários em Experiência</title>
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
    <h1>Funcionários em Experiência</h1>
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
            @forelse ($experiences as $experience)
                <tr>
                    <td>{{ $experience->code }}</td>
                    <td>{{ $experience->name }}</td>
                    <td>{!! '<button class="btn btn-sm btn-'. $experience->situation->color .'"disabled>' . $experience->situation->name . '</button>' !!}</td>
                    <td>{{ $experience->adjuntancy }}</td>
                    <td>{{ $experience->admission }}</td>
                    <td>{{ $experience->contract1 }}</td>
                    <td>{{ $experience->contract2 }}</td>
                    <td>{{ 'R$ ' . number_format($experience->salary, 2, ',', '.') }}</td>
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
