<?php 
    // This loads the HTML head, opening body tag, fixed header, and mobile menu script
    include 'header.php'; 

    // Initialize variables for form fields (client-side and AJAX handle submission)
    $firstName = '';
    $lastName = '';
    $email = '';
    $subject = '';
    $messageBody = '';
?>

<!-- Contact Hero Section -->
<section class="relative bg-gray-900 pt-28 pb-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">
                Get In Touch
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                We're here to answer your questions and provide support. Reach out to the SafeMati team.
            </p>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div id="alertContainer"></div>

        <div class="bg-gray-800 p-8 md:p-12 rounded-2xl shadow-2xl">
            <h2 class="text-2xl font-bold text-white mb-8 border-b border-gray-700 pb-4">Send Us a Message</h2>
            
            <form id="contactForm" method="POST" action="contact_handler.php" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-400 mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" id="firstName" name="firstName" data-error-required="First name is required."
                            class="w-full px-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150" 
                            value="<?php echo $firstName; ?>" autocomplete="given-name">
                        <!-- Error Message Placeholder -->
                        <p id="firstName-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-400 mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" id="lastName" name="lastName" data-error-required="Last name is required."
                            class="w-full px-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150" 
                            value="<?php echo $lastName; ?>" autocomplete="family-name">
                        <!-- Error Message Placeholder -->
                        <p id="lastName-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150" 
                        value="<?php echo $email; ?>" autocomplete="email">
                    <!-- Error Message Placeholder -->
                    <p id="email-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-400 mb-2">Subject <span class="text-red-500">*</span></label>
                    <input type="text" id="subject" name="subject" data-error-required="Subject is required."
                        class="w-full px-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150" 
                        value="<?php echo $subject; ?>" autocomplete="off">
                    <!-- Error Message Placeholder -->
                    <p id="subject-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-400 mb-2">Message <span class="text-red-500">*</span></label>
                    <textarea id="message" name="message" rows="5" data-error-required="Message body is required."
                        class="w-full px-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150"
                        autocomplete="off"><?php echo $messageBody; ?></textarea>
                    <!-- Error Message Placeholder -->
                    <p id="message-error" class="text-red-400 text-xs mt-1 h-4 hidden" aria-live="polite"></p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" id="submitButton"
                        class="btn-gradient w-full px-6 py-3 text-white font-bold rounded-lg text-lg shadow-xl uppercase transform hover:scale-[1.01] transition duration-300">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="py-16 bg-gray-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            
            <!-- Address -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg hover:shadow-red-500/30 transition duration-300 transform hover:translate-y-[-5px]">
                <i class="fa-solid fa-location-dot text-4xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">Our Office</h3>
                <p class="text-gray-400">City Hall Complex, Mati City, Davao Oriental, PH 8200</p>
            </div>

            <!-- Phone -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg hover:shadow-red-500/30 transition duration-300 transform hover:translate-y-[-5px]">
                <i class="fa-solid fa-phone-volume text-4xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">Call Us</h3>
                <p class="text-gray-400">(082) 345-6789 (Local DRRMO)</p>
                <p class="text-gray-400">911 (Emergency Hotline)</p>
            </div>

            <!-- Email -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg hover:shadow-red-500/30 transition duration-300 transform hover:translate-y-[-5px]">
                <i class="fa-solid fa-envelope text-4xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">Email Us</h3>
                <p class="text-gray-400">contact@safemati.gov.ph</p>
                <p class="text-gray-400">drrmo@mati.gov.ph</p>
            </div>

        </div>
    </div>
</section>


<script>
    /**
     * Helper function to display or clear inline error messages and style the input field.
     * @param {HTMLElement} fieldElement The input or textarea element.
     * @param {string} message The error message to display. Empty string to clear.
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
                errorElement.classList.add('block'); // Ensure it takes up space
            }
        } else {
            // Remove red error state and restore default
            fieldElement.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
            fieldElement.classList.add('border-gray-600');
            
            // Hide error message
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.classList.add('hidden');
                errorElement.classList.remove('block');
            }
        }
    }


    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('contactForm');
        const submitButton = document.getElementById('submitButton');
        const alertContainer = document.getElementById('alertContainer');
        
        // Define required fields (excluding email, which has special validation)
        const requiredTextFields = ['firstName', 'lastName', 'subject', 'message'];

        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // 1. Clear all previous errors on submit attempt
            form.querySelectorAll('input, textarea').forEach(field => {
                displayError(field, '');
            });

            // 2. Validate required text/textarea fields
            requiredTextFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const value = field.value.trim();
                if (value === '') {
                    // Get custom error message from data attribute or use a default
                    const errorMessage = field.getAttribute('data-error-required') || `${field.name} is required.`;
                    displayError(field, errorMessage);
                    isValid = false;
                }
            });

            // 3. Granular Email validation (REQUIRED check, then FORMAT check)
            const emailField = document.getElementById('email');
            const emailValue = emailField.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (emailValue === '') {
                // Check 1: Required
                displayError(emailField, 'Email address is required.');
                isValid = false;
            } else if (!emailRegex.test(emailValue)) {
                // Check 2: Invalid format
                displayError(emailField, 'Please enter a valid email address (e.g., example@domain.com).');
                isValid = false;
            } else {
                // Valid: Clear error
                displayError(emailField, '');
            }

            if (!isValid) {
                e.preventDefault(); // Stop form submission if validation fails
                console.log("Validation failed. Please check the highlighted fields.");
                // Restore button state in case it was stuck on 'Sending...' from a previous failed attempt
                submitButton.innerHTML = 'Send Message';
                submitButton.disabled = false;
                return;
            }

            // Prevent default and send via AJAX
            e.preventDefault();
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Sending...';
            submitButton.disabled = true;

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(json => {
                alertContainer.innerHTML = '';
                const div = document.createElement('div');
                if (json.success) {
                    div.className = 'p-4 mb-8 rounded-lg border-l-4 shadow-lg bg-green-500/20 text-green-300 border-green-500';
                    div.role = 'alert';
                    div.innerHTML = '<p class="text-sm font-semibold">' + (json.message || 'Message sent.') + '</p>';
                    form.reset();
                } else {
                    div.className = 'p-4 mb-8 rounded-lg border-l-4 shadow-lg bg-red-500/20 text-red-300 border-red-500';
                    div.role = 'alert';
                    div.innerHTML = '<p class="text-sm font-semibold">' + (json.error || 'Error sending message.') + '</p>';
                }
                alertContainer.appendChild(div);
            })
            .catch(err => {
                alertContainer.innerHTML = '<div class="p-4 mb-8 rounded-lg border-l-4 shadow-lg bg-red-500/20 text-red-300 border-red-500"><p class="text-sm font-semibold">Network error. Please try again.</p></div>';
            })
            .finally(() => {
                submitButton.innerHTML = 'Send Message';
                submitButton.disabled = false;
            });
        });

        // 4. Live feedback: Remove error classes when user starts typing
        form.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', () => {
                // Instantly remove the error message when the user starts correcting it
                displayError(field, '');
            });
        });
    });
</script>

<?php 
    // This loads the footer markup, the final closing body, and html tags
    include 'footer.php'; 
?>