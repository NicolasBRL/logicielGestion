<header id="header" class="p-4 bg-gray-800 border-gray-700">
    <nav class="p-3 rounded container mx-auto">
        <div class="flex flex-wrap items-center justify-between">
            <a href="#" class="flex items-center">
                <img src="{{ asset('images/logo.png')}}" class="h-6 mr-3 sm:h-10" alt="Logo BilanPlus" />
                <span class="self-center text-xl font-semibold whitespace-nowrap text-white">BilanPlus</span>
            </a>
            <button data-collapse-toggle="navbar-solid-bg" type="button" class="inline-flex items-center p-2 ml-3 text-sm  rounded-lg md:hidden  focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600" aria-controls="navbar-solid-bg" aria-expanded="false">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
                <ul class="flex flex-col mt-4 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-transparent bg-gray-800 md:bg-transparent border-gray-700">
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:p-0 bg-blue-600 md:bg-transparent' : 'block py-2 pl-3 pr-4 hover:bg-gray-100 rounded md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent' }}">Comptes</a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories*') ? 'block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:p-0 bg-blue-600 md:bg-transparent' : 'block py-2 pl-3 pr-4 hover:bg-gray-100 rounded md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent' }}">Catégories</a>
                    </li>
                    <li>
                        <a href="{{ route('utilisateurs.index') }}" class="{{ request()->routeIs('utilisateurs*') ? 'block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:p-0 bg-blue-600 md:bg-transparent' : 'block py-2 pl-3 pr-4 hover:bg-gray-100 rounded md:border-0 md:p-0 text-gray-400 hover:bg-gray-700 hover:text-white md:hover:bg-transparent' }}">Utilisateurs</a>
                    </li>
                    <li>
                        <a href="{{ route('configuration.index') }}" class="{{ request()->routeIs('configuration*') ? 'block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:p-0 bg-blue-600 md:bg-transparent' : 'block py-2 pl-3 pr-4 hover:bg-gray-100 rounded md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent' }}">Site</a>
                    </li>
                    <li>
                        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="py-2 pl-3 pr-4 md:p-0 flex items-center text-sm font-medium capitalize rounded-full hover:text-blue-600 md:mr-0 text-gray-400" type="button">
                            {{auth()->user()->name}}
                            <svg class="w-4 h-4 mx-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <div class="px-4 py-3 text-sm text-gray-900">
                                <div class="truncate">{{auth()->user()->email}}</div>
                            </div>
                            <div class="py-2">
                                <a href="{{route('logout')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Se déconnecter</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>