
<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-[79px] h-screen transition-transform -translate-x-full sm:translate-x-0 shadow-md" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
      <ul class="space-y-2 font-medium">

         <li>
            <a href="/" class="mt-[12px] mb-[31px] flex justify-center items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <div class="w-[23px] h-[25px]">
                <img src="home.svg" alt="home button">
                
            </div>
            </a>
         </li>
         
         <li>
            <a href="{{ route('orders') }}" class="mb-[31px] flex justify-center items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <div class="w-[24px] h-[16px]">
                <img src="Order.svg" alt="order menu">
                <div class="flex justify-center text-[12px]">
                <p>Order</p>
                </div>
            </div>
            </a>
         </li>
         <li>
            <a href="{{ route('dashboard') }}" class="mb-[31px] flex justify-center items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <div class="w-[24px] h-[16px]">
                <img src="view.svg" alt="view menu">
                <div class="flex justify-center text-[12px]">   
                <p>View</p>
                </div>
            </div>
            </a>
         </li>
      </ul>
   </div>
</aside>
<div class="p-4 sm:ml-18">
    <x-dashboard.dashboard-header />
</div>