@if($user->ownedHousehold)
    <div class="mb-4 p-3 bg-yellow-50 text-yellow-800 text-sm rounded border border-yellow-300">
        <span>If you accept an invitation, your household {{$user->ownedHousehold->name}} will be deleted</span>
    </div>

@elseif($user->household)
    <div class="mb-4 p-3 bg-yellow-50 text-yellow-800 text-sm rounded border border-yellow-300">
        <span>If you accept an invitation, you will be removed from {{$user->household->name}}</span>
    </div>
@endif
@foreach($invitations as $invitation)
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0 sm:space-x-4 p-2 rounded hover:bg-gray-100">
        <div class="flex items-start sm:items-center space-x-3">
{{--            <x-profile-picture :user="$invitation->inviter" size="8" class="rounded-full border border-gray-300" />--}}
            <div class="text-sm">
                <p class="font-medium flex flex-wrap gap-x-1 items-center">
                    <span>{{ $invitation->inviter->name }}</span>
                    <span class="text-gray-500 text-xs italic">invited you to</span>
                    <span class="font-semibold text-indigo-600">{{ $invitation->household->name }}</span>
                </p>
                <p class="text-xs text-gray-400">Status: {{ ucfirst($invitation->status) }}</p>
            </div>
        </div>

        <div class="flex space-x-2 pt-1 sm:pt-0">
            <form action="{{ route('invite.update', $invitation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="accept">
                <button type="submit" class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 hover:bg-green-200">
                    Accept
                </button>
            </form>

            <form action="{{ route('invite.update',  $invitation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="reject">
                <button type="submit" class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 hover:bg-red-200">
                    Reject
                </button>
            </form>
        </div>

    </div>
@endforeach




