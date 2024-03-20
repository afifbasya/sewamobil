<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pinjam Mobil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <x-alert>{{ session('status') }}</x-alert>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('pinjam.store') }}" method="post">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="mobil" :value="__('Mobil:')" />
                            <select name="mobil" id="mobil"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($mobils as $item)
                                    <option value="{{ $item->id }}">{{ $item->merek }} : {{ $item->model }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal
                                Mulai Sewa</x-input-label>
                            <x-text-input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                class="form-input mt-1 block w-full" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal
                                Selesai Sewa</x-input-label>
                            <x-text-input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                class="form-input mt-1 block w-full" required />
                        </div>
                        <div class="mt-6">
                            <x-primary-button type="submit">Submit</x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="relative overflow-x-auto mt-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Mobil
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Mulai
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Selesai
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total Harga
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pinjams as $pinjam)
                                @php
                                    $tanggalMulai = new DateTime($pinjam->tanggal_mulai);
                                    $tanggalSelesai = new DateTime($pinjam->tanggal_selesai);
                                    $selisih = $tanggalMulai->diff($tanggalSelesai);
                                    $jumlahHari = $selisih->days;
                                @endphp
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $pinjam->mobil->merek }} : {{ $pinjam->mobil->model }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $pinjam->tanggal_mulai }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $pinjam->tanggal_selesai }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $pinjam->status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($jumlahHari === 0)
                                            Rp. {{ number_format($pinjam->mobil->tarif) }}
                                        @else
                                            Rp. {{ number_format($pinjam->mobil->tarif * $jumlahHari) }}
                                        @endif

                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($pinjam->status === 'Dipinjam')
                                            <form method="post"
                                                action="{{ route('pinjam.kembali', ['id' => $pinjam->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <x-danger-button>Kembalikan</x-danger-button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    </div>
</x-app-layout>
