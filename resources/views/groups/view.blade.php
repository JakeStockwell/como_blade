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
                    View Groups I Don't Belong To
                    <x-icon name="down-arrow" />
                </button>
            </x-slot>

            @foreach ($not_my_groups as $not_group)
            <x-como-dropdown-item>
                <x-como-dropdown-link :href="route('groups.show', $not_group)">
                    {{ $not_group->group_name }}
                </x-como-dropdown-link>
            </x-como-dropdown-item>
            @endforeach
        </x-como-dropdown-list-red>

        <x-como-card>
            <section>
                @if ($members->count() > 0)
                    @if ($member)
                        @foreach($my_groups as $groups)
                            @if ($groups->group->id === $group->id)
                                <p>You joined this group on : {{ $groups->group->created_at }} </p>
                            @endif
                        @endforeach

                        <p>Other members of this group:
                        @foreach($members as $member)
                            @if ($member->user_id != $c_user->id)
                                <x-como-text-link :href="route('members.show', $member)">
                                    {{ $member->user->name }}
                                </x-como-text-link>
                            @endif
                        @endforeach
                    @else
                        You are not a member of this group : <a href="{{ route('members.show', $group) }}">Request Membership</a>
                    @endif
                @else
                    <p>There are no Members:</p>
                @endif
            </section>
        </x-como-card>
    </div>
</x-app-layout>