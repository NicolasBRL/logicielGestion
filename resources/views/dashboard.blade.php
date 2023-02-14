@extends('layouts.app')

@section('hero')
<div class="flex flex-wrap items-center justify-between">
    <h1 class="text-3xl font-bold uppercase">Gestion des comptes</h1>
    <button type="button" data-modal-id="create-operation-modal" class="inline-flex items-center text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-800 hover:bg-blue-700 focus:ring-blue-700 border-blue-700 open-modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 -ml-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Ajouter une opération
    </button>
</div>
@endsection

@section('content')
<form action="{{ route('dashboard') }}" method="GET">
    @csrf
    <input type="hidden" name="filtreOperations">

    <div class="w-full flex items-center mb-6">

        Filtrer par :
        <div class="ml-6">
            <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" class="text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center" type="button">Catégories <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg></button>

            <div id="dropdownDefaultCheckbox" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
                    @foreach($categories as $category)
                    <li>
                        <div class="flex items-center">
                            <input id="categorieFiltre-{{$category->id}}" name="categorieFiltre[]" type="checkbox" value="{{$category->id}}" {{ ((isset($filtersList) && isset($filtersList['categories'])) && in_array($category->id, $filtersList['categories'])) ? 'checked' : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="categorieFiltre-{{$category->id}}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$category->nom}}</label>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="ml-6 flex items-center">
            <select id="filtreDateType" name="filtreDateType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-fit p-2.5">
                <option value="before" {{(isset($filtersList) && $filtersList['filtreDateType'] === 'before') ? 'selected' : ''}}>Avant le</option>
                <option value="between" {{(isset($filtersList) && $filtersList['filtreDateType'] === 'between') ? 'selected' : ''}}>Entre le</option>
                <option value="after" {{(isset($filtersList) && $filtersList['filtreDateType'] === 'after') ? 'selected' : ''}}>Après le</option>
            </select>

            <div class="flex items-center ml-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    
                    <input name="filterFirstDate" type="text" datepicker datepicker-format="dd/mm/yyyy" autocomplete="off" {{(isset($filtersList) && isset($filtersList['filterFirstDate'])) ? 'value='.$filtersList['filterFirstDate'] : ''}} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Sélectionne la date">
                </div>
                <div class="flex items-center {{(isset($filtersList) && $filtersList['filtreDateType'] === 'between') ? '' : 'hidden'}}" id="secondDateInput">
                    <span class="mx-4 text-gray-500">et</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input name="filterSecondDate" type="text" datepicker datepicker-format="dd/mm/yyyy" autocomplete="off" {{(isset($filtersList) && isset($filtersList['filterSecondDate'])) ? 'value='.$filtersList['filterSecondDate'] : ''}} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Sélectionne la date">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-800 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Filtrer</button>
        
        @if(isset($filtersList))
        <div class="ml-auto">
            <a href="{{route('dashboard')}}" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-800 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Supprimer les filtres</a>
        </div>
        @endif
    </div>
</form>

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
            @forelse ($operations as $operation)
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
                        <button type="submit" class="font-medium cursor-pointer open-modal" title="Supprimer l'opération" data-modal-id="delete-operation-modal" data-operation-id="{{ $operation->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>


                    </td>
                <tr>
            @empty
            <tr class="bg-gray-800">
                <td colspan="7" class="text-center py-4">
                Aucune opération trouvée..
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($totalOpeFiltrer))
        <div class="bg-gray-700 px-6 py-3 font-bold text-right {{ ($totalOpeFiltrer > 0) ? 'text-green-400' : 'text-red-400'}}">
            Total: {{$totalOpeFiltrer}}€
        </div>
    @else
        @php($totalBeneficit = App\Models\Operation::calculTotal())
        <div class="bg-gray-700 px-6 py-3 font-bold text-right {{ ($totalBeneficit > 0) ? 'text-green-400' : 'text-red-400'}}">
            Total: {{$totalBeneficit}}€
        </div>
    @endif
</div>

<!-- Modal création opération -->
<div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="create-operation-modal">
    <div class="fixed inset-0 bg-gray-500 !bg-opacity-75 transition-opacity"></div>

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
                    <button type="button" data-modal-id="create-operation-modal" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal suppression opération -->
<div class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="delete-operation-modal">
    <div class="fixed inset-0 bg-gray-500 !bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/exclamation-triangle -->
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-left sm:mt-0 sm:ml-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Supprimer l'opération</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Êtes-vous sûre de vouloir supprimer l'opération ? Celle-ci ne sera plus récupérable une fois supprimée.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <form action="{{ route('operations.destroy', 'id')}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input id="deleteOperationId" name="id" hidden>
                        <button type="submit" class="inline-flex w-full items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm title="Supprimer l'opération">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text--white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>

                            Supprimer
                        </button>
                    </form>
                    <button type="button" data-modal-id="delete-operation-modal" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-modal ">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/datepicker.min.js"></script>

<script>
    $('.open-modal').click(function() {
        var modal = $(this).data('modal-id');
        $(`#${modal}`).css('display', 'block');

        if(modal == 'delete-operation-modal') $('#deleteOperationId').val($(this).data('operation-id'));
    })

    $('.close-modal').click(function() {
        var modal = $(this).data('modal-id');
        $(`#${modal}`).css('display', 'none');
    })


    // Affiche le deuxièle champs date dans le filtre
    const selectItem = $('#filtreDateType'),
        hiddenInput = $('#secondDateInput');

    selectItem.change(function() {
        if ($(this).val() === 'between') {
            hiddenInput.removeClass('hidden');
        } else {
            hiddenInput.addClass('hidden');
        }
    });
</script>
@endsection