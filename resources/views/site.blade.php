@extends ('layouts.app')

@section('hero')
<div class="flex flex-wrap items-center justify-between">
    <h1 class="text-3xl font-bold uppercase">Configuration du site</h1>
    <a href="{{route('configuration.pageBuilder')}}" class="inline-flex items-center text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 ml-auto bg-blue-800 hover:bg-blue-700 focus:ring-blue-700 border-blue-700 open-modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 -ml-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>

        Modifier la page d'accueil
    </a>
</div>
@endsection

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <form action="{{route('configuration.update')}}" method="POST" class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all">
        @csrf
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="w-full">
                <div class="mb-6">
                    <label for="titre" class="block mb-2 text-sm font-medium text-gray-900">Titre du site</label>
                    <input 
                        type="text" 
                        id="titre" 
                        name="titre" 
                        value="{{ (App\Models\SiteInfo::exist()) ? App\Models\SiteInfo::getTitre() : '' }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="mb-6">
                    <label for="metaDescription" class="block mb-2 text-sm font-medium text-gray-900">Méta description</label>
                    <textarea id="metaDescription" 
                        name="metaDescription" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        rows="4" required>{{ (App\Models\SiteInfo::exist()) ? App\Models\SiteInfo::getMetaDesc() : '' }}</textarea>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-800 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Modifier</button>
        </div>
    </form>
</div>
@endsection