<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ficha de EPI's: {{ $epi->employee->code }} </title>
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
            .info-grid {
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 20px;
                margin-bottom: 15px;
            }
            .label {
                font-weight: bold;
                color: #222;
            }
        </style>
    </head>
    <body>
        <h1>Ficha de EPI's: {{ $epi->employee->name }} </h1>
        <div class="section">
            <h2>Informações de identificação</h2>
            <div class="info-grid">
                <div><span class="label">Código:</span> {{ $epi->employee->code }}</div>
                <div><span class="label">Cargo:</span> {{ $epi->employee->adjuntancy }}</div>
                <div><span class="label">Nome:</span> {{ $epi->employee->name }}</div>
            </div>
        </div>

        <div class="section">
            <h2>Informações das expedições de EPI's</h2>
            @foreach($epi->detail as $details)
                <div class="info-grid">
                    <div><span class="label">Data da entrega:</span> {{ $details->expedition_date }}</div>
                    <div><span class="label">Nome do EPI:</span> {{ $details->name }}</div>
                    <div><span class="label">Quantidade:</span> {{ $details->quantity }}</div>
                    <div><span class="label">Descrição:</span> {{ $details->description }}</div>
                </div>
            @endforeach
        </div>
    </body>
    </html>
