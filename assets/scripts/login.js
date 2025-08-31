const validateLogin = (event) => {
    const form = event.target;
    const email = form.email.value;
    const password = form.password.value;

    let isValid = true;

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

    return isValid;
}