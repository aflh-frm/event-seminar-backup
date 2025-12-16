<header class="bg-white shadow-sm h-20 flex items-center justify-between px-8 z-10">
    
    <div class="flex items-center">
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">
            {{ $slot ?? 'Dashboard' }} 
        </h2>
    </div>

    <div class="flex items-center space-x-4">
        
        <div class="text-right hidden md:block">
            <div class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</div>
            <div class="text-xs text-blue-500 font-semibold tracking-wider">EVENT ORGANIZER</div>
        </div>
        
        <div class="h-12 w-12 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 p-0.5 shadow-md">
            @if(Auth::user()->avatar)
                <img class="h-full w-full rounded-full object-cover bg-white" 
                     src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                     alt="{{ Auth::user()->name }}">
            @else
                <div class="h-full w-full bg-white rounded-full flex items-center justify-center">
                    <span class="text-lg font-bold text-gray-700">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                </div>
            @endif
        </div>

    </div>

</header>