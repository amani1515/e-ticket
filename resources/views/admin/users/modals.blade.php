<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded shadow-md w-1/2">
        <h2 class="text-xl font-bold mb-4">View User</h2>
        <p><strong>Name:</strong> <span id="viewName"></span></p>
        <p><strong>Email:</strong> <span id="viewEmail"></span></p>
        <p><strong>Phone:</strong> <span id="viewPhone"></span></p>
        <p><strong>User Type:</strong> <span id="viewUserType"></span></p>
        <button onclick="closeModal('viewModal')" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <form id="editForm" method="POST" class="bg-white p-6 rounded shadow-md w-1/2">
        @csrf
        @method('PUT')
        <h2 class="text-xl font-bold mb-4">Edit User</h2>

        <input type="hidden" id="editId" name="id">

        <label>Name:</label>
        <input type="text" name="name" id="editName" class="w-full border rounded p-2 mb-2" required>

        <label>Email:</label>
        <input type="email" name="email" id="editEmail" class="w-full border rounded p-2 mb-2" required>

        <label>Phone:</label>
        <div class="flex mb-2">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">+251</span>
            <input type="text" name="phone" id="editPhone" class="w-full border rounded-r-md p-2" maxlength="9">
        </div>

        <label>User Type:</label>
        <select name="usertype" id="editUserType" class="w-full border rounded p-2 mb-2">
            <option value="admin">Admin</option>
            <option value="ticketer">Ticketer</option>
        </select>

        <div class="flex justify-between">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
            <button type="button" onclick="closeModal('editModal')" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editPhone = document.getElementById('editPhone');
    if (editPhone) {
        editPhone.addEventListener('input', function() {
            let value = this.value.replace(/[^\d]/g, '');
            if (value.length > 0 && value[0] !== '9' && value[0] !== '7') {
                value = value.substring(1);
            }
            this.value = value.slice(0, 9);
        });
        
        // Before form submission, convert to backend format
        const form = editPhone.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                const phoneValue = editPhone.value;
                if (phoneValue.length === 9 && (phoneValue[0] === '9' || phoneValue[0] === '7')) {
                    editPhone.value = '0' + phoneValue;
                }
            });
        }
    }
});
</script>
