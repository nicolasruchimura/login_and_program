document.querySelector("#eye-toggle").addEventListener("click", () => {
    const passwordField = document.querySelector("#password");
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
});
