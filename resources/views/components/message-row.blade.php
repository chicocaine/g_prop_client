<tr class="hover:bg-gray-50 mb-1 {{ $message->is_read ? 'read' : 'unread' }}" data-message-id="{{ $message->id }}">
    <td class="px-6 py-3 whitespace-normal" style="word-break: break-word;">
        @if ($message->user->is_admin)
            <!-- Admin Message (Left-aligned) -->
            <div class="flex flex-col max-w-[80%]">
                <!-- Message Header -->
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        A
                    </div>
                    <span class="font-medium text-gray-800">Admin</span>
                    <span class="text-xs text-gray-500">{{ $message->created_at->format('M d, h:i A') }}</span>
                    <span class="text-xs {{ $message->is_read ? 'text-green-500' : 'text-gray-400' }} status">
                        {{ $message->is_read ? '✓ Seen' : 'Delivered' }}
                    </span>
                </div>
                
                <!-- Message Content -->
                <div class="bg-gray-100 rounded-lg rounded-tl-none p-3 shadow-sm">
                    <div class="text-gray-800">
                        {!! $message->content !!}
                    </div>
                    
                    <!-- Attachments -->
                    @if ($message->attachments->isNotEmpty())
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            @foreach ($message->attachments as $attachment)
                                <div class="flex items-center gap-2 mt-1">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                        {{ $attachment->file_name }} 
                                        <span class="text-xs text-white">({{ formatSizeUnits($attachment->file_size) }})</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- User Message (Right-aligned) -->
            <div class="flex flex-col items-end">
                <div class="max-w-[80%]">
                    <!-- Message Header -->
                    <div class="flex items-center justify-end gap-2 mb-1">
                        <span class="text-xs text-gray-500">{{ $message->created_at->format('M d, h:i A') }}</span>
                        @if(!$message->is_read)
                            <span class="text-xs text-gray-400">Delivered</span>
                        @endif
                        <span class="font-medium text-gray-800">You</span>
                        <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($message->user->first_name, 0, 1)) }}
                        </div>
                    </div>
                    
                    <!-- Message Content -->
                    <div class="bg-blue-500 text-white rounded-lg rounded-tr-none p-3 shadow-sm">
                        <div>
                            {!! $message->content !!}
                        </div>
                        
                        <!-- Attachments -->
                        @if ($message->attachments->isNotEmpty())
                            <div class="mt-2 pt-2 border-t border-blue-400">
                                @foreach ($message->attachments as $attachment)
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-white hover:underline text-sm">
                                            {{ $attachment->file_name }} 
                                            <span class="text-xs text-white">({{ formatSizeUnits($attachment->file_size) }})</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </td>
</tr>