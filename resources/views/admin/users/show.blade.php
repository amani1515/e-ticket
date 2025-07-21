{{-- filepath: d:\My comany\e-ticket\resources\views\admin\users\show.blade.php --}}
@extends('admin.layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">User Details</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4">

            <!-- Profile Image -->
            @if ($user->profile_photo_path)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile" class="w-32 h-32 rounded-full mx-auto mb-2 cursor-pointer" onclick="openModal('{{ asset('storage/' . $user->profile_photo_path) }}')">
                </div>
            @endif

            <!-- User Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <strong class="block font-medium text-gray-700">Full Name:</strong>
                    <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <strong class="block font-medium text-gray-700">Email:</strong>
                    <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <strong class="block font-medium text-gray-700">Phone:</strong>
                    <p class="mt-1 text-gray-900">{{ $user->phone }}</p>
                </div>
                <div>
                    <strong class="block font-medium text-gray-700">User Type:</strong>
                    <p class="mt-1 text-gray-900">{{ $user->usertype }}</p>
                </div>
                <div>
                    <strong class="block font-medium text-gray-700">National ID:</strong>
                    <p class="mt-1 text-gray-900">{{ $user->national_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <strong class="block font-medium text-gray-700">Birth Date:</strong>
                    <p class="mt-1 text-gray-900">{{ $user->birth_date ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- PDF File -->
            @if ($user->pdf_file)
                <div class="mt-6">
                    <strong class="block font-medium text-gray-700">PDF File:</strong>
                    <div class="flex items-center space-x-4 mt-2">
                        <a href="{{ asset('storage/' . $user->pdf_file) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            View PDF
                        </a>
                        <a href="{{ asset('storage/' . $user->pdf_file) }}" download class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Download PDF
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('admin.users.index') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="imageModal" class="fixed hidden z-50 top-0 left-0 w-full h-full bg-black bg-opacity-75">
    <div class="flex items-center justify-center h-full">
        <img id="modalImage" class="max-w-4xl max-h-4xl m-auto">
    </div>
    <div class="absolute top-4 right-4">
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="closeModal()">
            Close
        </button>
    </div>
</div>

<script>
    function openModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Prevent scrolling
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden'); // Enable scrolling
    }
</script>
@endsection