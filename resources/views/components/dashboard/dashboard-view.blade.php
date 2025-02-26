<div class="flex justify-between ">
    <div class="flex w-[325px] min-h-screen bg-white dark:bg-gray-800 justify-end align-center pr-[10px]">
        <div class="flex flex-col">
            <div class="flex justify-start items-center my-4 gap-4 px-4 w-[206px] h-[33px] rounded-[16px] bg-[#D3F3FD]">
            <img src="commission.svg" alt="All Commission Logo" width="18px" height="18px">
            <p class="text-black font-bold">All Commission</p>
            </div>
            <p>Filter</p>
            <div class="flex flex-col my-4 pl-8 gap-y-4">

            <a href="">
                <div class="flex items-center gap-x-2">
                <img src="completed.svg" alt="Completed Logo" width="16px" height="16px">
                Completed
                </div>
            </a>

            <a href="">
                <div class="flex items-center gap-x-2">
                <img src="processing.svg" alt="Completed Logo" width="16px" height="16px">
                Processing
            </div>
            </a>

            <a href="">
                <div class="flex items-center gap-x-2">
                <img src="cancelled.svg" alt="Completed Logo" width="16px" height="16px">
                Cancelled
                </div>
            </a>


            
            </div>
        </div>
    </div>
    <div class="w-53/70">
        <x-dashboard.view-table />
    </div>
</div>
