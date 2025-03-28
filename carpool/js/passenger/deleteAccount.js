document.getElementById("deletePassenger").addEventListener("click", function () {
    if (confirm("Are you sure you want to delete your account? You will no longer be signing in as passenger once you destroy your account.")) {
        fetch("../php/passenger/deletePassenger.php", {
            method: "POST",
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.href = "../homepage.php"; // Redirect back to homepage after deletion
            }
        });
    }
});




