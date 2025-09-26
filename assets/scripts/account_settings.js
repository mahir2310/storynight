document.addEventListener("DOMContentLoaded", () => {
    const resetBtn = document.getElementById("resetPasswordBtn");
    const passwordFields = document.getElementById("passwordFields");
    const cancelBtn = document.getElementById("cancelPasswordBtn");

    if (resetBtn) {
        resetBtn.addEventListener("click", () => {
            passwordFields.style.display = "block";
            resetBtn.style.display = "none";
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener("click", () => {
            // Hide password fields
            passwordFields.style.display = "none";
            // Clear inputs
            document.getElementById("old_password").value = "";
            document.getElementById("new_password").value = "";
            // Show reset button again
            resetBtn.style.display = "inline-block";
        });
    }
});

const validatePass = (event) => {
    const form = event.target;
    const password = form.new_password.value;
    const oldPassword = form.old_password.value;

    let isValid = true;

    // Password must be at least 8 characters long
    const passwordError = document.getElementById("passwordError");
    if((password.length > 0 && password.length < 8) || (oldPassword.length > 0 && oldPassword.length < 8))
    {
        passwordError.textContent = "Password must be at least 8 characters long";
        passwordError.style.color = "red";
        isValid = false;
    }
    else passwordError.textContent = "";

    return isValid;
}

// Profile image preview
const profileUpload = document.getElementById('profileUpload');
const profileImage = document.getElementById('profileImage');

profileUpload.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            profileImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});