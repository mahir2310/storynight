    <?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pageTitle = "Manage Users";

require_once __DIR__ . "/../../controllers/getUserController.php";

// user data
$users = getAllUsers() ?? [];

?>

<link rel="stylesheet" href="../../assets/styles/manage_users.css">

<div class="dashboard-header">
    <h1>Manage Users</h1>
    <p>Manage user roles, status, and permissions</p>
</div>

<div class="dashboard-section">
    <div class="search-container">
        <input type="text" id="userSearch" placeholder="Search users by username, email or role..." class="search-input">
        <button id="searchButton" class="btn-search">Search</button>
    </div>
    
    <div class="table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <select class="role-dropdown" data-user-id="<?php echo $user['user_id']; ?>">
                            <option value="customer" <?php echo $user['role'] === 'customer' ? 'selected' : ''; ?>>Customer</option>
                            <option value="manager" <?php echo $user['role'] === 'manager' ? 'selected' : ''; ?>>Manager</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </td>
                    <td>
                        <span class="status-badge status-<?php echo $user['status']; ?>">
                            <?php echo ucfirst($user['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                    <td>
                        <div class="user-actions">
                            <button class="btn-ban" data-user-id="<?php echo $user['user_id']; ?>" data-status="<?php echo $user['status']; ?>">
                                <?php echo $user['status'] === 'banned' ? 'Unban' : 'Ban'; ?>
                            </button>
                            <button class="btn-remove" data-user-id="<?php echo $user['user_id']; ?>" data-username="<?php echo htmlspecialchars($user['username']); ?>">
                                Remove
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Remove User Modal -->
<div id="removeModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Remove User</h2>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to remove user "<span id="removeUsername"></span>"? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel">Cancel</button>
            <button class="btn-confirm-remove">Remove User</button>
        </div>
    </div>
</div>

<!-- Ban User Modal -->
<div id="banModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="banModalTitle">Ban User</h2>
        </div>
        <div class="modal-body">
            <p id="banModalMessage">Are you sure you want to ban this user?</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel">Cancel</button>
            <button class="btn-confirm-ban">Confirm</button>
        </div>
    </div>
</div>

<script src="../../assets/scripts/manage_user.js"></script>