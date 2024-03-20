<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Mobil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <x-alert>{{ session('status') }}</x-alert>
            @endif
            <a href="{{ route('mobil.create') }}">
                <x-primary-button>{{ __('Tambah Mobil') }}</x-primary-button>
            </a>

            <div class="my-4">
                <form action="{{ route('mobil.index') }}" method="GET">
                    <div class="flex items-end">
                        <div class="mr-4">
                            <x-input-label for="query" :value="__('Cari:')" />
                            <x-text-input id="query" class="block mt-1 w-full" type="text" name="query"
                                :value="old('query')" autofocus />
                        </div>
                        <div class="mr-4">
                            <x-input-label for="availability" :value="__('Ketersediaan:')" />
                            <select name="availability" id="availability"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Semua</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
                        </div>
                        <x-primary-button class="py-3">
                            {{ __('Cari') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-4">
                @foreach ($mobils as $item)
                    @if (request()->input('availability') === 'Tersedia')
                        @if ($item->pinjams->isEmpty())
                            <div class="relative p-4 border border-gray-200 bg-white shadow rounded">
                                <p class="text-xl">{{ $item->merek }} : {{ $item->model }}</p>
                                <div class="flex flex-col items-end">
                                    <p class="text-sm">Tarif Sewa :</p>
                                    <p>Rp. {{ number_format($item->tarif) }}</p>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('mobil.edit', ['id' => $item->id]) }}">
                                        <x-primary-button>Edit</x-primary-button>
                                    </a>
                                    <form method="post" action="{{ route('mobil.destroy', ['id' => $item->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button>Delete</x-danger-button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @elseif (request()->input('availability') === 'Tidak Tersedia')
                        @if (!$item->pinjams->isEmpty())
                            <div class="relative p-4 border border-gray-200 bg-white shadow rounded">
                                <div class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-tr rounded-bl">
                                    <p class="text-sm">Tidak Tersedia</p>
                                </div>

                                <p class="text-xl">{{ $item->merek }} : {{ $item->model }}</p>
                                <div class="flex flex-col items-end">
                                    <p class="text-sm">Tarif Sewa :</p>
                                    <p>Rp. {{ number_format($item->tarif) }}</p>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('mobil.edit', ['id' => $item->id]) }}">
                                        <x-primary-button>Edit</x-primary-button>
                                    </a>
                                    <form method="post" action="{{ route('mobil.destroy', ['id' => $item->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button>Delete</x-danger-button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="relative p-4 border border-gray-200 bg-white shadow rounded">
                            @if (!$item->pinjams->isEmpty())
                                <div class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-tr rounded-bl">
                                    <p class="text-sm">Tidak Tersedia</p>
                                </div>
                            @endif

                            <p class="text-xl">{{ $item->merek }} : {{ $item->model }}</p>
                            <div class="flex flex-col items-end">
                                <p class="text-sm">Tarif Sewa :</p>
                                <p>Rp. {{ number_format($item->tarif) }}</p>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('mobil.edit', ['id' => $item->id]) }}">
                                    <x-primary-button>Edit</x-primary-button>
                                </a>
                                <form method="post" action="{{ route('mobil.destroy', ['id' => $item->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <x-danger-button>Delete</x-danger-button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>

            <!-- Tampilkan pagination -->
            <div class="mt-4">
                {{ $mobils->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
