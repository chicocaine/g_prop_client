<script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
<x-nav-link />

<body class="bg-gray-100 pt-10">
    <div class="container mx-auto mt-10 p-5 bg-white rounded-lg shadow-lg">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-semibold text-gray-900">User Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details.</p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-900">First Name</dt>
                    <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $user->first_name }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-900">Last Name</dt>
                    <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $user->last_name }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-900">Email</dt>
                    <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $user->email }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-900">Contact Number</dt>
                    <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $user->contact_number }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-900">Default Address</dt>
                    <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $user->default_address }}</dd>
                </div>
            </dl>
        </div>
        <div class="flex justify-end mt-6">
            <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profile</button>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="flex justify-end my-4">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
        </form>
    </div>

    <!-- Modal -->
    <div id="updateModal" class="fixed inset-0 items-center justify-center flex bg-opacity-50 ">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-1/2">
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