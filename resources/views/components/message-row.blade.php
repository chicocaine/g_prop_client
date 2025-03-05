<tr class="bg-white hover:bg-gray-100 dark:bg-neutral-900 shadow-sm mb-[1px] dark:hover:bg-neutral-800 {{ $message->is_read ? 'read' : 'unread' }}" data-message-id="{{ $message->id }}">
    <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 dark:text-neutral-200" style="word-break: break-word;">
        @if ($message->user->is_admin)
            <div class="flex justify-start gap-x-2">
                <p class="font-bold">Admin: </p>
                <p class="font-thin text-[12px]">{{ $message->created_at }}</p>
                <p class="font-thin text-[12px] status">{{ $message->is_read ? '(Seen)' : '(Unread)' }}</p>
            </div>
            {!! $message->content !!}
        @else
            <div class="flex justify-end gap-x-2">
                <p class="font-bold">{{ $message->user->first_name }} {{ $message->user->last_name }} (You):</p>
                <p class="font-thin text-[12px]">{{ $message->created_at }}</p>
                @if(!$message->is_read)
                    <p class="font-thin text-[12px]">(Unread)</p>
                @endif
            </div>
            <div class="flex justify-end">
                {!! $message->content !!}
            </div>
        @endif
        @if ($message->attachments->isNotEmpty())
            <div class="mt-2 flex flex-col {{ $message->user->is_admin ? 'items-start' : 'items-end' }}">
                @foreach ($message->attachments as $attachment)
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-blue-500 hover:underline">{{ $attachment->file_name }} ({{ $attachment->file_size }})</a>
                @endforeach
            </div>
        @endif
    </td>
</tr>