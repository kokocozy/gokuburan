<x-filament-panels::page>
    <x-filament-panels::form wire:submit="create">
        {{ $this->form }}

        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea eum illo nisi ut soluta, pariatur fugit tempore
            a odio numquam! Dolore, ducimus? Laboriosam sint harum et ea nostrum dolorem enim!</p>

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
</x-filament-panels::page>