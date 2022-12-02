<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group : {{ $group->group_name }}
            </h2>
        </x-slot>

        <x-como-card>
            <section>
                Default Como Card showing Group : {{ $group->group_name }}
            </section>
            <section>
                You are not a member of this group : <a href="{{ route('members.index') }}">Request Membership</a>
                <x-como-dropdown-link :href="route('members.index', $group)">
                        {{ $group->group_name }}
                </x-como-dropdown-link>
                <a href="{{ route('members.show', $group); }}">Join Group</a>
            </section>
        </x-como-card>
    </div>
</x-app-layout>