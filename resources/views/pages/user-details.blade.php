<script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
<x-nav-link />

<body class="bg-white pt-10">
    <div class="container mx-auto my-12 mt-40 p-5 bg-white rounded-lg flex flex-col items-center">
        <div class="flex flex-col justify-center items-center px-4 sm:px-0">
            <h3 class="text-[36px] font-semibold text-gray-900">Personal Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Info about your personal profile and security</p>
        </div>
        <div class="mt-6 mb-6 p-12 border-t border-gray-100 shadow-lg flex flex-col space-y-4 rounded-[8px] w-3/7">
            <h3 class="text-[26px] font-semibold text-gray-900">Basic Info</h3>
            <div class="flex justify-between">
                <h3 class="text-[16px] font-semibold text-[#666]">First Name</h3>
                <h3 class="text-[16px] font-semibold text-black flex justify-start w-5/7">{{$user->first_name}}</h3>
            </div>
            <hr style="color: #B4B1B1;">
    
            <div class="flex justify-between">
                <h3 class="text-[16px] font-semibold text-[#666]">Last Name</h3>
                <h3 class="text-[16px] font-semibold text-black flex justify-start w-5/7">{{$user->last_name}}</h3>
            </div>


                
        </div>
         <div class="mt-6 p-12 border-t border-gray-100 shadow-lg flex flex-col space-y-4 rounded-[8px] w-3/7">
            <h3 class="text-[26px] font-semibold text-gray-900">Contact Info</h3>
            <div class="flex justify-between">
                <h3 class="text-[16px] font-semibold text-[#666]">Email</h3>
                <h3 class="text-[16px] font-semibold text-black flex justify-start w-5/7">{{$user->email}}</h3>
            </div>
            <hr style="color: #B4B1B1;">
    
            <div class="flex justify-between">
                <h3 class="text-[16px] font-semibold text-[#666]">Phone</h3>
                <h3 class="text-[16px] font-semibold text-black flex justify-start w-5/7">{{$user->contact_number}}</h3>
            </div>
            <hr style="color: #B4B1B1;">
    
            <div class="flex justify-between">
                <h3 class="text-[16px] font-semibold text-[#666]">Address</h3>
                <h3 class="text-[16px] font-semibold text-black flex justify-start w-5/7">{{$user->default_address}}</h3>
            </div>


                
        </div>


        <div class="flex justify-end mt-6 w-3/7 ">
            <button id="openModal" class="min-w-full bg-white h-[60px] text-black text-[15px] px-4 py-2 rounded-[8px] shadow-sm hover:bg-gray-200">Edit Profile</button>
        </div>
        <div class="flex justify-end mt-2 w-3/7">
            <form action="{{ route('logout') }}" method="POST" class="flex justify-end my-4 w-full">
            @csrf
            <button type="submit" class="bg-[#F66C73] text-white px-4 py-2 rounded-[8px] w-full h-[60px] hover:bg-[#e55a61]">Logout</button>
            </form>
        </div>
    </div>
    

    <!-- Modal -->
    <div id="updateModal" class="fixed inset-0 items-center justify-center flex  z-50 hidden">
        <div class="fixed inset-0 bg-black opacity-50"></div> <!-- Overlay -->
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-1/2 z-50">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Update Information</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label for="first_name" class="block text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="w-full border border-gray-300 p-2 rounded" value="{{ $user->first_name }}">
                </div>
                <div>
                    <label for="last_name" class="block text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="w-full border border-gray-300 p-2 rounded" value="{{ $user->last_name }}">
                </div>
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="w-full border border-gray-300 p-2 rounded" value="{{ $user->email }}">
                </div>
                <div>
                    <label for="contact_number" class="block text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="w-full border border-gray-300 p-2 rounded" value="{{ $user->contact_number }}">
                </div>
                <div>
                    <label for="default_address" class="block text-gray-700">Default Address</label>
                    <input type="text" name="default_address" id="default_address" class="w-full border border-gray-300 p-2 rounded" value="{{ $user->default_address }}">
                </div>
                <div>
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('updateModal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('updateModal').classList.add('hidden');
        });
    </script>
</body>
</html>