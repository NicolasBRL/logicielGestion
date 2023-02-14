@extends('layouts.app')

@section('hero')
<div class="flex flex-wrap items-center justify-between">
    <h1 class="text-3xl font-bold uppercase">{{ $operation->nom }}</h1>
    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-800 hover:bg-blue-700 focus:ring-blue-700 border-blue-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 -ml-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
        </svg>

        Retour
    </a>
</div>
@endsection

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <form action="{{ route('operations.update', $operation) }}" method="POST" class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all">
    @method('PUT')    
    @csrf
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="w-full">
                <div class="mb-6">
                    <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom de l'opération</label>
                    <input type="text" id="nom" name="nom" value="{{ $operation->nom }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="mb-6">
                    <label for="categories" class="block mb-2 text-sm font-medium text-gray-900">Sélectionner une catégorie</label>
                    <select id="categories" name="categories" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @forelse($categories as $category)
                        <option value="{{$category->id}}" {{ ($operation->categorieId === $category->id) ? 'selected' : ''}}>{{$category->nom}}</option>
                        @empty
                        <option disabled>Vous devez d'abord créer une catégorie</option>
                        @endforelse
                    </select>
                </div>

                <div class="mb-6">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type de l'opération</label>

                    <div class="flex items-center mb-4">
                        <input id="type-option-1" type="radio" name="type" value="0" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" {{ ($operation->estCredit) ? '' : 'checked' }}>
                        <label for="type-option-1" class="block ml-2 text-sm font-medium text-gray-900">
                            Débit
                        </label>
                    </div>

                    <div class="flex items-center mb-4">
                        <input id="type-option-2" type="radio" name="type" value="1" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" {{ ($operation->estCredit) ? 'checked' : '' }}>
                        <label for="type-option-2" class="block ml-2 text-sm font-medium text-gray-900">
                            Crédit
                        </label>
                    </div>
                </div>


                <div class="mb-6">
                    <label for="montant" class="block mb-2 text-sm font-medium text-gray-900">Montant</label>
                    <input type="number" name="montant" id="montant" step="any" value="{{ $operation->montant }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required>
                </div>

                <div class="mb-6">
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date (optionel)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input datepicker datepicker-format="dd/mm/yyyy" name="date" type="text" autocomplete="off" value="{{ Carbon\Carbon::parse($operation->date)->format('d/m/Y') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                    </div>

                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-800 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Modifier</button>
        </div>
    </form>
</div>
@endsection