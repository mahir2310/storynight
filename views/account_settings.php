<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pageTitle = "Account Settings";

$userDetails = [
    'username' => $user['username'],
    'email' => $user['email'],
    'phone' => $user['phone'] ?? '',
    'gender' => $user['gender'] ?? '',
    'dob' => $user['dob'] ?? '',
    'address' => $user['address'] ?? '',
    'bio' => $user['bio'] ?? '',
    'critic' => $user['critic'] ?? false,
    'profile_pic' => $user['profile_pic'] ?? ''
];

$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
?>

<link rel="stylesheet" href="../../assets/styles/account_settings.css">

<div class="dashboard-header">
    <h1>Account Settings</h1>
    <p>Manage your profile information and preferences</p>
</div>

<div class="dashboard-section">
    <div class="account-settings">
        <form class="account-form" id="accountForm" 
              action="../../controllers/accounSettingsController.php" 
              onsubmit="return validatePass(event)" 
              method="POST" enctype="multipart/form-data">

            <!-- Profile Picture -->
            <div class="profile-section">
                <div class="profile-picture">
                    <img src="<?php echo !empty($userDetails['profile_pic']) ? htmlspecialchars('../../' . $userDetails['profile_pic']) : '../../assets/imgs/pfp-placeholder.webp'; ?>" 
                         alt="Profile Picture" id="profileImage">
                    <div class="upload-actions">
                        <input type="file" name="profile_pic" id="profileUpload" accept="image/*" style="display: none;">
                        <button type="button" class="btn-change" onclick="document.getElementById('profileUpload').click()">Change Photo</button>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="account-info">
                <h2><?php echo htmlspecialchars($userDetails['username']); ?></h2>
                <h3><?php echo htmlspecialchars($userDetails['email']); ?></h3>
                <p><?php echo htmlspecialchars($userDetails['bio']); ?></p>
            </div>

            <!-- Hidden username/email -->
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($userDetails['username']); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($userDetails['email']); ?>">

            <!-- Bio -->
            <div class="form-group">
                <label for="bio" class="form-label">Bio</label>
                <textarea id="bio" name="bio" class="form-control" rows="4"><?php echo htmlspecialchars($userDetails['bio']); ?></textarea>
            </div>

            <!-- Phone & Address -->
            <div class="form-row">
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($userDetails['phone']); ?>">
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($userDetails['address']); ?>">
                </div>
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label class="form-label">Gender</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="gender" value="male" <?php echo $userDetails['gender'] === 'male' ? 'checked' : ''; ?>>
                        <span class="radio-custom"></span> Male
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="female" <?php echo $userDetails['gender'] === 'female' ? 'checked' : ''; ?>>
                        <span class="radio-custom"></span> Female
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="other" <?php echo $userDetails['gender'] === 'other' ? 'checked' : ''; ?>>
                        <span class="radio-custom"></span> Other
                    </label>
                </div>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="form-control" value="<?php echo $userDetails['dob']; ?>">
            </div>

            <!-- Password Reset -->
            <div class="form-group">
                <p type="button" id="resetPasswordBtn" class="btn-reset">Reset Password</p>
                <div id="passwordFields" style="display: none;">
                    <div class="password-reset-section">
                        <div class="form-group">
                            <label for="old_password" class="form-label">Current Password</label>
                            <input type="password" id="old_password" name="old_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="cancelPasswordBtn" class="btn-cancel-password">Cancel</button>
                    </div>
                </div>
                <p id="passwordError" style="color: red; margin-top: 10px;">
                    <?php echo $errors['password'] ?? $errors['login'] ?? ''; ?>
                </p>
                <?php if($success): ?>
                    <p style="color: green; margin-top: 10px;"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
            </div>

            <!-- Critic Checkbox -->
            <?php if ($user['role'] === 'customer'): ?>
            <div class="form-group">
                <label class="form-label">
                    <input type="checkbox" name="critic" value="1" <?php echo $userDetails['critic'] ? 'checked' : ''; ?>>
                    Are you a movie critic?
                </label>
            </div>
            <?php endif; ?>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script src="../../assets/scripts/account_settings.js"></script>
