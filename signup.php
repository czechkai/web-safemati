<?php
    // --- Simulated Server-Side Processing ---
    $message = '';
    $status_class = ''; // For success or error message styling
    $redirect_script = ''; // To handle the 3-second redirect
    
    // Default values to repopulate the form if submission fails
    $formData = [
        'firstName' => $_POST['firstName'] ?? '',
        'middleName' => $_POST['middleName'] ?? '',
        'lastName' => $_POST['lastName'] ?? '',
        'email' => $_POST['email'] ?? '',
        'contactNumber' => $_POST['contactNumber'] ?? '',
        'houseStreetSubd' => $_POST['houseStreetSubd'] ?? '',
        'barangay' => $_POST['barangay'] ?? '',
        'termsAgreed' => $_POST['termsAgreed'] ?? 'off',
    ];
    
    // Mati City Barangays (Sample List for PHP and Frontend Select)
    $barangays = [
        'Central', 'Bucana', 'Dahican', 'Libuac', 'Lupon', 'Poblacion',
        'Badas', 'Dauan', 'Don Enrique Lopez', 'Matiao', 'Sambat', 'Tagabisa'
    ];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Sanitize and Collect Input
        $firstName = htmlspecialchars(trim($formData['firstName']));
        $middleName = htmlspecialchars(trim($formData['middleName']));
        $lastName = htmlspecialchars(trim($formData['lastName']));
        $email = filter_var($formData['email'], FILTER_SANITIZE_EMAIL);
        $contactNumber = htmlspecialchars(trim($formData['contactNumber']));
        $houseStreetSubd = htmlspecialchars(trim($formData['houseStreetSubd']));
        $barangay = htmlspecialchars(trim($formData['barangay']));
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        $termsAgreed = $formData['termsAgreed'] === 'on';

        // 2. Validate Input
        if (empty($firstName) || empty($lastName) || empty($email) || empty($contactNumber) || empty($houseStreetSubd) || empty($barangay) || empty($password) || empty($confirmPassword)) {
            $message = 'Please fill out all required fields.';
            $status_class = 'bg-red-500/20 text-red-300 border-red-500';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Invalid email format.';
            $status_class = 'bg-red-500/20 text-red-300 border-red-500';
        } elseif ($password !== $confirmPassword) {
            $message = 'Passwords do not match.';
            $status_class = 'bg-red-500/20 text-red-300 border-red-500';
        } elseif (strlen($password) < 8) {
            $message = 'Password must be at least 8 characters long.';
            $status_class = 'bg-red-500/20 text-red-300 border-red-500';
        } elseif (!$termsAgreed) {
            $message = 'You must agree to the Terms and Conditions.';
            $status_class = 'bg-red-500/20 text-red-300 border-red-500';
        } else {
            // 3. Successful Registration (Placeholder)
            // In a real application, you would hash the password and save the user data to a database.
            
            $message = 'Registration successful! Redirecting to login...';
            $status_class = 'bg-green-500/20 text-green-300 border-green-500';
            
            // Redirect after 3 seconds
            $redirect_script = '<script>setTimeout(() => { window.location.href = "login.php"; }, 3000);</script>';
            
            // Clear form data on success
            $formData = [
                'firstName' => '', 'middleName' => '', 'lastName' => '', 'email' => '', 
                'contactNumber' => '', 'houseStreetSubd' => '', 'barangay' => '', 'termsAgreed' => 'off',
            ];
        }
    }
    
    // This loads the HTML head, opening body tag, fixed header, and mobile menu script
    include 'header.php'; 
?>

<!-- FIX: Main container ensures full screen height and centers content without causing page scroll -->
<main class="flex items-center justify-center bg-gray-100 dark:bg-gray-900 w-auto" style="min-height: calc(100vh - 0px); padding-top: 80px;">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 w-full max-w-4xl">
        <!-- Registration Card -->
        <!-- FIX: Set max height to prevent the card from exceeding the viewport size and force scroll INSIDE the card -->
        <!-- <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-xl p-6 sm:p-10 border border-red-500/30 overflow-y-auto max-h-[calc(100vh-80px)] mx-auto"> -->
            
            <h1 class="text-3xl font-extrabold text-red-600 dark:text-red-400 mb-2 text-center">
                Create Your SafeMati Account
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8 text-center">
                Register now to receive critical real-time emergency alerts.
            </p>

            <?php if ($message): ?>
                <!-- Status Message Display -->
                <div id="status-message" class="p-4 mb-6 rounded-lg border-2 <?= $status_class; ?> text-center font-semibold transition-all duration-300">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <form action="signup.php" method="POST" id="registrationForm" class="space-y-6">
                <!-- 1. PERSONAL DETAILS -->
                <div>
                    <h2 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-4 border-b pb-2 border-gray-200">Personal Details</h2>
                    <!-- Grid layout for name fields to ensure alignment -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- First Name -->
                        <div class="col-span-1">
                            <label for="firstName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name <span class="text-red-500">*</span></label>
                            <input type="text" id="firstName" name="firstName" value="<?= $formData['firstName']; ?>" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm"
                                placeholder="Juan">
                        </div>
                        <!-- Middle Name (Optional) -->
                        <div class="col-span-1">
                            <label for="middleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Middle Name</label>
                            <input type="text" id="middleName" name="middleName" value="<?= $formData['middleName']; ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm"
                                placeholder="Dela">
                        </div>
                        <!-- Last Name -->
                        <div class="col-span-1">
                            <label for="lastName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" id="lastName" name="lastName" value="<?= $formData['lastName']; ?>" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm"
                                placeholder="Cruz">
                        </div>
                    </div>
                </div>

                <!-- 2. CONTACT AND CREDENTIALS -->
                <div>
                    <h2 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-4 border-b pb-2 border-gray-200">Contact & Security</h2>
                    <!-- Grid layout for contact fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="<?= $formData['email']; ?>" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm"
                                placeholder="juan.delacruz@example.com">
                        </div>
                        <!-- Contact Number -->
                        <div>
                            <label for="contactNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Number <span class="text-red-500">*</span></label>
                            <input type="tel" id="contactNumber" name="contactNumber" value="<?= $formData['contactNumber']; ?>" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm"
                                placeholder="09xxxxxxxxx">
                        </div>
                    </div>
                    
                    <!-- Grid layout for password fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password (min 8 chars) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required minlength="8"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm pr-10"
                                    placeholder="••••••••">
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-red-500 transition duration-150">
                                    <i class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Confirm Password -->
                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm pr-10"
                                    placeholder="••••••••">
                                <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-red-500 transition duration-150">
                                    <i class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. ADDRESS DETAILS -->
                <div>
                    <h2 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-4 border-b pb-2 border-gray-200">Residential Address (Mati City)</h2>
                    <!-- Grid layout for address fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- House/Street/Subd. -->
                        <div>
                            <label for="houseStreetSubd" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">House No. / Street / Subd. <span class="text-red-500">*</span></label>
                            <input type="text" id="houseStreetSubd" name="houseStreetSubd" value="<?= $formData['houseStreetSubd']; ?>" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm"
                                placeholder="Unit 101, Sunflower St.">
                        </div>
                        <!-- Barangay -->
                        <div>
                            <label for="barangay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Barangay <span class="text-red-500">*</span></label>
                            <select id="barangay" name="barangay" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-150 shadow-sm">
                                <option value="">Select Barangay</option>
                                <?php foreach ($barangays as $b): ?>
                                    <option value="<?= $b; ?>" <?= $formData['barangay'] === $b ? 'selected' : ''; ?>>
                                        <?= $b; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 4. TERMS AND SUBMIT -->
                <div class="pt-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="termsAgreed" name="termsAgreed" type="checkbox" 
                                <?= $formData['termsAgreed'] === 'on' ? 'checked' : ''; ?>
                                class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600"
                                onchange="checkFormValidity()">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="termsAgreed" class="font-medium text-gray-700 dark:text-gray-300">
                                I agree to the 
                                <a href="#" id="openTermsModal" class="text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 font-semibold underline transition duration-150">
                                    Terms and Conditions
                                </a> <span class="text-red-500">*</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" id="submitButton" disabled
                    class="btn-gradient w-full px-6 py-3 text-white font-bold rounded-lg shadow-xl uppercase tracking-wider text-lg transition duration-300 transform disabled:opacity-50 disabled:cursor-not-allowed hover:scale-[1.005] hover:shadow-2xl">
                    Register Account
                </button>

                <p class="text-center text-sm text-gray-600 dark:text-gray-400 pt-4">
                    Already have an account? 
                    <a href="login.php" class="text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 font-semibold underline transition duration-150">
                        Log in here
                    </a>
                </p>

            </form>

        <!-- </div> -->
    </div>
</main>

<!-- Terms and Conditions Modal -->
<div id="termsModal" class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-75 flex items-center justify-center opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-3xl p-6 w-full max-w-2xl transform scale-95 transition-transform duration-300 max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Terms and Conditions</h3>
            <button id="closeTermsModal" class="text-gray-400 hover:text-red-500 transition duration-150 p-2">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>
        <div class="overflow-y-auto text-gray-700 dark:text-gray-300 flex-grow pr-2 text-sm space-y-4">
            <p class="font-bold text-base">1. Acceptance of Terms</p>
            <p>By registering for a SafeMati account, you agree to be bound by these Terms and Conditions. This system is intended solely for residents of Mati City for the purpose of receiving emergency and safety alerts.</p>
            
            <p class="font-bold text-base">2. Purpose of Service</p>
            <p>SafeMati provides a real-time alerting service for natural disasters, public safety announcements, and emergency information issued by the Mati City Disaster Risk Reduction and Management Office (MDRRMO) and its partner agencies. The service is supplemental and should not replace primary emergency response methods (e.g., dialing 911).</p>
            
            <p class="font-bold text-base">3. User Responsibility</p>
            <ul class="list-disc list-inside space-y-1 pl-4">
                <li>You must provide accurate and up-to-date residential and contact information.</li>
                <li>You are responsible for maintaining the confidentiality of your account password.</li>
                <li>Misuse of the system for non-emergency purposes is strictly prohibited and may result in account termination.</li>
            </ul>
            
            <p class="font-bold text-base">4. Data Privacy</p>
            <p>All personal data collected is for emergency notification and local government purposes only. Data will not be shared with third parties for commercial use. By agreeing, you consent to the processing of your data in accordance with the Philippine Data Privacy Act of 2012.</p>

            <p class="font-bold text-base">5. Service Availability</p>
            <p>The MDRRMO strives to ensure the service is available at all times, but cannot guarantee uninterrupted access. Service disruptions may occur due to maintenance, network issues, or extreme weather conditions.</p>
        </div>
        <div class="mt-4 pt-3 border-t">
            <button id="closeTermsModalFooter" class="btn-gradient w-full px-4 py-2 text-white font-bold rounded-lg uppercase tracking-wider transition duration-300">
                Close and Agree
            </button>
        </div>
    </div>
</div>

<?= $redirect_script; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('registrationForm');
        const submitButton = document.getElementById('submitButton');
        const termsCheckbox = document.getElementById('termsAgreed');
        const requiredFields = form.querySelectorAll('input[required], select[required]');
        
        const termsModal = document.getElementById('termsModal');
        const openTermsModal = document.getElementById('openTermsModal');
        const closeTermsModal = document.getElementById('closeTermsModal');
        const closeTermsModalFooter = document.getElementById('closeTermsModalFooter');

        // --- 1. Form Validation and Submit Button State ---

        // Checks if all required fields are filled and terms are agreed
        const checkFormValidity = () => {
            let allRequiredFilled = true;
            requiredFields.forEach(field => {
                if (field.value.trim() === '') {
                    allRequiredFilled = false;
                }
            });
            
            // Special check for select element default value
            const barangaySelect = document.getElementById('barangay');
            if (barangaySelect.value === '') {
                allRequiredFilled = false;
            }

            // Enable or disable the submit button
            if (allRequiredFilled && termsCheckbox.checked) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        };

        // Attach event listeners to all required fields and the checkbox
        requiredFields.forEach(field => {
            field.addEventListener('input', checkFormValidity);
        });
        termsCheckbox.addEventListener('change', checkFormValidity);


        // --- 2. Client-Side Validation on Submit ---

        form.addEventListener('submit', (e) => {
            let isValid = true;

            // Remove previous error highlights
            requiredFields.forEach(field => {
                field.classList.remove('border-red-500', 'ring-2', 'ring-red-500/50');
            });
            
            // Check for empty required fields again
            requiredFields.forEach(field => {
                if (field.value.trim() === '' || (field.id === 'barangay' && field.value === '')) {
                    field.classList.add('border-red-500', 'ring-2', 'ring-red-500/50');
                    isValid = false;
                }
            });

            // Password matching and length check
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');
            
            if (password.value !== confirmPassword.value || password.value.length < 8) {
                password.classList.add('border-red-500', 'ring-2', 'ring-red-500/50');
                confirmPassword.classList.add('border-red-500', 'ring-2', 'ring-red-500/50');
                isValid = false;
            } else {
                password.classList.remove('border-red-500', 'ring-2', 'ring-red-500/50');
                confirmPassword.classList.remove('border-red-500', 'ring-2', 'ring-red-500/50');
            }
            
            // Basic email validation
            const emailField = document.getElementById('email');
            const emailRegex = /^[^@]+@[^@]+\.[^@]+$/;
            if (!emailRegex.test(emailField.value.trim())) {
                 emailField.classList.add('border-red-500', 'ring-2', 'ring-red-500/50');
                 isValid = false;
            } else {
                 emailField.classList.remove('border-red-500', 'ring-2', 'ring-red-500/50');
            }


            if (!isValid) {
                e.preventDefault(); // Stop form submission if validation fails
                // In a real app, show a toast/modal error message instead of just logging
                console.error("Client-side validation failed. Please check the highlighted fields.");
                // Prevent further server processing on the client
            } 
            // If isValid is true, the form submits, and PHP handles the final server-side result.
        });

        // Remove error classes when user starts typing/selecting
        form.querySelectorAll('input, select').forEach(field => {
            field.addEventListener('input', () => {
                field.classList.remove('border-red-500', 'ring-2', 'ring-red-500/50');
                checkFormValidity(); // Re-check button state
            });
        });


        // --- 3. Password Toggle Functionality ---

        const setupPasswordToggle = (inputId, buttonId) => {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            const icon = button.querySelector('i');

            button.addEventListener('click', () => {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        };

        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('confirmPassword', 'toggleConfirmPassword');

        // --- 4. Terms and Conditions Modal Logic ---
        const hideTermsModal = () => {
            // Animate out
            termsModal.classList.remove('opacity-100');
            termsModal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                termsModal.classList.add('hidden');
            }, 300);
        };

        openTermsModal.addEventListener('click', (e) => {
            e.preventDefault();
            termsModal.classList.remove('hidden');
            // Animate in
            setTimeout(() => {
                termsModal.classList.add('opacity-100');
                termsModal.querySelector('div').classList.remove('scale-95');
            }, 10);
        });

        closeTermsModal.addEventListener('click', hideTermsModal);
        closeTermsModalFooter.addEventListener('click', () => {
            termsCheckbox.checked = true; // Mark checkbox as checked on acceptance
            checkFormValidity();
            hideTermsModal();
        });
        termsModal.addEventListener('click', (e) => {
            if (e.target === termsModal) {
                hideTermsModal();
            }
        });


        // Final check to set button state on initial load
        checkFormValidity();
    });
</script>

<?php 
    // This loads the footer markup, the final closing body, and html tags
    include 'footer.php'; 
?>