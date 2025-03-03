@extends('components.dashboard-layout')

@section('content')
<div class="flex justify-between mt-22">
    <div class="flex w-[325px] min-h-screen bg-white dark:bg-gray-800 justify-end align-center pr-[10px]">
        <div class="flex flex-col">
        <a href="{{ route('dashboard') }}">
            <div class="flex justify-start items-center my-4 gap-4 px-4 w-[206px] h-[33px] rounded-[16px] bg-[#D3F3FD]">
                <img src="commission.svg" alt="All Commission Logo" width="18px" height="18px">
                <p class="text-black font-bold">All Commission</p>
            </div>
        </a>
            <p>Filter</p>
            <div class="flex flex-col my-4 pl-8 gap-y-4">
                <a href="{{ route('dashboard', ['status' => 'completed']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="completed.svg" alt="Completed Logo" width="16px" height="16px">
                        Completed
                    </div>
                </a>
                <a href="{{ route('dashboard', ['status' => 'processing']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="processing.svg" alt="Processing Logo" width="16px" height="16px">
                        Active
                    </div>
                </a>
                <a href="{{ route('dashboard', ['status' => 'pending']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="pending.svg" alt="Cancelled Logo" width="16px" height="16px">
                        Pending 
                    </div>
                </a>
                <a href="{{ route('dashboard', ['status' => 'cancelled']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="cancelled.svg" alt="Cancelled Logo" width="16px" height="16px">
                        Cancelled
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="flex-1 w-[1080px]">
        <x-dashboard.view-table :commissions="$commissions" />
    </div>
</div>
@endsection