<?php 
    // --- PHP Form Submission Logic ---
    $message = '';
    $status_class = '';
    
    // Variables to hold submitted data for re-population (for UX on failure)
    $email = $_POST['email'] ?? '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize inputs
        // Normalize email (trim + lowercase) to match stored value
        $email_input = strtolower(trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL)));
        $password_input = $_POST['password'] ?? '';

        if (!filter_var($email_input, FILTER_VALIDATE_EMAIL) || empty($password_input)) {
            $message = 'Please enter valid credentials.';
            $status_class = 'bg-red-900/40 text-red-300 border-red-700';
        } else {
            // Attempt to authenticate against users table
            // FIX: Ensure the correct database connection file is required.
            require_once __DIR__ . '/db_connect.php'; 

            try {
                $user = null;
                // --- SECURE: Use prepared statements to fetch the user by email ---
                if (isset($pdo) && $pdo) {
                    $stmt = $pdo->prepare('SELECT id, first_name, last_name, email, password_hash FROM users WHERE email = :email LIMIT 1');
                    $stmt->execute([':email' => $email_input]);
                    $user = $stmt->fetch();
                } else {
                    $stmt = $conn->prepare('SELECT id, first_name, last_name, email, password_hash FROM users WHERE email = ? LIMIT 1');
                    $stmt->bind_param('s', $email_input);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $user = $res->fetch_assoc();
                    $stmt->close(); // Close the mysqli statement
                }

                // Log whether user was found for debugging
                error_log('Login lookup: user found=' . ($user ? 'yes' : 'no') . ' email=' . $email_input);

                $pwOk = false;
                if ($user) {
                    // --- SECURE: Verify the password against the stored hash ---
                    $pwOk = password_verify($password_input, $user['password_hash']);
                    error_log('Login password_verify for ' . $email_input . ': ' . ($pwOk ? 'OK' : 'FAILED'));
                }

                if ($user && $pwOk) {
                    // Auth success — start session and set session vars
                    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

                    // Remember me: extend session cookie lifetime if requested
                    if (!empty($_POST['rememberMe'])) {
                        // Extend session cookie for 30 days (simple approach)
                        $params = session_get_cookie_params();
                        setcookie(session_name(), session_id(), time() + 30*24*3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
                    }

                    // Redirect to home/dashboard
                    header('Location: index.php');
                    exit;
                } else {
                    $message = 'Invalid email or password. Please try again.';
                    $status_class = 'bg-red-900/40 text-red-300 border-red-700';
                }
            } catch (Exception $e) {
                error_log('Login error: ' . $e->getMessage());
                $message = 'Server error. Please try again later.';
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
    <script src="https://cdn.tailwindcss.com"></script>
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

<div id="js-message-container" class="fixed inset-x-0 top-0 mt-4 mx-auto max-w-md z-50 transition-opacity duration-500 opacity-0 pointer-events-none">
    <div id="js-message-content" class="p-4 border rounded-lg shadow-xl text-center"></div>
</div>

<div class="login-bg min-h-screen flex items-center justify-center pt-24 pb-12 sm:pt-0">
    <div class="max-w-md w-full mx-4 sm:mx-0">
        
        <div class="login-card p-8 sm:p-10 border border-gray-700 rounded-xl shadow-2xl">
            
            <div class="text-center mb-8">
                <div class="text-3xl font-extrabold text-white mb-2">
                    <img src="assets/safemati-logo.png" alt="" class="h-16 w-auto mx-auto items-center" > <br>
                </div>
                <h1 class="text-2xl font-bold text-white mt-4">Account Login</h1>
                <p class="text-gray-400 text-sm">Access your personalized dashboard and alerts.</p>
                </div>

            <?php if ($message): ?>
                <div class="p-4 mb-6 border rounded-lg <?php echo $status_class; ?>" role="alert">
                    <p class="font-semibold text-sm"><?php echo $message; ?></p>
                </div>
            <?php endif; ?>
            
            <form id="loginForm" method="POST" action="login.php" novalidate>

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
                    <p id="email-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required 
                                placeholder="••••••••"
                                class="input-glow w-full px-4 py-3 pl-10 bg-gray-900 border border-gray-600 rounded-lg text-white transition duration-200"
                                autocomplete="current-password"
                                aria-describedby="password-error">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 transition duration-150" aria-label="Show password">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                    <p id="password-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <input id="rememberMe" name="rememberMe" type="checkbox" class="h-4 w-4 text-red-600 bg-gray-900 border-gray-600 rounded focus:ring-red-500">
                        <label for="rememberMe" class="ml-2 block text-sm text-gray-400">
                            Remember Me
                        </label>
                    </div>
                    <a href="#" id="forgotPasswordLink" class="text-sm font-medium text-red-500 hover:text-red-400 transition duration-150">
                        Forgot Password?
                    </a>
                </div>

                <div>
                    <button type="submit" id="submitButton" disabled
                            class="btn-submit-gradient w-full px-4 py-3 text-white font-bold rounded-lg shadow-md uppercase text-base tracking-wider transition duration-300 opacity-60 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.00]">
                        Log In
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center text-gray-400">
                Don't have an account? 
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