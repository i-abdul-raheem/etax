<?php
session_start();
require_once '../includes/config.sqlite.php';
require_once '../includes/db.sqlite.php';

// Check if user is logged in and is admin
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$success = '';
$error = '';

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $username = sanitize($_POST['username']);
                $email = sanitize($_POST['email']);
                $fullName = sanitize($_POST['full_name']);
                $password = $_POST['password'];
                $role = sanitize($_POST['role']);
                
                if (empty($username) || empty($email) || empty($fullName) || empty($password)) {
                    $error = 'All fields are required.';
                } elseif (!validateEmail($email)) {
                    $error = 'Please enter a valid email address.';
                } elseif (strlen($password) < 6) {
                    $error = 'Password must be at least 6 characters long.';
                } else {
                    // Check if username or email already exists
                    $existingUser = $db->fetch("SELECT id FROM users WHERE username = ? OR email = ?", [$username, $email]);
                    if ($existingUser) {
                        $error = 'Username or email already exists.';
                    } else {
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        if ($db->insert('users', [
                            'username' => $username,
                            'email' => $email,
                            'full_name' => $fullName,
                            'password_hash' => $passwordHash,
                            'role' => $role,
                            'status' => 'active'
                        ])) {
                            $success = 'User added successfully.';
                        } else {
                            $error = 'Failed to add user.';
                        }
                    }
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $email = sanitize($_POST['email']);
                $fullName = sanitize($_POST['full_name']);
                $role = sanitize($_POST['role']);
                $status = sanitize($_POST['status']);
                
                if (empty($email) || empty($fullName)) {
                    $error = 'Email and full name are required.';
                } elseif (!validateEmail($email)) {
                    $error = 'Please enter a valid email address.';
                } else {
                    // Check if email already exists for other users
                    $existingUser = $db->fetch("SELECT id FROM users WHERE email = ? AND id != ?", [$email, $id]);
                    if ($existingUser) {
                        $error = 'Email already exists for another user.';
                    } else {
                        if ($db->update('users', [
                            'email' => $email,
                            'full_name' => $fullName,
                            'role' => $role,
                            'status' => $status
                        ], 'id = ?', [$id])) {
                            $success = 'User updated successfully.';
                        } else {
                            $error = 'Failed to update user.';
                        }
                    }
                }
                break;
                
            case 'change_password':
                $id = (int)$_POST['id'];
                $newPassword = $_POST['new_password'];
                
                if (strlen($newPassword) < 6) {
                    $error = 'Password must be at least 6 characters long.';
                } else {
                    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    if ($db->update('users', [
                        'password_hash' => $passwordHash
                    ], 'id = ?', [$id])) {
                        $success = 'Password changed successfully.';
                    } else {
                        $error = 'Failed to change password.';
                    }
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                
                // Prevent deleting own account
                if ($id == $_SESSION['user_id']) {
                    $error = 'You cannot delete your own account.';
                } else {
                    if ($db->delete('users', 'id = ?', [$id])) {
                        $success = 'User deleted successfully.';
                    } else {
                        $error = 'Failed to delete user.';
                    }
                }
                break;
        }
    }
}

// Get users with post counts
$users = $db->fetchAll(
    "SELECT u.*, COUNT(bp.id) as post_count 
     FROM users u 
     LEFT JOIN blog_posts bp ON u.id = bp.author_id 
     GROUP BY u.id 
     ORDER BY u.created_at DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Dashboard - <?php echo SITE_NAME; ?> Pakistan</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo-md.png">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
        <div class="flex items-center justify-center h-16 bg-gradient-to-r from-purple-600 to-purple-800">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-gavel text-white"></i>
                </div>
                <span class="text-white font-bold text-lg"><?php echo SITE_NAME; ?></span>
            </div>
        </div>
        
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                <a href="index.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="posts.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-newspaper mr-3"></i>
                    Blog Posts
                </a>
                <a href="categories.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                </a>
                <a href="users.php" class="flex items-center px-4 py-3 text-gray-700 bg-purple-50 border-r-4 border-purple-600 rounded-r-lg">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="settings.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
                <a href="../index.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    View Site
                </a>
                <a href="../logout.php" class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Logout
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Users</h1>
                <div class="flex items-center space-x-4">
                    <button onclick="openAddModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add User
                    </button>
                    <span class="text-sm text-gray-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-purple-600"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6">
            <?php if ($success): ?>
                <div class="bg-purple-50 border border-purple-200 text-purple-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo count($users); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-user-shield text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Admins</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo count(array_filter($users, function($user) { return $user['role'] === 'admin'; })); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-user-edit text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Editors</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo count(array_filter($users, function($user) { return $user['role'] === 'editor'; })); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-user-check text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Users</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo count(array_filter($users, function($user) { return $user['status'] === 'active'; })); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">All Users</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No users found.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                        <i class="fas fa-user text-purple-600"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($user['full_name']); ?>
                                                        <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                                            <span class="ml-2 text-xs text-purple-600">(You)</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        @<?php echo htmlspecialchars($user['username']); ?>
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        <?php echo htmlspecialchars($user['email']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php
                                            $roleColors = [
                                                'admin' => 'bg-red-100 text-red-800',
                                                'editor' => 'bg-purple-100 text-purple-800',
                                                'author' => 'bg-purple-100 text-purple-800'
                                            ];
                                            $roleColor = $roleColors[$user['role']] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $roleColor; ?>">
                                                <?php echo ucfirst($user['role']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php
                                            $statusColors = [
                                                'active' => 'bg-purple-100 text-purple-800',
                                                'inactive' => 'bg-gray-100 text-gray-800'
                                            ];
                                            $statusColor = $statusColors[$user['status']] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $statusColor; ?>">
                                                <?php echo ucfirst($user['status']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <?php echo $user['post_count']; ?> posts
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <?php echo formatDate($user['created_at']); ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($user)); ?>)" class="text-purple-600 hover:text-purple-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <button onclick="openPasswordModal(<?php echo $user['id']; ?>)" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                                
                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-gray-400 cursor-not-allowed" title="Cannot delete your own account">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New User</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" id="username" name="username" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="full_name" name="full_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" name="password" required minlength="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select id="role" name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="author">Author</option>
                            <option value="editor">Editor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit User</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="mb-4">
                        <label for="edit_username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" id="edit_username" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="edit_email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit_full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="edit_full_name" name="full_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit_role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select id="edit_role" name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="author">Author</option>
                            <option value="editor">Editor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="edit_status" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="change_password">
                    <input type="hidden" id="password_user_id" name="id">
                    
                    <div class="mb-6">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" id="new_password" name="new_password" required minlength="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closePasswordModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(user) {
        document.getElementById('edit_id').value = user.id;
        document.getElementById('edit_username').value = user.username;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_full_name').value = user.full_name;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('edit_status').value = user.status;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function openPasswordModal(userId) {
        document.getElementById('password_user_id').value = userId;
        document.getElementById('passwordModal').classList.remove('hidden');
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('bg-gray-600')) {
            closeAddModal();
            closeEditModal();
            closePasswordModal();
        }
    }
    </script>
</body>
</html>
