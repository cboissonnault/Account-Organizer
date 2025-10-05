<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #121212; color: #E0E0E0; }
        .dashboard-card { background-color: #1E1E1E; border: 1px solid #333; }
        .modal-content { background-color: #2a2a2a; }
        .btn-primary { background-color: #3b82f6; transition: background-color: 0.3s; }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-secondary { background-color: #4b5563; transition: background-color: 0.3s; }
        .btn-secondary:hover { background-color: #374151; }
        .input-field { background-color: #333; border: 1px solid #555; color: #E0E0E0; }
        .input-field:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.4); }
        #notification { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="antialiased">
    <div id="app" class="container mx-auto p-4 md:p-8">
        <header class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white">Account Organizer</h1>
            <p class="text-gray-400">Securely organize your account information.</p>
        </header>

        <!-- Main View -->
        <div id="mainView">
            <div class="dashboard-card shadow-lg rounded-lg p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b border-gray-700 pb-4">
                    <h2 class="text-2xl font-semibold">My Accounts</h2>
                    <div class="flex gap-4 mt-4 sm:mt-0">
                        <button onclick="showView('addAccountView')" class="btn-primary text-white font-bold py-2 px-4 rounded-lg w-full sm:w-auto">Add Account</button>
                        <a href="index.php" class="btn-secondary text-white font-bold py-2 px-4 rounded-lg w-full sm:w-auto text-center">← Dashboard</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-300 uppercase bg-gray-700">
                            <tr>
                                <th class="p-3">Account Name</th>
                                <th class="p-3">Category</th>
                                <th class="p-3">Username/Email</th>
                                <th class="p-3"></th>
                            </tr>
                        </thead>
                        <tbody id="accountsTableBody"></tbody>
                    </table>
                </div>
                 <p id="no-accounts-message" class="text-center text-gray-400 py-8 hidden">No accounts have been added yet.</p>
            </div>
        </div>
        
        <!-- Add Account View -->
        <div id="addAccountView" class="hidden">
            <div class="dashboard-card shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
                <h2 class="text-2xl font-semibold mb-6">Add New Account</h2>
                <form id="addAccountForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="account_name" class="block mb-2 text-sm font-medium">Account Name</label>
                            <input type="text" id="account_name" name="account_name" class="input-field w-full p-2.5 rounded-lg" placeholder="e.g., Netflix, Gmail" required>
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium">Category</label>
                             <div class="flex gap-2">
                                <select id="category" name="category" class="input-field w-full p-2.5 rounded-lg" required></select>
                                <button type="button" onclick="addNewCategory()" class="btn-secondary font-bold py-2 px-4 rounded-lg">+</button>
                            </div>
                        </div>
                    </div>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="website" class="block mb-2 text-sm font-medium">Website / URL</label>
                            <input type="url" id="website" name="website" class="input-field w-full p-2.5 rounded-lg" placeholder="https://www.example.com">
                        </div>
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium">Username / Email</label>
                            <input type="text" id="username" name="username" class="input-field w-full p-2.5 rounded-lg">
                        </div>
                    </div>
                     <div>
                        <label for="secure_data_1" class="block mb-2 text-sm font-medium">Account Password</label>
                        <textarea id="secure_data_1" name="secure_data_1" rows="1" class="input-field w-full p-2.5 rounded-lg" placeholder="Enter Password"></textarea>
                    </div>
                    <div>
                        <label for="secure_data_2" class="block mb-2 text-sm font-medium">Card Number</label>
                        <textarea id="secure_data_2" name="secure_data_2" rows="1" class="input-field w-full p-2.5 rounded-lg" placeholder="Credit Card Number"></textarea>
                    </div>
                    <div>
                        <label for="card_on_file" class="block mb-2 text-sm font-medium">Exp. Date</label>
                        <input type="text" id="card_on_file" name="card_on_file" class="input-field w-full p-2.5 rounded-lg" placeholder="Enter Experation Date">
                    </div>
                     <div>
                        <label for="security_questions" class="block mb-2 text-sm font-medium">CCV#</label>
                        <textarea id="security_questions" name="security_questions" rows="1" class="input-field w-full p-2.5 rounded-lg" placeholder="CCV#"></textarea>
                    </div>
                     <div>
                        <label for="notes" class="block mb-2 text-sm font-medium">Notes</label>
                        <textarea id="notes" name="notes" rows="4" class="input-field w-full p-2.5 rounded-lg" placeholder="e.g., Renewal date is Jan 1st. Account number is XXXXX."></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-4 pt-4">
                        <button type="button" onclick="showView('mainView')" class="btn-secondary font-bold py-2 px-6 rounded-lg">Cancel</button>
                        <button type="submit" class="btn-primary font-bold py-2 px-6 rounded-lg">Save Account</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Details Modal -->
        <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50 p-4">
            <div class="modal-content rounded-lg shadow-xl p-6 w-full max-w-2xl">
                 <div class="flex justify-between items-start mb-4">
                     <h3 id="detailsModalTitle" class="text-2xl font-bold text-white">Account Details</h3>
                     <button onclick="closeModal('detailsModal')" class="text-gray-400 hover:text-white text-3xl leading-none">&times;</button>
                </div>
                <div id="detailsModalContent" class="space-y-4 text-gray-300"></div>
                 <div class="flex justify-end mt-6 gap-4">
                    <button id="detailsModalDeleteBtn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg">Delete</button>
                    <button onclick="closeModal('detailsModal')" class="btn-secondary font-bold py-2 px-6 rounded-lg">Close</button>
                </div>
            </div>
        </div>

        <!-- Generic Modals/Notifications -->
        <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50 p-4"><div class="modal-content rounded-lg shadow-xl p-6 w-full max-w-sm text-center"><p id="confirmModalText" class="mb-6 text-lg">Are you sure?</p><div class="flex justify-center gap-4"><button id="confirmModalCancel" class="btn-secondary font-bold py-2 px-6 rounded-lg">Cancel</button><button id="confirmModalConfirm" class="bg-red-600 hover:bg-red-700 font-bold py-2 px-6 rounded-lg">Confirm</button></div></div></div>
        <div id="notification" class="fixed top-5 right-5 text-white py-2 px-4 rounded-lg shadow-lg transform translate-x-full hidden"><p id="notificationMessage"></p></div>
    </div>

<script>
    const API_URL = 'account_organizer_api.php';
    let appState = { accounts: [], categories: [] };
    
    document.addEventListener('DOMContentLoaded', () => {
        fetchData();
        document.getElementById('addAccountForm').addEventListener('submit', handleFormSubmit);
    });

    async function fetchData() {
        try {
            const response = await fetch(`${API_URL}?action=get_all_data`);
            const data = await response.json();
            if (data.success) {
                appState = data;
                renderAccounts();
                populateCategoryDropdown();
            } else {
                showNotification(data.message || 'Could not fetch data.', true);
            }
        } catch (error) {
            console.error(error);
            showNotification('An error occurred while fetching data.', true);
        }
    }

    function showView(viewId) {
        document.getElementById('mainView').classList.add('hidden');
        document.getElementById('addAccountView').classList.add('hidden');
        document.getElementById(viewId).classList.remove('hidden');
        if (viewId === 'addAccountView') {
            document.getElementById('addAccountForm').reset();
        }
    }

    function renderAccounts() {
        const tableBody = document.getElementById('accountsTableBody');
        document.getElementById('no-accounts-message').classList.toggle('hidden', appState.accounts.length > 0);
        
        tableBody.innerHTML = appState.accounts.map(acc => `
            <tr class="border-b border-gray-700 hover:bg-gray-800">
                <td class="p-3 font-semibold">${acc.account_name}</td>
                <td class="p-3">${acc.category || 'N/A'}</td>
                <td class="p-3">${acc.username || 'N/A'}</td>
                <td class="p-3 text-right">
                    <button onclick="viewDetails(${acc.id})" class="text-blue-400 hover:underline text-xs">View Details</button>
                </td>
            </tr>
        `).join('');
    }

    function populateCategoryDropdown() {
        const select = document.getElementById('category');
        select.innerHTML = '';
        appState.categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.name;
            option.textContent = cat.name;
            select.appendChild(option);
        });
    }

    async function addNewCategory() {
        const newName = prompt('Enter new category name:');
        if (!newName || newName.trim() === '') return;

        const formData = new FormData();
        formData.append('name', newName.trim());

        const response = await fetch(`${API_URL}?action=add_category`, { method: 'POST', body: formData });
        const result = await response.json();
        showNotification(result.message, !result.success);
        if (result.success) {
            fetchData();
        }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        
        const response = await fetch(`${API_URL}?action=add_account`, { method: 'POST', body: formData });
        const result = await response.json();
        
        showNotification(result.message, !result.success);
        if (result.success) {
            await fetchData();
            showView('mainView');
        }
    }
    
    function deleteAccount(id) {
        showConfirmation('Are you sure you want to delete this account entry?', async () => {
             const formData = new FormData();
             formData.append('id', id);
             const response = await fetch(`${API_URL}?action=delete_account`, { method: 'POST', body: formData });
             const result = await response.json();
             showNotification(result.message, !result.success);
             if(result.success) {
                closeModal('detailsModal');
                fetchData();
             }
        });
    }

    function viewDetails(id) {
        const account = appState.accounts.find(a => a.id == id);
        if (!account) return;
        
        document.getElementById('detailsModalTitle').textContent = account.account_name;
        document.getElementById('detailsModalDeleteBtn').onclick = () => deleteAccount(account.id);
        
        const content = document.getElementById('detailsModalContent');
        content.innerHTML = `
            <div><strong>Category:</strong> ${account.category || 'N/A'}</div>
            <div><strong>Website:</strong> ${account.website ? `<a href="${account.website}" target="_blank" class="text-blue-400 hover:underline">${account.website}</a>` : 'N/A'}</div>
            <div><strong>Username/Email:</strong> ${account.username || 'N/A'}</div>
            <div><strong>Password:</strong><div class="p-2 mt-1 bg-gray-800 rounded whitespace-pre-wrap">${account.secure_data_1 || 'None'}</div></div>
            <div><strong>Credit Card Number:</strong><div class="p-2 mt-1 bg-gray-800 rounded whitespace-pre-wrap">${account.secure_data_2 || 'None'}</div></div>
            <div><strong>Exp. Date:</strong> ${account.card_on_file || 'N/A'}</div>
            <div><strong>CCV#:</strong><div class="p-2 mt-1 bg-gray-800 rounded whitespace-pre-wrap">${account.security_questions || 'None'}</div></div>
            <div><strong>Notes:</strong><div class="p-2 mt-1 bg-gray-800 rounded whitespace-pre-wrap">${account.notes || 'None'}</div></div>
        `;
        openModal('detailsModal');
    }

    // Utility Functions
    function openModal(modalId) { document.getElementById(modalId).classList.remove('hidden'); }
    function closeModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }

    function showConfirmation(text, onConfirm) {
        const modal = document.getElementById('confirmModal');
        document.getElementById('confirmModalText').textContent = text;
        modal.classList.remove('hidden');
        document.getElementById('confirmModalConfirm').onclick = () => { closeModal('confirmModal'); onConfirm(); };
        document.getElementById('confirmModalCancel').onclick = () => closeModal('confirmModal');
    }

    function showNotification(message, isError = false) {
        const notification = document.getElementById('notification');
        const messageP = document.getElementById('notificationMessage');
        messageP.textContent = message;
        notification.className = `fixed top-5 right-5 text-white py-2 px-4 rounded-lg shadow-lg transform translate-x-full ${isError ? 'bg-red-600' : 'bg-green-600'}`;
        notification.classList.remove('hidden');
        notification.classList.remove('translate-x-full');
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.classList.add('hidden'), 3000);
        }, 300);
    }
</script>
</body>
</html>

