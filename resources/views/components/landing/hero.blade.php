<section id="hero" class="max-h-screen max-w-8xl mb-10 pt-20 flex justify-center items-center mx-auto">
    <div class="mt-20 min-h-screen max-w-full flex justify-between items-center space-x-5 scale-120">
        <div class="flex flex-col text-start min-w-1/2 pt-10">
            <h1 class="max-w-md font-semibold text-white text-5xl md:text-6xl leading-tight md:leading-relaxed">
                <span class="text-[#494946]">YOUR VISION OUR PRINT</span> 
            </h1>
            <div class="max-w-4xl">
                <p class="max-w-lg text-black mt-2 text-titlesec font-light text-justify md:text-left text-sm/tight sm:text-xl">
                    Bringing Your Ideas to Life with Custom Apparel, Souvenirs, and Event Printing.
                </p>
                <div class="pb-32">
                    @auth
                        <a class="w-52 my-8 group inline-flex justify-center items-center gap-x-2 py-2 px-3 bg-[#F66C73] font-normal text-md text-black rounded-full focus:outline-none" href="{{ route('dashboard') }}">
                            Start Your Order
                        </a>
                    @else
                        <a class="w-52 my-8 group inline-flex justify-center items-center gap-x-2 py-2 px-3 bg-[#F66C73] font-normal text-md text-black rounded-full focus:outline-none" href="{{ route('login', ['intended' => 'dashboard']) }}">
                            Start Your Order
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="w-[556px] h-[476px] flex items-center justify-center">
            <img src="hero-img.svg" alt="hero image" class="w-full h-full object-cover pb-20">
        </div>
    </div>
</section>