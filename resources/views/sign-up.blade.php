<script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
<section id="register" class="max-w-screen max-h-screen">
<div class="max-w-screen max-h-screen flex ">

    <div class="w-2/5 max-h-screen bg-white flex flex-col justify-center items-center">
        <img src="logo.svg" alt="Logo">
    <h1>
    Sign Up
    </h1>
    <form action="{{route('register')}}" class="flex flex-col my-10 mb-32 justify-center items-center" method="POST">
    @csrf
        <input class="my-4 w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9]" name="first_name" type="text" placeholder="First Name">
        <input class="my-4 w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9]" name="last_name" type="text" placeholder="Last Name">
        <input class="my-4 w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9]" name="email" type="email" placeholder="Email">
        <input class="my-4 w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9]" name="contact_number" type="text" placeholder="Mobile Number">
        <input class="my-4 w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9]" name="password" type="password" placeholder="Password">
        <input class="my-4 mb-8 w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9]" name="password_confirmation" type="password" placeholder="Confirm Password">

        <div class="flex justify-center pb-24 ">
        <button type="submit" class="align-start bg-[#D9D9D9] rounded-[59px] w-[186px] h-[59px] mr-4 ml-8">Sign Up</button>
        <div class="h-[59px] border-l-2 border-gray-300"></div>

        <div class="flex flex-col justify-center align-start items-start ml-4 mr-10 ">
            <div>
            <h1>Already have an account?</h1>
            </div>
            <a href="{{ route('login') }}">
            <h1 class="mr-6 text-[#61BCF9]">Log in here</h1> 
            </a>
        </div>
    </div>
  </form>
  </div>

  <div class="w-3/5 min-h-screen bg-[#D9D9D9]">

  </div>



</div>

</section>