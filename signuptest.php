<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script>
        // Function to handle form submission
        async function submitForm(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get form data
            const username = document.getElementById("username").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            // Create the data object
            const data = {
                username: username,
                email: email,
                password: password
            };

            try {
                // Send the data to the PHP script using fetch API
                const response = await fetch('signup.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convert data to JSON format
                });

                const result = await response.json(); // Parse JSON response
                if (response.ok) {
                    alert(result.message); // Show success message
                } else {
                    alert(result.message); // Show error message
                }
            } catch (error) {
                alert('An error occurred: ' + error.message); // Handle any errors
            }
        }
    </script>
</head>
<body>

<h2>Sign Up Form</h2>

<!-- Sign Up Form -->
<form id="signUpForm" onsubmit="submitForm(event)">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Sign Up</button>
</form>

</body>
</html>
