<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden " id="inbox-content">
  @if ($commissions->isEmpty())
    <div class="flex flex-col items-center justify-center h-[500px] p-4">
      <div class="rounded-full bg-gray-100 p-4 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
      </div>
      <h3 class="text-lg font-medium text-gray-700 mb-2">No Messages Yet</h3>
      <p class="text-gray-500 text-center mb-6">Create a new commission to start messaging</p>
      <button onclick="openFaqModal()" class="inline-flex items-center gap-x-2 py-2 px-4 rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
        Create New Commission
      </button>
    </div>
  @else
    <div class="divide-y divide-gray-200">
      @foreach ($commissions as $commission)
        <div class="py-3 px-4 hover:bg-gray-50 cursor-pointer relative flex items-center transition-colors"
             data-commission-id="{{ $commission->id }}"
             onclick="showMessages({{ $commission->id }})">
          <!-- Profile pic or status icon -->
          <div class="flex-shrink-0 mr-3">
            <div class="rounded-full bg-gray-100 h-10 w-10 flex items-center justify-center overflow-hidden">
              @if($commission->user && $commission->user->profile_picture)
                <img src="{{ $commission->user->profile_picture }}" alt="Profile" class="h-full w-full object-cover">
              @else
                <div class="flex-shrink-0 h-9 w-9 flex items-center justify-center rounded-full 
                  @if($commission->status === 'active')
                    bg-green-100
                  @elseif($commission->status === 'completed')
                    bg-blue-100
                  @elseif($commission->status === 'pending')
                    bg-gray-100
                  @elseif($commission->status === 'cancelled')
                    bg-red-100
                  @else
                    bg-yellow-100
                  @endif
                ">
                  <img src="{{ asset($commission->status . '.svg') }}" alt="{{ ucfirst($commission->status) }} Logo" width="16" height="16">
                </div>
              @endif
            </div>
          </div>
          
          <!-- Content -->
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-900 truncate">
                {{ Str::limit($commission->subject ?? 'Commission #'.$commission->id, 25) }}
              </h3>
              <span class="text-xs text-gray-500">
                {{ $commission->latest_message ? $commission->latest_message->created_at->format('M d') : $commission->created_at->format('M d') }}
              </span>
            </div>
            <p class="text-sm text-gray-500 truncate mt-1">
              {{ Str::limit($commission->details, 40) }}
            </p>
            
            <!-- Status badge -->
            <div class="flex items-center mt-1">
              <span class="text-xs rounded-full px-2 py-0.5
                @if($commission->status === 'active')
                  bg-green-100 text-green-800
                @elseif($commission->status === 'completed')
                  bg-blue-100 text-blue-800
                @elseif($commission->status === 'pending')
                  bg-gray-100 text-gray-800
                @elseif($commission->status === 'cancelled')
                  bg-red-100 text-red-800
                @else
                  bg-yellow-100 text-yellow-800
                @endif
              ">
                {{ ucfirst($commission->status) }}
              </span>
              
              <!-- Unread indicator -->
              @if(isset($commission->unread_count) && $commission->unread_count > 0)
                <span class="ml-2 bg-blue-500 text-white text-xs font-medium rounded-full w-5 h-5 flex items-center justify-center unread-badge">
                  {{ $commission->unread_count }}
                </span>
              @endif
            </div>
          </div>
          
          <!-- Right arrow indicator -->
          <div class="ml-2 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>