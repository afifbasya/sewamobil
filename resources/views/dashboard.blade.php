<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <a href="{{ route('mobil.index') }}">
                    <div class="bg-white shadow-sm p-4 cursor-pointer">
                        <p>Manage</p>
                        <p class="text-2xl font-bold">Mobil</p>
                    </div>
                </a>
                <a href="{{ route('pinjam.index') }}">
                    <div class="bg-white shadow-sm p-4 cursor-pointer">
                        <p>Pinjam</p>
                        <p class="text-2xl font-bold">Mobil</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
