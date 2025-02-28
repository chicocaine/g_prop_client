@extends('components.dashboard-layout')

@section('content')
<div class="flex justify-between mt-22">
    <div class="flex w-[325px] min-h-screen bg-white dark:bg-gray-800 justify-end align-center pr-[10px]">
        <div class="flex flex-col pr-4 w-[220px]">
            <a href="">
                <div class="flex justify-start items-center my-4 gap-4 px-4 w-[156px] h-[60px] rounded-[16px] bg-[#D3F3FD]">
                    <img src="make-commission.svg" alt="All Commission Logo" width="18px" height="18px">
                    <p class="text-black font-bold">Make Commission</p>
                </div>
            </a>    
            <div class="flex justify-start items-center my-4 gap-4 px-4 w-[204px] h-[32px] rounded-[16px] bg-white hover:bg-[#D3F3FD]">
                <a href="{{ route('inbox') }}">
                    <div class="flex items-center gap-x-2">
                        <img src="active-commission.svg" alt="Active Logo" width="16px" height="16px">
                        Active
                    </div>
                </a>
            </div>
            <div class="flex justify-start items-center gap-4 px-4 w-[204px] h-[32px] rounded-[16px] bg-white hover:bg-[#D3F3FD]">
                <a href="{{ route('commissions.archive') }}">
                    <div class="flex items-center gap-x-2">
                        <img src="archive.svg" alt="Archive Logo" width="16px" height="16px">
                        Archive
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="flex-1 w-[1080px]">
        @if($view === 'inbox')
            <x-inbox :commissions="$commissions"/>
        @elseif($view === 'archive')
            <x-archive :commissions="$commissions"/>
        @endif
    </div>
</div>
@endsection