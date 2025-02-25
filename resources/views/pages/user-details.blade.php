<x-nav-link />
<script src="https://unpkg.com/@tailwindcss/browser@4"></script> 

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-5 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-2xl font-bold">User Details</h1>
            
        </div>
        <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
        <form action="{{ route('logout') }}" method="POST" class="flex justify-end my-4">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
            </form>
    </div>
</body>
</html>