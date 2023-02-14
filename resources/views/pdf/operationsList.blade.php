<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}} - Bilan comptable</title>

    <style>
        * {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            margin: 0;
        }

        table {
            color: rgb(156 163 175);
            width: 100%;
        }

        thead {
            color: rgb(156 163 175);
            background-color: rgb(55 65 81);
            text-transform: uppercase;
            font-size: .5rem;
            line-height: .75rem;

        }

        tbody tr {
            background-color: rgb(31, 41, 55);
            border: 0;
            border-bottom: 1px solid rgb(55 65 81);
            font-size: .75rem;
            line-height: 1rem;
        }

        tbody tr:last-child {
            border-bottom: 0;
        }

        .px-6.py-3 {
            padding: .75rem 1.5rem;
        }

        .px-6.py-4 {
            padding: 1rem 1.5rem;
        }

        .totalContainer {
            background-color: rgb(55 65 81);
            color: rgb(249 128 128);
            font-weight: 700;
            text-align: right;
        }
        .table-container{
            width: 95%;
            margin: 32px auto;
        }

        .table-head {
            width: 100%;
            padding: 1.5rem 1.5rem 0;
            background-color: rgb(31 41 55);
            color: white
        }
        .table-head span {
            vertical-align: middle;
        }

        h1, .filters-detail{margin-bottom: 1rem;}
        .py-4{padding: 1rem;}
        .text-center{text-align: center;}

        .filters-detail{
            font-size: .75rem;
            line-height: 1rem;
            color:rgb(156 163 175)
        }
    </style>
</head>

<body>

    <div class="table-head">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png')))}}" alt="Logo BilanPlus" style="width: 45px; height: 45px;">
        <span>BilanPlus</span>
    </div>
    <div class="table-container">
        <h1>Bilan Comptable</h1>

        @if($filtersList)
            <div class="filters-detail">
                {!! $filtersList !!}
            </div>
        @endif

        <table cellspacing="0" cellpadding="0">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nom
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Catégorie
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Débit
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Crédit
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($operations as $operation)
                <tr>
                    <th scope="row" class="px-6 py-4">
                        {{ $operation->id }}
                    </th>
                    <td class="px-6 py-4">
                        {{ Carbon\Carbon::parse($operation->date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $operation->nom }}
                    </td>
                    <td class="px-6 py-4">
                        {{ App\Models\Categorie::getNomCategorie($operation->categorieId)}}
                    </td>
                    <td class="px-6 py-4">
                        @if (!$operation->estCredit)
                        {{ $operation->montant}}
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if ($operation->estCredit)
                        {{ $operation->montant}}
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="bg-gray-800">
                    <td colspan="7" class="text-center py-4">
                        Aucune opération..
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="totalContainer px-6 py-3 {{ ($totalOpeFiltrer > 0) ? 'text-green-400' : 'text-red-400'}}">
            Total: {{$totalOpeFiltrer}}€
        </div>
    </div>
</body>

</html>