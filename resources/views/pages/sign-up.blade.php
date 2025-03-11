<script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
<section id="register" class="max-w-screen max-h-screen">
<div class="max-w-screen max-h-screen flex ">

    <div class="w-2/5 max-h-screen bg-white flex flex-col justify-center items-center">
        <img src="logo.svg" alt="Logo" width="150px" height="150px">
        <h1 class="font-bold text-[32px] mb-2">
            Sign Up
        </h1>
        
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-[419px] mb-4">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ route('register') }}" class="flex flex-col justify-center items-center mb-8" method="POST">
            @csrf
            <div class="relative w-full mb-6">
                <input 
                    class="w-[419px] h-[50px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('first_name') border-2 border-red-500 @enderror" 
                    name="first_name" 
                    type="text" 
                    placeholder="First Name"
                    value="{{ old('first_name') }}"
                >
                @error('first_name')
                <div class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="error-message text-red-500 text-sm mt-1" data-for="first_name"></div>
            </div>
            
            <div class="relative w-full mb-6">
                <input 
                    class="w-[419px] h-[50px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('last_name') border-2 border-red-500 @enderror" 
                    name="last_name" 
                    type="text" 
                    placeholder="Last Name"
                    value="{{ old('last_name') }}"
                >
                @error('last_name')
                <div class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="error-message text-red-500 text-sm mt-1" data-for="last_name"></div>
            </div>
            
            <div class="relative w-full mb-6">
                <input 
                    class="w-[419px] h-[50px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('email') border-2 border-red-500 @enderror" 
                    name="email" 
                    type="email" 
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
            
            <div class="relative w-full mb-6">
                <input 
                    class="w-[419px] h-[50px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('contact_number') border-2 border-red-500 @enderror" 
                    name="contact_number" 
                    type="text" 
                    placeholder="Mobile Number"
                    value="{{ old('contact_number') }}"
                >
                @error('contact_number')
                <div class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="error-message text-red-500 text-sm mt-1" data-for="contact_number"></div>
            </div>
            
            <div class="relative w-full mb-6">
                <input 
                    class="w-[419px] h-[50px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('password') border-2 border-red-500 @enderror" 
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
            
            <div class="relative w-full mb-8">
                <input 
                    class="w-[419px] h-[59px] rounded-[4px] bg-[#D9D9D9] ps-4 @error('password_confirmation') border-2 border-red-500 @enderror" 
                    name="password_confirmation" 
                    type="password" 
                    placeholder="Confirm Password"
                >
                @error('password_confirmation')
                <div class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </div>
                @enderror
                <div class="error-message text-red-500 text-sm mt-1" data-for="password_confirmation"></div>
            </div>
            
            <div class="flex justify-center">
                <button type="submit" class="align-start bg-[#D9D9D9] hover:bg-gray-300 rounded-[59px] w-[186px] h-[59px] mr-4 ml-8 transition-colors">Sign Up</button>
                <div class="h-[59px] border-l-2 border-gray-300"></div>

                <div class="flex flex-col justify-center align-start items-start ml-4 mr-10 ">
                    <div>
                        <h1>Already have an account?</h1>
                    </div>
                    <a href="{{ route('login') }}">
                        <h1 class="mr-6 text-[#61BCF9] hover:text-blue-700 transition-colors">Log in here</h1> 
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="w-3/5 min-h-screen bg-[#D9D9D9]">
        <img src="register-bg.svg" alt="register" class="w-full h-full object-cover">
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
        // Get form fields
        const firstName = document.querySelector('input[name="first_name"]');
        const lastName = document.querySelector('input[name="last_name"]');
        const email = document.querySelector('input[name="email"]');
        const contactNumber = document.querySelector('input[name="contact_number"]');
        const password = document.querySelector('input[name="password"]');
        const passwordConfirmation = document.querySelector('input[name="password_confirmation"]');
        
        let hasError = false;
        
        // Clear all previous errors
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        document.querySelectorAll('input').forEach(input => {
            input.classList.remove('border-2', 'border-red-500');
        });
        
        // First name validation
        if (!firstName.value.trim()) {
            setFieldError('first_name', 'First name is required');
            hasError = true;
        }
        
        // Last name validation
        if (!lastName.value.trim()) {
            setFieldError('last_name', 'Last name is required');
            hasError = true;
        }
        
        // Email validation
        if (!email.value.trim()) {
            setFieldError('email', 'Email is required');
            hasError = true;
        } else if (!isValidEmail(email.value)) {
            setFieldError('email', 'Please enter a valid email address');
            hasError = true;
        }
        
        // Contact number validation (optional)
        if (contactNumber.value.trim() && !isValidPhoneNumber(contactNumber.value)) {
            setFieldError('contact_number', 'Please enter a valid phone number');
            hasError = true;
        }
        
        // Password validation
        if (!password.value) {
            setFieldError('password', 'Password is required');
            hasError = true;
        } else if (password.value.length < 8) {
            setFieldError('password', 'Password must be at least 8 characters');
            hasError = true;
        }
        
        // Password confirmation validation
        if (!passwordConfirmation.value) {
            setFieldError('password_confirmation', 'Please confirm your password');
            hasError = true;
        } else if (password.value !== passwordConfirmation.value) {
            setFieldError('password_confirmation', 'Password confirmation does not match');
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
    
    // Helper functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function isValidPhoneNumber(phone) {
        // Basic phone validation - can be adjusted to match your requirements
        const phoneRegex = /^[0-9+\s()-]{10,15}$/;
        return phoneRegex.test(phone);
    }
});
</script>