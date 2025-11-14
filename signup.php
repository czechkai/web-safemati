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

        // 2. Simple Validation Checks
        $errors = [];
        if (empty($firstName) || empty($lastName) || empty($email) || empty($contactNumber) || empty($houseStreetSubd) || empty($barangay)) {
            $errors[] = "Please fill out all required personal and address fields.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        }
        if (strlen($contactNumber) < 10) {
            $errors[] = "Contact number must be at least 10 digits long.";
        }
        if (!in_array($barangay, $barangays)) {
            $errors[] = "Invalid Barangay selected.";
        }
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }
        if (!$termsAgreed) {
            $errors[] = "You must agree to the Terms and Conditions.";
        }


        // 3. Process Result
        if (empty($errors)) {
            // --- In a real application, you would save the user data to a database here ---
            // Example: $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Example: saveUserToDatabase($firstName, $lastName, $email, $hashedPassword, ...);
            // --- End of database logic ---

            $message = 'Success! Your account has been registered. You will be redirected in 3 seconds.';
            $status_class = 'bg-green-500/20 text-green-300 border-green-500';
            
            // Script for redirection after success
            $redirect_script = 'setTimeout(() => { window.location.href = "index.php"; }, 3000);';
            
            // Clear form data on success
            $formData = array_fill_keys(array_keys($formData), '');
            $formData['termsAgreed'] = 'off';

        } else {
            $message = 'Registration Failed: ' . implode(' ', $errors);
            $status_class = 'bg-red-500/20 text-red-300 border-red-500';
            // Do NOT clear formData so user can fix inputs
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeMati User Registration</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Custom styles for the gradient button */
        .btn-gradient {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover:not(:disabled) {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .btn-gradient:disabled {
            background: #4b5563; /* Gray background for disabled */
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        /* Style for the terms and conditions scrollable area */
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-900 font-sans antialiased text-gray-100">

    <!-- Main Registration Container -->
    <!-- Removed pt-24 and used py-12 for generic vertical padding, ensured centering, and full viewport height -->
    <div class="py-12 px-4 min-h-screen flex items-center justify-center">
        <!-- Form Card Container - Increased width to max-w-4xl for a wider form -->
        <div id="signup-form-card" class="max-w-9xl w-full p-6 sm:p-10 space-y-8 bg-gray-800 rounded-xl shadow-2xl relative mx-auto">
            
            <h1 class="text-4xl font-extrabold text-red-500 text-center">SafeMati Registration</h1>
            <p class="text-center text-gray-400">Join us to receive real-time disaster and safety alerts for Mati City.</p>

            <!-- Status/Message Alert -->
            <?php if ($message): ?>
                <div id="status-message" class="p-4 rounded-lg border-l-4 font-semibold text-center <?= htmlspecialchars($status_class) ?>" role="alert">
                    <p><?= htmlspecialchars($message) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" id="signup-form" class="space-y-6">

                <!-- Section 1: Personal Information -->
                <fieldset class="border border-gray-700 p-4 rounded-lg">
                    <legend class="text-red-400 px-2 text-lg font-semibold">Personal Information</legend>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-300 mb-2">First Name <span class="text-red-500">*</span></label>
                            <input type="text" id="firstName" name="firstName" required value="<?= htmlspecialchars($formData['firstName']) ?>"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm"
                                placeholder="Juan">
                        </div>
                        <div>
                            <label for="middleName" class="block text-sm font-medium text-gray-300 mb-2">Middle Name</label>
                            <input type="text" id="middleName" name="middleName" value="<?= htmlspecialchars($formData['middleName']) ?>"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm"
                                placeholder="Dela Cruz">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-300 mb-2">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" id="lastName" name="lastName" required value="<?= htmlspecialchars($formData['lastName']) ?>"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm"
                                placeholder="Tamad">
                        </div>
                    </div>
                </fieldset>

                <!-- Section 2: Contact Information -->
                <fieldset class="border border-gray-700 p-4 rounded-lg">
                    <legend class="text-red-400 px-2 text-lg font-semibold">Contact Details</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($formData['email']) ?>"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm"
                                placeholder="juan@example.com">
                        </div>
                        <div>
                            <label for="contactNumber" class="block text-sm font-medium text-gray-300 mb-2">Contact Number <span class="text-red-500">*</span></label>
                            <input type="tel" id="contactNumber" name="contactNumber" required value="<?= htmlspecialchars($formData['contactNumber']) ?>"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm"
                                placeholder="09XX-XXX-XXXX" pattern="[0-9]{10,11}">
                        </div>
                    </div>
                </fieldset>

                <!-- Section 3: Residential Address (Mati City Only) -->
                <fieldset class="border border-gray-700 p-4 rounded-lg">
                    <legend class="text-red-400 px-2 text-lg font-semibold">Residential Address</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="barangay" class="block text-sm font-medium text-gray-300 mb-2">Barangay <span class="text-red-500">*</span></label>
                            <select id="barangay" name="barangay" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm appearance-none">
                                <option value="">Select your Barangay</option>
                                <?php foreach ($barangays as $b): ?>
                                    <option value="<?= htmlspecialchars($b) ?>" <?= $formData['barangay'] === $b ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($b) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="houseStreetSubd" class="block text-sm font-medium text-gray-300 mb-2">House No./Street/Subdivision <span class="text-red-500">*</span></label>
                            <input type="text" id="houseStreetSubd" name="houseStreetSubd" required value="<?= htmlspecialchars($formData['houseStreetSubd']) ?>"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm"
                                placeholder="24 Mahogany Street">
                        </div>
                    </div>
                </fieldset>
                
                <!-- Section 4: Account Credentials -->
                <fieldset class="border border-gray-700 p-4 rounded-lg">
                    <legend class="text-red-400 px-2 text-lg font-semibold">Account Credentials</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password (min. 8 characters) <span class="text-red-500">*</span></label>
                            <input type="password" id="password" name="password" required minlength="8"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm pr-10"
                                placeholder="********">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 top-6 pt-1 flex items-center pr-3 text-gray-400 hover:text-red-400">
                                <i class="fa-solid fa-eye-slash"></i>
                            </button>
                        </div>
                        <div class="relative">
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-200 shadow-sm pr-10"
                                placeholder="********">
                            <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 top-6 pt-1 flex items-center pr-3 text-gray-400 hover:text-red-400">
                                <i class="fa-solid fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </fieldset>

                <!-- Terms and Conditions & Submit -->
                <div class="space-y-6 pt-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="termsAgreed" name="termsAgreed" type="checkbox"
                                class="h-4 w-4 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500"
                                <?= $formData['termsAgreed'] === 'on' ? 'checked' : '' ?>>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="termsAgreed" class="font-medium text-gray-300">
                                I agree to the
                                <a href="#" id="openTermsModal" class="text-red-400 hover:text-red-300 font-semibold underline transition duration-150 ease-in-out">
                                    Terms and Conditions
                                </a> <span class="text-red-500">*</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="submit-button" disabled
                        class="btn-gradient w-full px-6 py-4 text-white font-bold rounded-lg text-lg shadow-xl uppercase transition duration-300">
                        Register Account
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-gray-400 text-sm">
                Already have an account? <a href="login.php" class="text-red-400 hover:text-red-300 font-semibold transition duration-150 ease-in-out">Log In here</a>.
            </p>
        </div>
    </div>


    <!-- Terms and Conditions Modal (Hidden by default) -->
    <div id="terms-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-70 transition-opacity duration-300 opacity-0" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <!-- Modal Content Card -->
            <div class="bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all duration-300 scale-95 sm:my-8 sm:w-full sm:max-w-4xl w-full">
                <div class="bg-gray-800 px-6 py-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-700">
                        <h3 class="text-2xl leading-6 font-extrabold text-red-400" id="modal-title">
                            Terms and Conditions for SafeMati
                        </h3>
                        <button type="button" id="closeTermsModal" class="text-gray-400 hover:text-red-500 focus:outline-none transition-colors">
                            <i class="fa-solid fa-xmark text-2xl"></i>
                        </button>
                    </div>

                    <div class="modal-body mt-4 text-gray-300 space-y-4">
                        <p class="text-sm">Welcome to SafeMati. By creating an account, you agree to the following terms and conditions:</p>
                        
                        <h4 class="text-lg font-semibold text-red-300">1. Purpose of Service</h4>
                        <p>SafeMati is a public safety alert system for the residents of Mati City, Davao Oriental. Its primary function is to disseminate real-time warnings, advisories, and post-disaster information related to natural and human-made hazards. This service is intended to supplement official government communication channels and should not be relied upon as the sole source of emergency information.</p>

                        <h4 class="text-lg font-semibold text-red-300">2. User Responsibilities</h4>
                        <ul class="list-disc list-inside space-y-2 pl-4 text-sm">
                            <li>**Accurate Information:** You must provide accurate and truthful personal and residential information, including your full name, contact details, and current barangay address within Mati City.</li>
                            <li>**Security:** You are responsible for maintaining the confidentiality of your account password and for all activities that occur under your account.</li>
                            <li>**Emergency Preparedness:** You acknowledge that this system is a notification tool and does not replace personal emergency preparedness, evacuation planning, or adherence to official disaster response protocols.</li>
                        </ul>

                        <h4 class="text-lg font-semibold text-red-300">3. Data Privacy and Use</h4>
                        <p>Your personal data is collected solely for the purpose of geographically targeted alert dissemination and disaster management record-keeping by the City Disaster Risk Reduction and Management Office (CDRRMO) of Mati City. Your data will not be shared with third parties for marketing purposes. By agreeing, you consent to the processing of your data in accordance with the Philippine Data Privacy Act of 2012.</p>

                        <h4 class="text-lg font-semibold text-red-300">4. Limitation of Liability</h4>
                        <p>The City Government of Mati and its affiliated agencies (SafeMati) are not liable for any direct, indirect, incidental, or consequential damages resulting from the use or inability to use the service, including but not limited to, delays in or failures of alert transmission, or reliance on the information provided. While every effort is made to ensure accuracy, the nature of emergency reporting means information may sometimes be delayed or incomplete.</p>

                        <h4 class="text-lg font-semibold text-red-300">5. Service Availability</h4>
                        <p>The SafeMati service may be subject to limitations, delays, and other problems inherent in the use of the internet and electronic communications. We do not warrant that the service will be uninterrupted or error-free.</p>
                        
                        <p class="text-sm italic pt-4">By clicking 'Accept and Close', you confirm that you have read, understood, and agree to be bound by these Terms and Conditions.</p>
                    </div>
                </div>
                <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="closeTermsModalFooter"
                        class="btn-gradient w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-bold text-white uppercase sm:ml-3 sm:w-auto sm:text-sm transform hover:scale-[1.01] transition duration-300">
                        Accept and Close
                    </button>
                    <button type="button" id="cancelTermsModal"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-gray-200 hover:bg-gray-500 sm:mt-0 sm:w-auto sm:text-sm transition duration-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>


<script>
    // --- Server-side redirect script (only runs on successful submission) ---
    <?= $redirect_script ?>
    // -----------------------------------------------------------------------

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('signup-form');
        const submitButton = document.getElementById('submit-button');
        const termsCheckbox = document.getElementById('termsAgreed');
        
        // Modal elements
        const termsModal = document.getElementById('terms-modal');
        const openTermsModal = document.getElementById('openTermsModal');
        const closeTermsModal = document.getElementById('closeTermsModal');
        const closeTermsModalFooter = document.getElementById('closeTermsModalFooter');
        const cancelTermsModal = document.getElementById('cancelTermsModal');


        // --- 1. Form Validation and Button State ---

        // Function to check if all required fields are filled and valid
        const checkFormValidity = () => {
            let isFormValid = true;

            // Check required personal/address fields
            const requiredFields = ['firstName', 'lastName', 'email', 'contactNumber', 'houseStreetSubd', 'barangay', 'password', 'confirmPassword'];
            requiredFields.forEach(id => {
                const field = document.getElementById(id);
                if (!field || field.value.trim() === '') {
                    isFormValid = false;
                }
            });

            // Check email format
            const emailField = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailField && !emailRegex.test(emailField.value.trim())) {
                isFormValid = false;
            }
            
            // Check password match and minimum length
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirmPassword');
            if (passwordField && confirmPasswordField) {
                if (passwordField.value.length < 8) {
                    isFormValid = false;
                }
                if (passwordField.value !== confirmPasswordField.value) {
                    isFormValid = false;
                }
            }

            // Check terms agreement
            if (!termsCheckbox || !termsCheckbox.checked) {
                isFormValid = false;
            }

            // Update button state
            submitButton.disabled = !isFormValid;
        };
        
        // Add listeners to all relevant inputs to check validity on change/input
        form.querySelectorAll('input, select').forEach(field => {
            field.addEventListener('input', checkFormValidity);
        });

        // Add listener for password change to update the match visual cue
        document.getElementById('password').addEventListener('input', checkFormValidity);
        document.getElementById('confirmPassword').addEventListener('input', checkFormValidity);

        // Add listener for the terms checkbox
        termsCheckbox.addEventListener('change', checkFormValidity);
        
        
        // --- 2. Client-side Form Submission Handler ---
        form.addEventListener('submit', (e) => {
            // Note: PHP handles the final submission logic on the server.
            // This client-side code just adds a loading state.
            if (!submitButton.disabled) {
                submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Processing...';
                // The disabled state is already managed by checkFormValidity
            } else {
                 // In a real application, you'd show a custom error message box here.
                 e.preventDefault();
                 console.log("Form submission blocked due to invalid or incomplete data.");
            }
        });


        // --- 3. Password Toggle Functionality ---
        const setupPasswordToggle = (inputId, toggleId) => {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);
            
            if (!input || !toggle) return;

            toggle.addEventListener('click', () => {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                
                const icon = toggle.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
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
        
        // Logic for 'Accept and Close'
        closeTermsModalFooter.addEventListener('click', () => {
            termsCheckbox.checked = true; // Mark checkbox as checked on acceptance
            checkFormValidity();
            hideTermsModal();
        });

        // Logic for 'Cancel'
        cancelTermsModal.addEventListener('click', hideTermsModal);

        // Close modal when clicking outside
        termsModal.addEventListener('click', (e) => {
            if (e.target === termsModal) {
                hideTermsModal();
            }
        });


        // Final check to set button state on initial load
        checkFormValidity();
    });
</script>

</body>
</html>