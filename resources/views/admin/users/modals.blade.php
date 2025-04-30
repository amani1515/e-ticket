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
        <input type="text" name="phone" id="editPhone" class="w-full border rounded p-2 mb-2">

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
