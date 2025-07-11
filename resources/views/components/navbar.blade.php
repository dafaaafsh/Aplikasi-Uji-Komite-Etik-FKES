<nav class="bg-blue-950 shadow-lg p-4 w-full fixed z-50 flex justify-between items-center">
    <div class="flex items-center space-x-2">
        
        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="Logo" class="w-10 h-10 rounded-full" />
        <span class="font-semibold text-lg text-white">FKES Universitas Nurul Jadid</span>
    </div>
    <div class="w-full md:w-auto mt-4 md:mt-0 md:flex md:items-center hidden">
        <div class="flex items-center space-x-2">
            <div class="pr-3">

                @php
                    $profil = Auth::user();
                @endphp

                <a href="../{{ $profil->role }}/profil">
                    <p class="text-sm font-medium text-white text-right"><span class="pr-2 text-yellow-400">({{ $profil->role }})</span>{{ $profil->name }}</span>
                    <p class="text-sm font-light text-white text-right">{{ $profil->email }}</p>
                </a>
            </div>
            <a href="../{{ $profil->role }}/profil">
                <img 
                @if (!empty($profil->avatar_path))
                    src="{{ asset("public/". $profil->avatar_path )}}"
                @else
                    src="https://media.istockphoto.com/id/1330286085/vector/male-avatar-icon.jpg?s=612x612&w=is&k=20&c=U9zDXcxk0pkE6Yz0MtNOwW1LG1Njkzglx7Wtp16-ho4="
                @endif
                alt="Foto Profil" class="w-11 h-11  rounded-full" />
            </a>
        </div>
    </div>
    <button onclick="toggleSidebar()" class="md:hidden focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</nav>