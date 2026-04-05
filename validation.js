document.addEventListener("DOMContentLoaded", function () {
  const pwd = document.getElementById("password");
  const cpwd = document.getElementById("confirm_password");
  const feedback = document.getElementById("password_feedback");
  if (pwd && cpwd && feedback) {
    function checkPasswords() {
      if (!cpwd.value) { feedback.textContent = ""; return; }
      if (pwd.value === cpwd.value) {
        feedback.textContent = "Passwords match.";
        feedback.className = "text-success small";
      } else {
        feedback.textContent = "Passwords do not match.";
        feedback.className = "text-danger small";
      }
    }
    pwd.addEventListener("input", checkPasswords);
    cpwd.addEventListener("input", checkPasswords);
  }
});
