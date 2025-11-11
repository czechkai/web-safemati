<?php 
    // --- PHP Form Submission Logic ---
    $message = '';
    $status_class = '';
    
    // Variables to hold submitted data for re-population (for UX on failure)
    $email = $_POST['email'] ?? '';
    
    // --- Mock Authentication Data ---
    // In a real application, this data would come from a secure database (e.g., MySQL).
    // The password comparison (e.g., 'AdminPass123' === $password_input) would be done 
    // using password_verify($password_input, $hashedPasswordFromDB).
    $mock_credentials = [
        'admin@safemati.gov.ph' => ['password' => 'AdminPass123', 'role' => 'Admin', 'redirect' => 'admin_dashboard.php'],
        'user@safemati.gov.ph' => ['password' => 'UserPass123', 'role' => 'User', 'redirect' => 'user_dashboard.php'],
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // --- 1. Basic Server-Side Validation ---
        $email_input = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password_input = $_POST['password'] ?? '';
        
        if (!filter_var($email_input, FILTER_VALIDATE_EMAIL) || empty($password_input)) {
            $message = 'Please enter valid credentials.';
            $status_class = 'bg-red-900/40 text-red-300 border-red-700';
        } else {
            // --- 2. Role-Based Mock Authentication ---
            $account = $mock_credentials[strtolower($email_input)] ?? null;
            $isAuthenticated = false;
            
            if ($account && $password_input === $account['password']) {
                $isAuthenticated = true;
            }

            if ($isAuthenticated) {
                // Determine role and target dashboard
                $role = $account['role'];
                $redirect_url = $account['redirect'];
                
                // 🛑 Real application action: 
                // session_start(); $_SESSION['user_role'] = $role; header("Location: $redirect_url"); exit();

                $message = "Login successful as **{$role}**! Intended redirect to: {$redirect_url}.";
                $status_class = 'bg-green-900/40 text-green-300 border-green-700';
                $email = ''; // Clear form on success
            } else {
                // If invalid: Show generic error
                $message = 'Invalid email or password. Please try again.';
                $status_class = 'bg-red-900/40 text-red-300 border-red-700';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeMati Account Login</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        /* Custom styles for the login form look and feel */
        .login-bg {
            /* Deep dark background with subtle red gradient overlay */
            background: linear-gradient(135deg, #0f0f0f 50%, #1a0808 100%);
        }

        .login-card {
            background-color: #1a1a1a;
            transition: all 0.3s ease;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Input field glow on focus */
        .input-glow:focus {
            border-color: #f87171; /* Red-400 */
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.4); /* Red glow */
            background-color: #1a1a1a;
        }

        /* Red gradient button */
        .btn-submit-gradient {
            background: linear-gradient(90deg, #dc2626, #ef4444); /* Red-600 to Red-500 */
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            transition: all 0.3s ease;
        }
        .btn-submit-gradient:hover:not(:disabled) {
            background: linear-gradient(90deg, #ef4444, #f87171);
            transform: translateY(-2px);
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-900 font-sans antialiased">

<!-- Floating Message Container (For JS prompts like Forgot Password) -->
<div id="js-message-container" class="fixed inset-x-0 top-0 mt-4 mx-auto max-w-md z-50 transition-opacity duration-500 opacity-0 pointer-events-none">
    <div id="js-message-content" class="p-4 border rounded-lg shadow-xl text-center"></div>
</div>

<div class="login-bg min-h-screen flex items-center justify-center pt-24 pb-12 sm:pt-0">
    <div class="max-w-md w-full mx-4 sm:mx-0">
        
        <!-- Login Card -->
        <div class="login-card p-8 sm:p-10 border border-gray-700 rounded-xl shadow-2xl">
            
            <!-- Logo and Header -->
            <div class="text-center mb-8">
                <div class="text-3xl font-extrabold text-white mb-2">
                    <img src="assets/safemati-logo.png" alt="" class="h-16 w-auto mx-auto items-center" > <br>
                </div>
                <h1 class="text-2xl font-bold text-white mt-4">Account Login</h1>
                <p class="text-gray-400 text-sm">Access your personalized dashboard and alerts.</p>
                <!-- <div class="mt-2 p-2 text-xs bg-gray-800 rounded text-yellow-300 border border-yellow-700/50">
                    MOCK ACCOUNTS: Admin: `admin@safemati.gov.ph` / `AdminPass123` | User: `user@safemati.gov.ph` / `UserPass123`
                </div> -->
            </div>

            <!-- Status Message Display (PHP Backend Feedback) -->
            <?php if ($message): ?>
                <div class="p-4 mb-6 border rounded-lg <?php echo $status_class; ?>" role="alert">
                    <p class="font-semibold text-sm"><?php echo $message; ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Login Form -->
            <form id="loginForm" method="POST" action="login.php" novalidate>

                <!-- Email Field -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required 
                                placeholder="user@safemati.gov.ph"
                                value="<?php echo htmlspecialchars($email); ?>"
                                class="input-glow w-full px-4 py-3 pl-10 bg-gray-900 border border-gray-600 rounded-lg text-white transition duration-200"
                                autocomplete="email"
                                aria-describedby="email-error">
                        <i class="fa-solid fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    </div>
                    <!-- Error Message Placeholder -->
                    <p id="email-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required 
                                placeholder="••••••••"
                                class="input-glow w-full px-4 py-3 pl-10 bg-gray-900 border border-gray-600 rounded-lg text-white transition duration-200"
                                autocomplete="current-password"
                                aria-describedby="password-error">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        <!-- Show/Hide Password Toggle -->
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 transition duration-150" aria-label="Show password">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                    <!-- Error Message Placeholder (Hidden, as per request) -->
                    <p id="password-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <input id="rememberMe" name="rememberMe" type="checkbox" class="h-4 w-4 text-red-600 bg-gray-900 border-gray-600 rounded focus:ring-red-500">
                        <label for="rememberMe" class="ml-2 block text-sm text-gray-400">
                            Remember Me
                        </label>
                    </div>
                    <!-- Forgot Password Link -->
                    <a href="#" id="forgotPasswordLink" class="text-sm font-medium text-red-500 hover:text-red-400 transition duration-150">
                        Forgot Password?
                    </a>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="submitButton" disabled
                            class="btn-submit-gradient w-full px-4 py-3 text-white font-bold rounded-lg shadow-md uppercase text-base tracking-wider transition duration-300 opacity-60 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.00]">
                        Log In
                    </button>
                </div>
            </form>

            <!-- Call-to-Action Link -->
            <div class="mt-8 text-center text-gray-400">
                Don't have an account? 
                <!-- Sign Up Link -->
                <a href="signup.php" class="text-red-500 hover:text-red-400 font-semibold transition duration-150">
                    Sign Up Now
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('loginForm');
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        const submitButton = document.getElementById('submitButton');
        const togglePassword = document.getElementById('togglePassword');
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');

        // Regex definition for email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        /**
         * Helper function to display or clear inline error messages and style the input field.
         */
        function displayError(fieldElement, message) {
            const errorId = fieldElement.id + '-error';
            const errorElement = document.getElementById(errorId);
            
            if (message) {
                // Add red error state to the input
                fieldElement.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                fieldElement.classList.remove('border-gray-600');
                
                // Display error message
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.remove('hidden');
                    errorElement.setAttribute('role', 'alert');
                }
            } else {
                // Remove red error state and restore default
                fieldElement.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
                fieldElement.classList.add('border-gray-600');
                
                // Hide error message
                if (errorElement) {
                    errorElement.textContent = '';
                    errorElement.classList.add('hidden');
                    errorElement.removeAttribute('role');
                }
            }
            updateSubmitButtonState();
        }

        /**
         * Checks if all fields are valid and updates the submit button's disabled state.
         */
        function updateSubmitButtonState() {
            const emailValue = emailField.value.trim();
            const passwordValue = passwordField.value;

            // Check if fields are empty or if email is invalid format
            const isEmailValid = emailRegex.test(emailValue);
            const isPasswordPresent = passwordValue.length > 0;
            
            // Button is enabled ONLY if email is valid AND password is not empty.
            if (isEmailValid && isPasswordPresent) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-60');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-60');
            }
        }

        // --- Live Input Validation ---

        function validateEmailField() {
            const emailValue = emailField.value.trim();
            if (emailValue.length > 0 && !emailRegex.test(emailValue)) {
                displayError(emailField, 'Please enter a valid email address.');
            } else {
                // Clear error if empty or valid
                displayError(emailField, '');
            }
        }
        
        function validatePasswordField() {
            // Request: Remove the min length error text.
            // We only rely on the field being non-empty (checked in updateSubmitButtonState) 
            // and the final required field check in the submit handler.
            displayError(passwordField, '');
        }

        emailField.addEventListener('input', validateEmailField);
        passwordField.addEventListener('input', validatePasswordField);
        
        // Ensure button state updates immediately as user fills fields
        emailField.addEventListener('input', updateSubmitButtonState);
        passwordField.addEventListener('input', updateSubmitButtonState);
        
        // Also call update state on blur to ensure the button updates if user leaves field empty
        emailField.addEventListener('blur', updateSubmitButtonState);
        passwordField.addEventListener('blur', updateSubmitButtonState);


        // --- Password Show/Hide Toggle ---
        togglePassword.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent accidental form submission
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle the eye icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            this.setAttribute('aria-label', type === 'password' ? 'Show password' : 'Hide password');
        });

        // --- Forgot Password Simulation ---
        const jsMessageContainer = document.getElementById('js-message-container');
        const jsMessageContent = document.getElementById('js-message-content');

        let messageTimeout = null;

        /** Shows a floating, transient notification message (replacement for alert/confirm). */
        function showSimulatedPrompt(message, type = 'success') {
            clearTimeout(messageTimeout);
            
            // Reset classes
            jsMessageContent.className = 'p-4 border rounded-lg shadow-xl text-center';
            jsMessageContainer.classList.remove('opacity-0', 'pointer-events-none');

            // Apply style based on message type
            if (type === 'success') {
                jsMessageContent.classList.add('bg-blue-900/80', 'text-blue-300', 'border-blue-700');
            } else if (type === 'error') {
                jsMessageContent.classList.add('bg-red-900/80', 'text-red-300', 'border-red-700');
            }

            jsMessageContent.innerHTML = `<p class="font-semibold text-sm">${message}</p>`;

            // Hide after 4 seconds
            messageTimeout = setTimeout(() => {
                jsMessageContainer.classList.add('opacity-0', 'pointer-events-none');
            }, 4000);
        }

        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            const email = emailField.value.trim();

            if (email === '' || !emailRegex.test(email)) {
                // Show error if email field is empty or invalid
                showSimulatedPrompt('Please enter your email address above before requesting a password reset.', 'error');
            } else {
                // Simulation successful message (as requested)
                showSimulatedPrompt(`Simulated: A password reset link has been sent to ${email}. Please check your email.`, 'success');
            }
        });


        // --- Final Submission Validation ---
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Re-run validation for all fields on final submit
            validateEmailField();
            // validatePasswordField(); // Already clears errors, just ensure it's not empty below

            // Check if fields are empty
            if (emailField.value.trim() === '') {
                displayError(emailField, 'Email address is required.');
                isValid = false;
            }
            if (passwordField.value === '') {
                displayError(passwordField, 'Password is required.');
                isValid = false;
            }
            
            // Check for any active error message
            if (document.getElementById('email-error').textContent || document.getElementById('password-error').textContent) {
                isValid = false;
            }


            if (!isValid) {
                e.preventDefault(); 
                console.log("Login validation failed. Preventing form submission.");
                // Ensure button is disabled if form invalid
                updateSubmitButtonState();
            } else {
                // If validation passes, show loading state (submitting to PHP)
                submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Logging In...';
                submitButton.disabled = true;
            }
        });

        // Initial state check to ensure the button is disabled or enabled correctly on page load
        updateSubmitButtonState();
    });
</script>

</body>
</html>