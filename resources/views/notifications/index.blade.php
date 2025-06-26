<x-app-layout title="notification">
    {{--show invitations if any--}}
    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <x-notification-header
            title="Hello, {{$user->name}}"
            subtitle="Check your latest notifications here."
        />
    @if($invitations->isNotEmpty())
            <div class="p-4 bg-white rounded shadow">

                    @include('notifications.invitations.index')
            </div>
            @include('notifications.invitations.partials.confirm_action_modal')
        @endif
    </div>

</x-app-layout>
