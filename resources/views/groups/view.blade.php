<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group : {{ $group->group_name }}
            </h2>
        </x-slot>

        <x-como-dropdown-list-red>
            <x-slot name="trigger">
                <button class="w-full mb-2 py-2 pl-2 pr-3 px-0 mx-2 text-sm font-semibold text-left rounded-xl bg-red-400" style="display:inline">
                    View Other Groups
                    <x-icon name="down-arrow" />
                </button>
            </x-slot>

            @if ($c_user->id !== $group->user->id)
            <x-como-dropdown-item>
                <x-como-dropdown-link :href="route('groups.show', $group)">
                    {{ $group->group_name }}
                </x-como-dropdown-link>
            </x-como-dropdown-item>
            @endif
        </x-como-dropdown-list-red>

        <x-como-card>
            <section>
                Default Como Card showing Group : {{ $group->group_name }}
            </section>
            <section>
                You are not a member of this group : <a href="{{ route('members.index') }}">Request Membership</a>
                <x-como-dropdown-link :href="route('members.index', $group)">
                        Name: {{ $group->group_name }} ID: {{ $group->id }}
                </x-como-dropdown-link>
                <a href="{{ route('members.show', $group); }}">Join Group</a>
                <a href="{{ route('members.index', $group); }}">Join Group</a>
                @if ($members->count() > 0)
                    <p>There are Members:</p>
                @else
                    <p>There are no Members:</p>
                @endif

                @foreach($my_groups as $my_group)
                    <p> Group: {{ $my_group->group_name }} User: {{ $my_group->user_id }}</p>
                    @if ($my_group->group_name === $group->group_name)
                        @foreach ($members as $member)
                            {{ $member->user_id }}
                        @endforeach
                    @endif
                @endforeach
            </section>
        </x-como-card>
    </div>
</x-app-layout>