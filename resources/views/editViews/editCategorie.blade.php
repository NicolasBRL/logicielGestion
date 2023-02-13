@extends('layouts.app')

@section('additionalHead')
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
@endsection

@section('hero')
<div class="flex flex-wrap items-center justify-between">
    <h1 class="text-3xl font-bold uppercase">{{ $category->nom }}</h1>
    <a href="{{ route('categories.index') }}" class="inline-flex items-center text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-800 hover:bg-blue-700 focus:ring-blue-700 border-blue-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 -ml-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
        </svg>

        Retour
    </a>
</div>
@endsection

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <form action="{{ route('categories.update', $category) }}" method="POST" class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all">
    @method('PUT')    
    @csrf
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="w-full">
                <div class="mb-6">
                    <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom de l'opération</label>
                    <input type="text" id="nom" name="nom" value="{{ $category->nom }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-800 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Modifier</button>
        </div>
    </form>
</div>
@endsection