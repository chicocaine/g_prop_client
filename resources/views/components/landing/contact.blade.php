<section id="contact" class="max-h-screen mt-8 relative pt-10">

<div class="flex flex-col bg-[#F8F9FA] mt-10 relative pb-10">
    <div class="flex justify-center text-4xl font-semibold pt-16">
        <h1 class="font-medium text-black text-2xl sm:text-4xl ">
        Contact
        </h1>
    </div>
    <div class="pb-14">
        <div class="flex justify-center align-center pt-8">
        <div class="flex justify-center align-center w-1/2 text-center" >
        <p>
        Have a project in mind? Reach out to us and let's create something amazing together! Whether it's custom apparel, souvenirs, or event prints, were here to make it happen.
        </p>
        </div>
        </div>
    </div>
    <div class="flex justify-around relative mt-8">

        <div class="h-[306px] w-1/3 bg-[#fff] mx-12 text-[#666] text-start py-8 px-8 relative">
            <div class="mt-8">
            <p class="text-[22px]">(+63) 0936 098 1404</p>
            <p class="text-[16px]">Mobile</p>
            <p class="text-[22px]">gpropprintsanddesigns@gmail.com</p>
            <p class="text-[16px]">Email</p>
            </div>
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[88px] h-[88px] bg-[#e9eef6] rounded-full flex items-center justify-center">
                <img src="contact1.svg" alt="" class="w-[34px] h-[34px]">
            </div>
        </div>
        <div class="w-1/3 bg-[#fff] mx-12 text-[#666] py-8 px-8 relative">
            <div class="mt-8">
            <p class="text-[22px]">Door 3 Lua Bldg., E. Quirino Ave., Davao City, Philippines, 8000</p>
            <p class="text-[16px]">Address</p>
            </div>
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[88px] h-[88px] bg-[#e9eef6] rounded-full flex items-center justify-center">
                <img src="contact2.svg" alt="" class="w-[30px] h-[34px]">
            </div>        </div>
        <div class="w-1/3 bg-[#fff] mx-12 text-[#666] py-8 px-8 relative">
        <div class="mt-8">
            <p class="text-[22px]">Contact us through our dedicated Commission and Order System.</p>
            <div class="flex justify-end mt-2 w-3/7">
                <form action="{{ route('inbox') }}" method="GET" class="flex justify-end my-4 w-full">
                @csrf
                <button type="submit" class="bg-[#CE2F36] text-white px-4 py-2 rounded-[8px] w-[186px] h-[45px] hover:bg-[#e55a61]">Create Order</button>
                </form>
            </div>
            </div>
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[88px] h-[88px] bg-[#e9eef6] rounded-full flex items-center justify-center">
                <img src="contact3.svg" alt="" class="w-[32.4px] h-[32.4x]">
            </div>        
        </div>
    
    </div>
</div>
</section>