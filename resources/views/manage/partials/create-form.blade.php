<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Tambah Mobil') }}
        </h2>
    </header>

    <form method="post" action="{{ route('mobil.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="merek" :value="__('Merek')" />
            <x-text-input id="merek" name="merek" type="text" class="mt-1 block w-full" :value="old('merek')" required
                autofocus autocomplete="merek" />
            <x-input-error class="mt-2" :messages="$errors->get('merek')" />
        </div>

        <div>
            <x-input-label for="model" :value="__('Model')" />
            <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model')"
                required autofocus autocomplete="model" />
            <x-input-error class="mt-2" :messages="$errors->get('model')" />
        </div>

        <div>
            <x-input-label for="nomor_plat" :value="__('Nomor Plat')" />
            <x-text-input id="nomor_plat" name="nomor_plat" type="text" class="mt-1 block w-full" :value="old('nomor_plat')"
                required autofocus autocomplete="nomor_plat" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_plat')" />
        </div>

        <div>
            <x-input-label for="tarif" :value="__('Tarif')" />
            <x-text-input id="tarif" name="tarif" type="text" class="mt-1 block w-full" :value="old('tarif')"
                required autofocus autocomplete="tarif" />
            <x-input-error class="mt-2" :messages="$errors->get('tarif')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>


        </div>
    </form>
</section>
