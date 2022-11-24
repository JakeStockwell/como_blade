<div x-data="{ show: false }" @click.away = "show = false">
    {{-- Trigger --}}
    <div @click="show = ! show">
        {{ $trigger }}
    </div>

    {{-- Links --}}
    <div x-show="show" class="mb-2 py-2 pl-4 pr-3 mx-2 relative bg-red-400 rounded-xl hover:bg-red-100 focus:bg-gray-200" style="display:none">
        {{ $slot }}
    </div>
</div>