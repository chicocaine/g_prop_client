<script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
<section id="register" class="max-w-screen max-h-screen">
<div class="max-w-screen max-h-screen flex ">
  <div class="w-3/5 min-h-screen bg-[#D9D9D9]">
    <img src="sign-in-bg.svg" alt="sign in cover" class="w-full h-full object-cover">
  </div>

  <div class="w-2/5 min-h-screen bg-white flex flex-col justify-center items-center">
    <img src="logo.svg" alt="Logo">
    <h1 class="text-2xl font-bold mt-4">
      Sign In
    </h1>
    
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-[419px] mt-4">
        {{ session('error') }}
    </div>
    @endif
    
    <form action="{{ route('login') }}" method="POST" class="flex flex-col my-6 mb-32">
      @csrf
      
      <div class="relative mb-8">
        <input 
          class="w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('email') border-2 border-red-500 @enderror" 
          name="email" 
          type="text" 
          placeholder="Email"
          value="{{ old('email') }}"
        >
        @error('email')
        <div class="text-red-500 text-sm mt-1">
          {{ $message }}
        </div>
        @enderror
        <div class="error-message text-red-500 text-sm mt-1" data-for="email"></div>
      </div>
      
      <div class="relative mb-8">
        <input 
          class="w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('password') border-2 border-red-500 @enderror" 
          name="password" 
          type="password" 
          placeholder="Password"
        >
        @error('password')
        <div class="text-red-500 text-sm mt-1">
          {{ $message }}
        </div>
        @enderror
        <div class="error-message text-red-500 text-sm mt-1" data-for="password"></div>
      </div>
      
      <div class="flex justify-start">
        <button type="submit" class="align-start bg-[#D9D9D9] hover:bg-gray-300 rounded-[59px] w-[186px] h-[59px] mr-8 transition-colors">Sign In</button>
        <div class="h-[59px] border-l-2 border-gray-300"></div>

        <div class="flex justify-center items-center ml-10">
          <a href="{{ route('register') }}">
            <h1 class="mr-6 text-[#61BCF9] hover:text-blue-700 transition-colors">Sign Up</h1>
          </a>
          <div>
            <h1>New Here?</h1>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    // Function to set field error
    function setFieldError(fieldName, errorMessage) {
      const field = document.querySelector(`input[name="${fieldName}"]`);
      const errorElement = document.querySelector(`.error-message[data-for="${fieldName}"]`);
      
      if (field && errorElement) {
        field.classList.add('border-2', 'border-red-500');
        errorElement.textContent = errorMessage;
      }
    }
    
    // Function to clear field error
    function clearFieldError(fieldName) {
      const field = document.querySelector(`input[name="${fieldName}"]`);
      const errorElement = document.querySelector(`.error-message[data-for="${fieldName}"]`);
      
      if (field && errorElement) {
        field.classList.remove('border-2', 'border-red-500');
        errorElement.textContent = '';
      }
    }
    
    // Clear errors when input changes
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('input', function() {
        clearFieldError(this.name);
      });
    });
    
    form.addEventListener('submit', function(e) {
      const email = document.querySelector('input[name="email"]');
      const password = document.querySelector('input[name="password"]');
      let hasError = false;
      
      // Clear all previous errors
      document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
      document.querySelectorAll('input').forEach(input => {
        input.classList.remove('border-2', 'border-red-500');
      });
      
      // Email validation
      if (!email.value.trim()) {
        setFieldError('email', 'Email is required');
        hasError = true;
      } else if (!isValidEmail(email.value)) {
        setFieldError('email', 'Please enter a valid email address');
        hasError = true;
      }
      
      // Password validation
      if (!password.value) {
        setFieldError('password', 'Password is required');
        hasError = true;
      }
      
      if (hasError) {
        e.preventDefault();
        
        // Focus on the first field with an error
        const firstErrorInput = document.querySelector('input.border-red-500');
        if (firstErrorInput) {
          firstErrorInput.focus();
        }
      }
    });
  });
  
  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
</script>