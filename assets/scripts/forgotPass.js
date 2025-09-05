let resetEmail = "";

const validateEmail = (event) => {
    event.preventDefault();
    const email = event.target.email.value;
    let isValid = true;

    const emailError = document.getElementById("emailError");
    emailError.textContent = ""; 

    if (email === "") {
        emailError.textContent = "Email is required";
        isValid = false;
    }

    if (!email.includes("@") || !email.includes(".")) {
        emailError.textContent = "Please enter a valid email address";
        isValid = false;
    }

    const forgotPasswordForm = document.getElementById("forgotPasswordForm");
    const submitOTPform = document.getElementById("submitOTPform");
    const resetPasswordForm = document.getElementById("resetPasswordForm");

    if (isValid) {
        alert("Your OTP is 567890");
        forgotPasswordForm.style.display = "none";
        submitOTPform.style.display = "block";
        resetPasswordForm.style.display = "none";
        resetEmail = email;
    }

    return isValid;
}

const validateOTP = (event) => {
    event.preventDefault();
    const otp = event.target.otp.value;
    let isValid = true;

    const otpError = document.getElementById("otpError");
    otpError.textContent = "";

    if (otp === "") {
        otpError.textContent = "OTP is required";
        isValid = false;
    }

    if (otp !== "567890") {
        otpError.textContent = "Invalid OTP";
        isValid = false;
    }

    const forgotPasswordForm = document.getElementById("forgotPasswordForm");
    const submitOTPform = document.getElementById("submitOTPform");
    const resetPasswordForm = document.getElementById("resetPasswordForm");

    if (isValid) {
        alert("OTP verified successfully");
        forgotPasswordForm.style.display = "none";
        submitOTPform.style.display = "none";
        resetPasswordForm.style.display = "block";
    }

    return isValid;
}

const validatePassword = (event) => {
    const newPassword = event.target.newPassword.value;
    let isValid = true;

    const newPasswordError = document.getElementById("newPasswordError");
    newPasswordError.textContent = "";

    if (newPassword === "") {
        newPasswordError.textContent = "New password is required";
        isValid = false;
    }

    if (newPassword.length < 8) {
        newPasswordError.textContent = "Password must be at least 8 characters long";
        isValid = false;
    }

    const confirmPassword = event.target.confirmPassword.value;
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    confirmPasswordError.textContent = "";

    if (confirmPassword != newPassword) {
        confirmPasswordError.textContent = "Passwords do not match";
        isValid = false;
    }

    const forgotPasswordForm = document.getElementById("forgotPasswordForm");
    const submitOTPform = document.getElementById("submitOTPform");
    const resetPasswordForm = document.getElementById("resetPasswordForm");

    if (isValid) {
        forgotPasswordForm.style.display = "none";
        submitOTPform.style.display = "none";
        resetPasswordForm.style.display = "block";
        document.getElementById("resetEmail").value = resetEmail;
    }

    return isValid;
}