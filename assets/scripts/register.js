const validateRegister = (event) => {
    const form = event.target;
    const name = form.name.value;
    const email = form.email.value;
    const password = form.password.value;
    const confirmPassword = form.confirmPassword.value;

    let isValid = true;

    // Name cannot be empty
    const nameError = document.getElementById("nameError");
    if(name.trim() === "")
    {
        nameError.textContent = "Name is required";
        isValid = false;
    }
    else nameError.textContent = "";

    // Email must include "@" and "."
    const emailError = document.getElementById("emailError");
    if(email.trim() === "" || !email.includes("@") || !email.includes("."))
    {
        emailError.textContent = "Valid email is required";
        isValid = false;
    }
    else emailError.textContent = "";

    // Password must be at least 8 characters long
    const passwordError = document.getElementById("passwordError");
    if(password.length < 8)
    {
        passwordError.textContent = "Password must be at least 8 characters long";
        isValid = false;
    }
    else passwordError.textContent = "";

    // Confirm Password must match Password
    const confirmError = document.getElementById("confirmError");
    if(confirmPassword !== password)
    {
        confirmError.textContent = "Passwords do not match";
        isValid = false;
    }
    else confirmError.textContent = "";

    return isValid;
}