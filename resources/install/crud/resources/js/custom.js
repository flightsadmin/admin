// Timeout and Logout if Inactive
let idleTimeoutMinutes = 30; // Adjust this value as needed (in minutes)
let idleTimer;

function resetIdleTimer() {
    clearTimeout(idleTimer);
    idleTimer = setTimeout(logoutAndRedirect, idleTimeoutMinutes * 60 * 1000);
}

function logoutAndRedirect() {
    // Get the CSRF token from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    // Send an AJAX POST request to the logout route with the CSRF token
    fetch("/logout", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken, // Use the CSRF token obtained above
        },
    })
        .then((response) => {
            if (response.ok) {
                // Redirect the user to the login page if the logout was successful
                window.location.href = "/login";
            } else {
                // Handle the error (e.g., display an error message)
                console.error("Logout failed.");
            }
        })
        .catch((error) => {
            console.error("Logout failed:", error);
        });
}
// Listen for user activity events
document.addEventListener("mousemove", resetIdleTimer);
document.addEventListener("keydown", resetIdleTimer);

// Initialize the idle timer on page load
resetIdleTimer();