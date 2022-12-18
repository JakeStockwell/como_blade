<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('motions.store') }}">
            <x-como-card>
                <section>
                    
                        @csrf
                        <x-como-card-textarea name="motion" placeholder="{{ __('What I want to know is...') }}">
                        </x-como-card-textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        <x-primary-button class="mt-4">{{ __('Motion') }}</x-primary-button>
                </section>
            </x-como-card>
            <section>
                <x-como-dropdown-list-red>
                    <x-slot name="trigger">
                        <button class="w-full mb-2 py-2 pl-1 pr-3 px-0 mx-2 text-sm font-semibold text-left rounded-xl bg-red-400" style="display:inline">
                            Add Groups
                            <x-icon name="down-arrow" />
                        </button>
                    </x-slot>

                    @foreach ($my_groups as $my_group)
                        <x-como-dropdown-item>
                            <x-como-dropdown-link :href="route('groups.show', $my_group)">
                                {{ $my_group->group_name }}
                            </x-como-dropdown-link>
                        </x-como-dropdown-item>
                    @endforeach
                </x-como-dropdown-list-red>
            </section>
            <section>
                <x-como.accordion>
                    <x-como.accordion-item class="rounded-t">
                        <x-slot:id>0</x-slot:id>
                        This is made with Alpine JS and Tailwind CSS and is in a component in a view.
                    </x-como.accordion-item>
                    <x-como.accordion-item class="rounded-b">
                    <x-slot:id>1</x-slot:id>
                        This is also made with Alpine JS and Tailwind CSS and is in a component in a view.
                    </x-como.accordion-item>
                </x-como-accordion>
            </section>
        </form>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($motions as $motion)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $motion->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $motion->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($motion->created_at->eq($motion->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($motion->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('motions.edit', $motion)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('motions.destroy', $motion) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('motions.destroy', $motion)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $motion->motion }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>