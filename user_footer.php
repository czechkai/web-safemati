<?php
/**
 * SafeMati User Footer
 * Reusable, professional, and simple footer for all user pages (Dashboard, Alerts, etc.).
 * Designed to complement the dark user header.
 * * NOTE: For live usage, only the <footer>...</footer> block is typically needed,
 * as the surrounding HTML, Tailwind, and Font Awesome links should be in the main page template.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeMati User Footer Preview</title>
    <!-- Load Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-900 min-h-screen text-white flex flex-col justify-end">
    
    <!-- Placeholder content to push the footer to the bottom for clear viewing -->
    <div class="flex-grow"></div> 

    <footer>
        <!-- Footer Content Container -->
        <!-- Dark background (#121212) and a subtle red border/shadow consistent with the header theme -->
        <div class="bg-[#121212] border-t border-red-500/20 shadow-inner py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center justify-center space-y-6">

                    <!-- 1. Support Links (Relevant to logged-in users) -->
                    <nav class="flex flex-wrap justify-center space-x-6 sm:space-x-10 text-sm font-medium">
                        <a href="user_profile.php" class="text-gray-400 hover:text-red-500 transition duration-300">Profile Settings</a>
                        <a href="#" class="text-gray-400 hover:text-red-500 transition duration-300">Help & Support</a>
                        <a href="#" class="text-gray-400 hover:text-red-500 transition duration-300">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-red-500 transition duration-300">Terms of Service</a>
                    </nav>

                    <!-- 2. Social Media Icons (Light grey icons, red hover accent) -->
                    <div class="flex space-x-6 text-xl">
                        <!-- Facebook -->
                        <a href="#" aria-label="Facebook" class="text-gray-500 hover:text-red-500 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <!-- Twitter -->
                        <a href="#" aria-label="Twitter" class="text-gray-500 hover:text-red-500 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <!-- Instagram -->
                        <a href="#" aria-label="Instagram" class="text-gray-500 hover:text-red-500 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <!-- LinkedIn -->
                        <a href="#" aria-label="LinkedIn" class="text-gray-500 hover:text-red-500 transition duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>

                    <!-- 3. Copyright Text (Centered) -->
                    <p class="text-sm text-gray-500 text-center">
                        &copy; SafeMati — All Rights Reserved.
                    </p>

                </div>
            </div>
        </div>
    </footer>

</body>
</html>