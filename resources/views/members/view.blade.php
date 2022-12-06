<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Members : {{ $group->group_name }}
            </h2>
        </x-slot>

        <x-como-card>
            <section>
                Default Como Card showing Group : {{ $group->group_name }}
            </section>
            <section>
                You joined this group on : {{ $member->created_at }}
                <!-- <a href="{{ route('members.index') }}">Request Membership</a> -->
                @foreach ($members as $m)
                    <x-como-dropdown-link :href="route('members.index', $member)">
                            {{ $m->group_id }}
                    </x-como-dropdown-link>
                @endforeach
                
                <a href="{{ route('members.show', $member); }}">Join Group</a>
            </section>
        </x-como-card>
    </div>
</x-app-layout>