<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $fileName }}</title>
    <style type="text/css" media="all">
        * {
            font-family: DejaVu Sans, sans-serif !important;
            font-size: 15px;
        }

        html{
            width:100%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-radius: 10px 10px 10px 10px;
        }

        table td,
        th {
            border-color: #ededed;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        table th {
            font-weight: normal;
        }
        .title{
            text-align: center;
            font-size: 22px;
        }
        .subtitle{
            font-size: 16px;
        }
        .label{
            font-weight: bold;
            color: #242424;
        }
        .info{
            margin: 30px 0 40px 0;
            display: inline-block;
            max-width: 50%;
        }

    </style>
</head>
<body>
<h1 class="title">Gerenciador de Patrimônio</h1>
<hr>

<div class="info">
    <h2 class="subtitle">Governo de São Domingos do Araguaia</h2>
    <table>
        <tr>
            <th><b>Data da emissão: </b> {{ $date }}</th>
            <th><b>Quantidade de Bens:</b> {{ $recordCount }}</th>
            <th><b>Valor total:</b> R$ {{ $sum }}</th>
        </tr>
    </table>
</div>
<table>
    <tr>
        @foreach ($columns as $column)
            <th>
                <span class="label">{{ $column->getLabel() }}</span>
            </th>
        @endforeach
    </tr>
    @foreach ($rows as $row)
        <tr>
            @foreach ($columns as $column)
                <td>

                    @if(stripos($row[$column->getName()], '.pdf'))
                        <a href="{{ public_path("/storage/".$row[$column->getName()]) }}" target="_blank" download>Baixar Nota</a>

                    @else
                        {{ $row[$column->getName()] }}
                    @endif



                </td>
            @endforeach
        </tr>
    @endforeach
</table>
</body>
</html>
