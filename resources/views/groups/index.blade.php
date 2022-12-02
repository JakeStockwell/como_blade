<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div x-data="{ show: false }" @click.away = "show = false">
            <button @click="show = ! show" class="w-full mb-2 py-2 pl-1 pr-3 px-0 mx-2 bg-blue-300 text-sm font-semibold text-left rounded-xl" style="display:inline">
                Make New Group
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 float-right" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <form x-show="show" id="make_group" style="display:none" method="POST" action="{{ route('groups.store') }}">
                @csrf
                <textarea
                    name="group_name"
                    placeholder="{{ __('What\'s your new group called?') }}"
                    class="block w-full mx-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm rounded-xl"
                >{{ old('group_name') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                <x-primary-button class="mt-2 mb-4 mx-2 bg-gray-400">{{ __('Make Group') }}</x-primary-button>
            </form>
        </div>

        <!-- Handle create duplicate group error -->
        @if ($errors->any())
            <div class="w-full mb-2 py-2 pl-1 pr-3 px-0 mx-2 bg-red-600 text-white text-sm font-semibold text-left rounded-xl">
                <script>$(document).ready(function(){
                    $('#make_group').show(500)
                    });</script>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-como-dropdown-list-green>
            <x-slot name="trigger">
                <button class="w-full mb-2 py-2 pl-1 pr-3 px-0 mx-2 bg-green-400 text-sm font-semibold text-left rounded-xl" style="display:inline">
                    View Groups I Made
                    <x-icon name="down-arrow" />
                </button>
            </x-slot>

            @if ($groups->count() > 0)
                @foreach ($groups as $group)
                    @if ($c_user->id === $group->user->id)
                        <x-como-dropdown-item>
                            <x-como-dropdown-link :href="route('groups.show', $group)">
                                {{ $group->group_name }}
                            </x-como-dropdown-link>
                        </x-como-dropdown-item>
                    @endif
                @endforeach
            @else
                <x-como-dropdown-item>
                    You haven't made any Groups!
                </x-como-dropdown-item>
            @endif
        </x-como-dropdown-list-green>

        <x-como-dropdown-list-green>
            <x-slot name="trigger">
                <button class="w-full mb-2 py-2 pl-1 pr-3 px-0 mx-2 bg-green-400 text-sm font-semibold text-left rounded-xl" style="display:inline">
                    View Groups I'm In
                    <x-icon name="down-arrow" />
                </button>
            </x-slot>

            @if ($group_members->count() > 0)
                @foreach ($group_members as $group)
                    @if ($c_user->id === $group->user_id)
                        <x-como-dropdown-item>
                            <x-como-dropdown-link :href="route('groups.show', $group)">
                                {{ $group->group_name }}
                            </x-como-dropdown-link>
                        </x-como-dropdown-item>
                    @endif
                @endforeach
            @else
                        <x-como-dropdown-item>
                            <x-como-dropdown-link :href="route('groups.show', $group)">
                                You're not in any Groups!
                            </x-como-dropdown-link>
                        </x-como-dropdown-item>
            @endif
        </x-como-dropdown-list-green>

        <x-como-dropdown-list-red>
            <x-slot name="trigger">
                <button class="w-full mb-2 py-2 pl-1 pr-3 px-0 mx-2 text-sm font-semibold text-left rounded-xl bg-red-400" style="display:inline">
                    View Other Groups
                    <x-icon name="down-arrow" />
                </button>
            </x-slot>

            @foreach ($groups as $group)
                @if ($c_user->id !== $group->user->id)
                <x-como-dropdown-item>
                    <x-como-dropdown-link :href="route('groups.show', $group)">
                        {{ $group->group_name }}
                    </x-como-dropdown-link>
                </x-como-dropdown-item>
                @endif
            @endforeach
        </x-como-dropdown-list-red>
    </div>
</x-app-layout>