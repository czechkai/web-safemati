<?php
    // Determine the current page filename (e.g., 'index.php', 'about.php')
    // This allows the script to apply highlighting dynamically.
    $current_page = basename($_SERVER['PHP_SELF']);
    
    /**
     * Checks if the given page link matches the current page and returns 
     * the appropriate Tailwind classes for active or inactive state.
     */
    function is_active($page, $current) {
        if ($page === $current) {
            // Active classes: Red text, bold font, and a bottom border
            return 'text-red-500 font-extrabold border-b-2 border-red-500'; 
        }
        // Inactive classes: Gray text, hover effect, transparent border for alignment
        return 'text-gray-300 hover:text-red-500 border-b-2 border-transparent';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeMati Header Design</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Custom Configuration for Dark Theme */
        :root {
            --header-bg: #1a1a1a;
            --text-color: #f3f4f6; /* light gray */
            --accent-red: #ef4444; /* red-500 */
        }

        /* Set default font to Inter for a sleek look (Tailwind default is PostCSS which often resolves to system sans-serif, but setting a specific custom font-family for assurance) */
        html { font-family: 'Inter', sans-serif; }

        /* The background of the entire header */
        .header-bg {
            background-color: var(--header-bg);
            /* Subtle glow effect using box-shadow for a 'pop' */
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); /* Red glow effect */
        }

        /* Custom Hover Effect for Nav Links */
        .nav-link {
            position: relative;
            padding: 8px 0;
            transition: color 0.3s ease;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            display: block;
            margin-top: 5px;
            left: 50%;
            background: var(--accent-red);
            transition: width 0.3s ease, left 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
            left: 0;
        }

        /* Custom Button Gradient (Matches the red theme) */
        .btn-gradient {
            background-image: linear-gradient(to right, #b91c1c, #dc2626); /* Red-700 to Red-600 */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.5); /* Highlight on hover */
        }

        /* Styling for the mobile menu dropdown */
        .mobile-menu-drawer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }

        .mobile-menu-drawer.open {
            max-height: 500px; /* Sufficient height to show content */
            transition: max-height 0.4s ease-in;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen text-white">

    <header class="header-bg fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Left Side: Logo/Branding -->
                <div class="flex-shrink-0">
                    <a href="#" class="flex items-center">
                        <img src="assets/safemati-logo.png" alt="SafeMati Logo Placeholder" 
                             class="h-12 w-auto rounded-lg mr-3 hidden sm:inline-block">
                    </a>
                </div>

                <!-- Center: Desktop Navigation (Hidden on Mobile) -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 h-full items-center">
                        <!-- Home Link -->
                        <a href="index.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                            <?php echo is_active('index.php', $current_page); ?>">
                            Home
                        </a>
                        <!-- About Us Link -->
                        <a href="about.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                            <?php echo is_active('about.php', $current_page); ?>">
                            About Us
                        </a>
                        <!-- Disaster Guides Link -->
                        <a href="guides.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                            <?php echo is_active('guides.php', $current_page); ?>">
                            Disaster Guides
                        </a>
                        <!-- Emergency Hotlines Link -->
                        <a href="hotlines.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                            <?php echo is_active('hotlines.php', $current_page); ?>">
                            Emergency Hotlines
                        </a>

                         <a href="contact.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                            <?php echo is_active('contact.php', $current_page); ?>">
                            Contact
                        </a>
                    </div>

                <!-- Right Side: Action Buttons (Hidden on Mobile) - FIXED SIZES -->
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="login.php" ><button class="w-28 flex items-center justify-center px-4 py-2 text-white font-semibold rounded-lg bg-gray-800 border border-red-600 hover:bg-gray-700 transition duration-300">
                        <i class="fa-solid fa-user mr-2"></i> Login
                    </button>
                    </a>
                    
                    <a href="signup.php">
                    <button class="w-28 btn-gradient flex items-center justify-center px-4 py-3 text-white font-bold rounded-lg shadow-md uppercase text-sm">
                        Sign Up
                    </button>
                    </a>
                </div>

                <!-- Mobile Menu Button (Hamburger) -->
                <div class="sm:hidden" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1 px-2">
                <!-- Mobile Links use the same active logic -->
                <a href="index.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('index.php', $current_page); ?>">
                    Home
                </a>
                <a href="about.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('about.php', $current_page); ?>">
                    About Us
                </a>
                <a href="guides.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('guides.php', $current_page); ?>">
                    Disaster Guides
                </a>
                <a href="hotlines.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('hotlines.php', $current_page); ?>">
                    Emergency Hotlines
                </a>

                <a href="contact.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('contact.php', $current_page); ?>">
                    Contact
                </a>
                
                <!-- Mobile Auth Buttons -->
                <div class="pt-2 border-t border-gray-700 space-y-2">
                    <button class="w-full text-left px-3 py-2 text-base font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-150">
                        <i class="fa-solid fa-user-plus mr-2"></i> Sign Up
                    </button>
                    <button class="w-full text-left px-3 py-2 text-base font-medium text-red-500 border border-red-500 rounded-lg hover:bg-red-500 hover:text-white transition duration-150">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i> Log In
                    </button>
                </div>
            </div>
        </div>

            </div>
        </div>

        <!-- Mobile Menu Dropdown Content -->
        <div id="mobile-menu-drawer" class="mobile-menu-drawer lg:hidden header-bg border-t border-gray-700/50">
            <div class="px-2 pt-2 pb-3 space-y-2 sm:px-3">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-red-500 transition duration-200">Home</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-red-500 transition duration-200">About</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-red-500 transition duration-200">Emergency Hotlines</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-red-500 transition duration-200">Disaster Guides</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-red-500 transition duration-200">Contact</a> 
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-red-500 transition duration-200">
                    <i class="fa-solid fa-phone-volume mr-2"></i> Contact
                </a>
                
                <!-- Mobile Login/Sign Up Buttons -->
                <div class="pt-4 border-t border-gray-700/50 space-y-2">
                    <button class="w-full px-3 py-2 text-white font-semibold rounded-lg bg-gray-800 border border-red-600 hover:bg-gray-700 transition duration-300 text-base">
                        <i class="fa-solid fa-user mr-2"></i> Login
                    </button>
                    <button class="btn-gradient w-full px-3 py-2 text-white font-bold rounded-lg text-base shadow-md uppercase">
                        Sign Up
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Adding padding below the fixed header to show it clearly -->
    <!-- <div class="pt-24 h-screen bg-gray-900"></div> -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
            const menuIcon = menuToggle.querySelector('i');

            if (menuToggle && mobileMenuDrawer) {
                menuToggle.addEventListener('click', () => {
                    // Toggle the 'open' class for CSS transition effect
                    mobileMenuDrawer.classList.toggle('open');
                    
                    // Toggle the hamburger icon to an 'X' (or close icon)
                    if (mobileMenuDrawer.classList.contains('open')) {
                        menuIcon.classList.remove('fa-bars');
                        menuIcon.classList.add('fa-xmark');
                    } else {
                        menuIcon.classList.remove('fa-xmark');
                        menuIcon.classList.add('fa-bars');
                    }
                });
            }
        });
    </script>




</body>
</html>