@extends('layouts.app')

@section('additionalHead')
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
@endsection

@section('hero')
<div class="flex flex-wrap items-center justify-between">
    <h1 class="text-3xl font-bold uppercase">Gestion des comptes</h1>
    <button id="open-modal" type="button" class="inline-flex items-center text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-800 hover:bg-blue-700 focus:ring-blue-700 border-blue-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 -ml-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Ajouter une opération
    </button>
</div>
@endsection

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-400">
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
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Action</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($operations as $operation)
            @if ($operation->last)
            <tr class="bg-gray-800">
                @else
            <tr class="border-b bg-gray-800 border-gray-700">
                @endif
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
                <td class="px-6 py-4 text-right flex justify-end">
                    <a href="{{ route('operations.edit', $operation) }}" class="font-medium text-blue-500 hover:underline open-edit-modal mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                    </a>

                    <!-- Delete action -->
                    <form action="{{ route('operations.destroy', $operation)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium cursor-pointer" title="Supprimer l'opération">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </form>
                    

                </td>
            <tr>
                @endforeach
        </tbody>
    </table>
    @php($totalBeneficit = App\Models\Operation::calculTotal())
    <div class="bg-gray-700 text-white px-6 py-3 font-bold text-right {{ ($totalBeneficit > 0) ? 'text-green-400' : 'text-red-400'}}">
        Total: {{$totalBeneficit}}€
    </div>
</div>

<!-- Modal -->
<div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <form action="{{ route('operations.store') }}" method="POST" class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="w-full">
                        <div class="mb-6">
                            <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom de l'opération</label>
                            <input type="text" id="nom" name="nom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>

                        <div class="mb-6">
                            <label for="categories" class="block mb-2 text-sm font-medium text-gray-900">Sélectionner une catégorie</label>
                            <select id="categories" name="categories" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @forelse($categories as $category)
                                <option value="{{$category->id}}">{{$category->nom}}</option>
                                @empty
                                <option disabled>Vous devez d'abord créer une catégorie</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type de l'opération</label>

                            <div class="flex items-center mb-4">
                                <input id="type-option-1" type="radio" name="type" value="0" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300">
                                <label for="type-option-1" class="block ml-2 text-sm font-medium text-gray-900">
                                    Débit
                                </label>
                            </div>

                            <div class="flex items-center mb-4">
                                <input id="type-option-2" type="radio" name="type" value="1" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300">
                                <label for="type-option-2" class="block ml-2 text-sm font-medium text-gray-900">
                                    Crédit
                                </label>
                            </div>
                        </div>


                        <div class="mb-6">
                            <label for="montant" class="block mb-2 text-sm font-medium text-gray-900">Montant</label>
                            <input type="number" name="montant" id="montant" step="any" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required>
                        </div>

                        <div class="mb-6">
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date (optionel)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input datepicker datepicker-format="dd/mm/yyyy" name="date" type="text" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-800 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Ajouter</button>
                    <button type="button" id="close-modal" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/datepicker.min.js"></script>

<script>
    // Open create operations modal
    const modal = document.getElementById('modal'),
        openBtn = document.getElementById('open-modal'),
        closeBtn = document.getElementById('close-modal');

    openBtn.onclick = function() {
        modal.style.display = 'block';
    };
    closeBtn.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection