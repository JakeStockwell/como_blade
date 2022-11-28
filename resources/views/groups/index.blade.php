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
                    View My Groups
                    <x-icon name="down-arrow" />
                </button>
            </x-slot>

            @foreach ($groups as $group)
                @if ($c_user->id === $group->user->id)

                        <x-como-dropdown-item>
                            <x-como-dropdown-link :href="route('groups.show', $group)">
                                {{ $group->group_name }}
                            </x-como-dropdown-link>
                        </x-como-dropdown-item>

                @endif
            @endforeach
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

        <div class="mt-4">
            @foreach ($groups as $group)
                <div x-data="{ show: false }" @click.away = "show = false">
                    <button @click="show = ! show" class="w-full mb-2 py-2 pl-2 pr-3 px-0 mx-2 bg-red-300 text-sm font-semibold text-left rounded-xl" style="display:inline">
                        {{ $group->group_name }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 float-right" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <div x-show="show" class="mb-2 py-2 pl-4 pr-3 mx-2 relative bg-red-400 rounded-xl hover:bg-red-100 focus:bg-gray-200" style="display:none">
                        <a href="#" class="block text-sm font-semibold text-left leading-3 "> {{ $group->user->name }} </a>
                    </div>
                </div>
            @endforeach
        </div>
                @foreach ($groups as $group)
                    @if ($c_user->id === $group->user->id)
                        <div class="p-6 flex space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-800">Group created by {{ $group->user->name }}</span>
                                        <small class="ml-2 text-sm text-gray-600">on {{ $group->created_at->format('j M Y, g:i a') }}</small>
                                    </div>
                                    @if ($group->user->is(auth()->user()))
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('groups.edit', $group)">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
                                                <form method="POST" action="{{ route('groups.destroy', $group) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('groups.destroy', $group)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                                <x-dropdown-link :href="route('groups.show', $group)">
                                                    {{ __('View Group') }}
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    @endif
                                </div>
                                <p class="mt-4 text-lg text-gray-900">Group name: {{ $group->group_name }} </p>
                            </div>
                        </div>
                    @else
                        <p>Not Joined</p>
                        <div class="p-6 flex space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-800">Group created by {{ $group->user->name }}</span>
                                        <small class="ml-2 text-sm text-gray-600">on {{ $group->created_at->format('j M Y, g:i a') }}</small>
                                        @unless ($group->created_at->eq($group->updated_at))
                                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                        @endunless
                                    </div>
                                    @if ($group->user->is(auth()->user()))
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('groups.edit', $group)">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
                                                <form method="POST" action="{{ route('groups.destroy', $group) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('groups.destroy', $group)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                                <x-dropdown-link :href="route('groups.show', $group)">
                                                    {{ __('View Group') }}
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    @endif
                                </div>
                                <p class="mt-4 text-lg text-gray-900">Group name: {{ $group->group_name }} </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            
        </div>
    </div>
</x-app-layout>