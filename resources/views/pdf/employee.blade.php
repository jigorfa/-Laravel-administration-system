<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha do funcionário: {{$employee->code}} </title>

    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 30px;
        color: #333;
        line-height: 1.3;
        text-align: justify;
    }

    h1 {
        text-align: center;
        color: #444;
        margin-bottom: 20px;
        font-size: 24px;
        text-transform: uppercase;
    }

    h2 {
        color: #555;
        font-size: 18px;
        margin-bottom: 10px;
        border-bottom: 2px solid #ccc;
        padding-bottom: 5px;
    }

    .section {
        margin-bottom: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
    }

    .label {
        font-weight: bold;
        color: #222;
        margin-right: 5px;
    }

    .info-grid div {
        padding: 5px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    </style>
</head>
<body>
    <h1>Ficha do funcionário: {{ $employee->name }}</h1>
    <div class="section">
        <h2>Informações documentais</h2>
        <div class="info-grid">
            <div><span class="label">Nome:</span> {{ $employee->name }}</div>
            <div><span class="label">Data de Nascimento:</span> {{ $employee->birth_date }}</div>
            <div><span class="label">Nacionalidade:</span> {{ $employee->nationality }}</div>
            <div><span class="label">Naturalidade:</span> {{ $employee->naturalness }}</div>
            <div><span class="label">Cor/Raça:</span> {{ $employee->color->name }}</div>
            <div><span class="label">Sexo:</span> {{ $employee->gender->name }}</div>
            <div><span class="label">CPF:</span> {{ $employee->cpf_code }}</div>
            <div><span class="label">CTPS:</span> {{ $employee->ctps_code }}</div>
            <div><span class="label">PIS:</span> {{ $employee->pis_code }}</div>
            <div><span class="label">Título de Eleitor:</span> {{ $employee->vote_code }}</div>
            <div><span class="label">CNH:</span> {{ $employee->license }}</div>
            <div><span class="label">Telefone:</span> {{ $employee->telephone }}</div>
            <div><span class="label">Grau de instrução:</span> {{ $employee->instruction->name }}</div>
            <div><span class="label">Estado Civil:</span> {{ $employee->civil_state->name }}</div>
        </div>
    </div>

    <div class="section">
        <h2>Informações de endereço</h2>
        <div class="info-grid">
            <div><span class="label">CEP:</span> {{ $employee->postal_code }}</div>
            <div><span class="label">Endereço:</span> {{ $employee->address }}</div>
        </div>
    </div>

    <div class="section">
        <h2>Informações contratuais</h2>
        <div class="info-grid">
            <div><span class="label">Empresa:</span> {{ $employee->enterprise->name }}</div>
            <div><span class="label">Situação:</span> {{ $employee->situation->name }}</div>
            <div><span class="label">Código:</span> {{ $employee->code }}</div>
            <div><span class="label">Cargo:</span> {{ $employee->adjuntancy }}</div>
            <div><span class="label">Admissão:</span> {{ $employee->admission }}</div>
            @if (!empty($employee->demission))
                <div><span class="label">Demissão:</span> {{ $employee->demission }}</div>
            @endif
            <div><span class="label">1º Contrato:</span> {{ $employee->contract1 }}</div>
            <div><span class="label">2º Contrato:</span> {{ $employee->contract2 }}</div>
            <div><span class="label">Salário:</span> R$ {{ number_format($employee->salary, 2, ',', '.') }}</div>
        </div>
    </div>
</body>
</html>

