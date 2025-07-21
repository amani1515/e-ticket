{{-- filepath: d:\My comany\e-ticket\resources\views\admin\users\edit.blade.php --}}
@extends('admin.layout.app')

@section('content')
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4 bg-white p-4 rounded shadow">
            @csrf
            @method('PUT')

            <!-- Full Name: User's name -->
            <div>
                <label>Full Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded">
            </div>

            <!-- Email: User's email address -->
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 rounded">
            </div>

            <!-- Phone: User's phone number -->
            <div>
                <label>Phone</label>
                <input type="text" name="phone" id="phone" value="{{ $user->phone }}" class="w-full border p-2 rounded" maxlength="10">
                <p id="phone-warning" class="text-sm text-red-600 hidden"></p>
            </div>

            <!-- User Type: Select the user's role in the system -->
            <div>
                <label>User Type</label>
                <select name="usertype" class="w-full border p-2 rounded">
                    <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="ticketer" {{ $user->usertype == 'ticketer' ? 'selected' : '' }}>Ticketer</option>
                    <option value="traffic" {{ $user->usertype == 'traffic' ? 'selected' : '' }}>Traffic</option>
                    <option value="hisabshum" {{ $user->usertype == 'hisabshum' ? 'selected' : '' }}>hisabshum</option>
                    <option value="mahberat" {{ $user->usertype == 'mahberat' ? 'selected' : '' }}>Mahberat</option>
                    <option value="balehabt" {{ $user->usertype == 'balehabt' ? 'selected' : '' }}>Balehabt</option>
                </select>
            </div>

            <!-- Birth Date: User's date of birth -->
            <div>
                <label>Birth Date</label>
                <input type="date" name="birth_date" value="{{ $user->birth_date }}" class="w-full border p-2 rounded">
            </div>

            <!-- National ID: User's national identification number -->
           <div>
              <label>National ID  /FIN/</label>
                    <input type="text" name="national_id" id="national_id" value="{{ $user->national_id ?? '' }}" class="w-full border p-2 rounded" maxlength="16">
                    <p id="national-id-warning" class="text-sm text-red-600 hidden"></p>
                </div>

            <!-- Profile Picture: Upload a new profile image -->
               <div>
                <label>Profile Picture</label>
                <input type="file" name="profile_photo" class="w-full">
                @if ($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="mt-2 w-24 h-24 rounded-full">
                @endif
            </div>

            <!-- PDF File: Upload a PDF document for the user -->
            <div>
                <label>PDF File</label>
                <input type="file" name="pdf_file" class="w-full">
            </div>

            <!-- Submit and Cancel Buttons -->
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
        </form>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    const nationalIdInput = document.getElementById('national_id');
    const phoneWarning = document.getElementById('phone-warning');
    const nationalIdWarning = document.getElementById('national-id-warning');

    // Phone Validation
    phoneInput.addEventListener('blur', function() {
        const phone = this.value;
        const userId = "{{ isset($user) ? $user->id : '' }}"; // For edit form
        let isValid = true;
        let message = '';

        if (!/^(09|07)\d{8}$/.test(phone) || phone.length !== 10) {
            isValid = false;
            message = 'Phone number must start with 09 or 07 and be 10 digits.';
        }

        if (isValid) {
            fetch(`/admin/users/check-phone-update?phone=${encodeURIComponent(phone)}&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        isValid = false;
                        message = 'This phone number is already registered!';
                    }
                    displayPhoneWarning(isValid, message);
                });
        } else {
            displayPhoneWarning(isValid, message);
        }
    });

    function displayPhoneWarning(isValid, message) {
        if (!isValid) {
            phoneWarning.textContent = message;
            phoneWarning.classList.remove('hidden');
        } else {
            phoneWarning.textContent = '';
            phoneWarning.classList.add('hidden');
        }
    }

    // National ID Validation
    nationalIdInput.addEventListener('blur', function() {
        const nationalId = this.value;
        const userId = "{{ isset($user) ? $user->id : '' }}";
        let isValid = true;
        let message = '';

        if (nationalId && !/^\d{16}$/.test(nationalId)) {
            isValid = false;
            message = 'National ID must be 16 digits.';
        }

         if (isValid) {
            fetch(`/admin/users/check-national-id-update?national_id=${encodeURIComponent(nationalId)}&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        isValid = false;
                        message = 'This National ID is already registered!';
                    }
                    displayNationalIdWarning(isValid, message);
                });
        } else {
            displayNationalIdWarning(isValid, message);
        }
    });

    function displayNationalIdWarning(isValid, message) {
        if (!isValid) {
            nationalIdWarning.textContent = message;
            nationalIdWarning.classList.remove('hidden');
        } else {
            nationalIdWarning.textContent = '';
            nationalIdWarning.classList.add('hidden');
        }
    }
});
</script>
@endsection