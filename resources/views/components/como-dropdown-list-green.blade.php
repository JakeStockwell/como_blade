@props(['trigger'])

<div x-data="{ show: false }" @click.away = "show = false">
    {{-- Trigger --}}
    <div @click="show = ! show">
        {{ $trigger }}
    </div>

    {{-- Links --}}
    <div x-show="show" class="mb-2 py-2 pl-4 pr-3 mx-2 relative bg-green-400 rounded-xl" style="display:none">
        {{ $slot }}
    </div>
</div>