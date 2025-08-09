@extends('layouts.superadmin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Top Navigation -->
    <div class="fixed top-0 left-0 right-0 h-20 bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700 z-50">
        <div class="flex items-center justify-between px-8 py-4 h-full">
            <div class="flex items-center gap-6">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-300">
                    <i class="fas fa-crown text-white text-2xl drop-shadow-lg"></i>
                </div>
                <div class="text-gray-900 dark:text-white">
                    <h1 class="text-2xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Super Admin Panel</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Waste Management System</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <button id="themeToggle" class="p-4 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-moon text-lg"></i>
                </button>
                <button id="addUserBtn" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-2xl transition-all duration-300 flex items-center shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Add User
                </button>
                <button id="refreshDataBtn" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-2xl transition-all duration-300 flex items-center shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh Data
                </button>
                <button id="debugBtn" class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-2xl transition-all duration-300 flex items-center shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-bug mr-2"></i>Debug
                </button>
                <button id="showAllBtn" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-2xl transition-all duration-300 flex items-center shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-list mr-2"></i>Show All
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-32 min-h-screen">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <!-- Page Header -->
            <div class="text-center mb-20">
                <h1 class="text-6xl font-black text-gray-900 dark:text-white mb-6 drop-shadow-2xl">
                    <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent">
                        Super Admin Dashboard
                    </span>
                </h1>
                <p class="text-2xl text-gray-600 dark:text-gray-400 font-medium">Manage Waste Management System Users</p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-cyan-400 mx-auto mt-6 rounded-full"></div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-500 hover:shadow-2xl hover:scale-105 hover:border-blue-300 dark:hover:border-blue-600 group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-users text-white text-3xl drop-shadow-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 dark:text-white text-4xl font-black mb-2" id="totalUsers">0</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-base font-medium">Total Users</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-500 hover:shadow-2xl hover:scale-105 hover:border-green-300 dark:hover:border-green-600 group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-user-plus text-white text-3xl drop-shadow-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 dark:text-white text-4xl font-black mb-2" id="newUsers">0</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-base font-medium">New Users</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-500 hover:shadow-2xl hover:scale-105 hover:border-purple-300 dark:hover:border-purple-600 group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-user-check text-white text-3xl drop-shadow-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 dark:text-white text-4xl font-black mb-2" id="activeUsers">0</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-base font-medium">Active Users</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-500 hover:shadow-2xl hover:scale-105 hover:border-orange-300 dark:hover:border-orange-600 group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-clock text-white text-3xl drop-shadow-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 dark:text-white text-4xl font-black mb-2" id="pendingVerification">0</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-base font-medium">Pending</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                        <div>
                            <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-2">User Management</h2>
                            <p class="text-gray-600 dark:text-gray-400 font-medium">Manage system users and their verification status</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search users..." 
                                       class="w-full sm:w-80 px-6 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-2xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                            </div>
                            
                            <select id="roleFilter" class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-2xl text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Roles</option>
                                <option value="Nasabah">Nasabah</option>
                                <option value="UMKM">UMKM</option>
                                <option value="Bank Sampah">Bank Sampah</option>
                                <option value="Non Nasabah">Non Nasabah</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">User ID</th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Created</th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody" class="bg-transparent">
                            <!-- Users will be populated here -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-8 py-6 border-t border-gray-200 dark:border-gray-700 flex flex-col lg:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                        Showing <span id="showingFrom" class="text-gray-900 dark:text-white font-bold">1</span> to <span id="showingTo" class="text-gray-900 dark:text-white font-bold">10</span> of <span id="totalRecords" class="text-gray-900 dark:text-white font-bold">0</span> users
                        <span class="ml-3 text-blue-600 dark:text-blue-400 font-semibold">| Total in Firebase: <span id="firebaseTotal" class="text-gray-900 dark:text-white font-bold">0</span></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="prevPage" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 hover:scale-105">
                            <i class="fas fa-chevron-left mr-1"></i> Previous
                        </button>
                        <span class="px-4 py-2 text-gray-700 dark:text-gray-300 text-sm font-medium bg-gray-100 dark:bg-gray-700 rounded-xl">
                            Page <span id="currentPageDisplay" class="font-bold">1</span> of <span id="totalPages" class="font-bold">1</span>
                        </span>
                        <button id="nextPage" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 hover:scale-105">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div id="userModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 transition-opacity duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full mx-4 overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                <h3 class="text-xl font-bold text-white" id="modalTitle">Add New User</h3>
            </div>
            
            <form id="userForm" class="px-6 py-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" id="userEmail" name="email" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select id="userRole" name="role" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Select Role</option>
                            <option value="Nasabah">Nasabah</option>
                            <option value="UMKM">UMKM</option>
                            <option value="Bank Sampah">Bank Sampah</option>
                            <option value="Non Nasabah">Non Nasabah</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" id="userPassword" name="password" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div id="statusField" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="userStatus" name="status"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="Pending">Pending</option>
                            <option value="Verified">Verified</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-6">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Save
                    </button>
                    <button type="button" id="cancelBtn" class="flex-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-2 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-all duration-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 transition-opacity duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full mx-4 overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
            <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-600">
                <h3 class="text-xl font-bold text-white">Confirm Deletion</h3>
            </div>
            
            <div class="px-6 py-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300" id="deleteMessage">Are you sure you want to delete this user?</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <button id="confirmDelete" class="flex-1 bg-red-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-600 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                    <button id="cancelDelete" class="flex-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-2 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-all duration-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Notification -->
<div id="successNotification" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300">
    <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="notificationMessage">Operation successful!</span>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            <p class="text-gray-700 dark:text-gray-300">Loading user data...</p>
        </div>
    </div>
</div>

<!-- Include Firebase SDK and SuperAdmin JavaScript -->
<script type="module" src="{{ asset('js/superadmin-firebase.js') }}"></script>
@endsection