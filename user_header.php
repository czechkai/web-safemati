<?php
/**
 * SafeMati User Header - Tailwind CSS Edition
 * Includes session start, login check, dynamic active link highlighting, and a robust profile dropdown.
 */
session_start();

// 1. Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 2. Determine the current page filename (e.g., 'dashboard.php') for highlighting.
$current_page = basename($_SERVER['PHP_SELF']);

// 3. User Data Simulation (Replace with actual data fetch from database if needed)
$user_id = $_SESSION['user_id'] ?? 'SM-1001';
$user_firstname = $_SESSION['user_firstname'] ?? 'Shekinah Abegail';
$user_lastname = $_SESSION['user_lastname'] ?? 'Jaljis';
$user_full_name = htmlspecialchars($user_firstname . ' ' . $user_lastname);
$user_email = $_SESSION['user_email'] ?? 'shekinah@safemati.com';
    
/**
 * Checks if the given page link matches the current page and returns 
 * the appropriate Tailwind classes for active or inactive state.
 */
function is_active($page, $current) {
    if ($page === $current) {
        // Active classes: Red text, bold font, and a bottom border
        // This makes the link highlighted/bold on its corresponding page.
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
    <title>SafeMati User Dashboard</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Custom Configuration for Dark Theme */
        :root {
            --header-bg: #1a1a1a;
            --dropdown-bg: #2c2c2c; /* Darker than header for contrast */
            --text-color: #f3f4f6; /* light gray */
            --accent-red: #ef4444; /* red-500 */
        }

        /* Set default font to Inter for a sleek look */
        html { font-family: 'Inter', sans-serif; }

        /* The background of the entire header */
        .header-bg {
            background-color: var(--header-bg);
            /* Subtle glow effect using box-shadow for a 'pop' */
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); /* Red glow effect */
        }

        /* Mobile Menu Drawer Styling */
        .mobile-menu-drawer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }

        .mobile-menu-drawer.open {
            max-height: 500px; /* Sufficient height to show content */
            transition: max-height 0.4s ease-in;
        }

        /* Consistent Profile/Icon Button Styling */
        .icon-circle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #2c2c2c; 
            transition: background-color 0.2s ease;
        }

        .icon-circle-btn:hover {
            background-color: #4a4a4a;
        }
        
        /* Dropdown specific styling */
        .profile-dropdown {
            background-color: var(--dropdown-bg);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #3d3d3d;
        }
        
        .profile-link {
            border-bottom: 1px solid #4a4a4a; /* Separator line */
            padding-bottom: 12px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen text-white">

    <header class="header-bg fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- ⬅️ Left Side: Logo/Branding -->
                <div class="flex-shrink-0 flex items-center">
                    <!-- Logo - Using requested file path and circular style -->
                    <a href="dashboard.php" class="flex items-center">
                        <img src="assets/safemati-logo.png" alt="SafeMati Logo" 
                             class="h-12 w-auto rounded-full mr-3">
                    </a>
                </div>

                <!-- Center: Desktop Navigation (Hidden on Mobile) -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 h-full items-center">
                    <!-- Dashboard Link (Default Active) -->
                    <a href="dashboard.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_dashboard.php', $current_page); ?>">
                        Dashboard
                    </a>
                    <!-- Alerts Link -->
                    <a href="user_alerts.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_alerts.php', $current_page); ?>">
                        Alerts
                    </a>
                    <!-- Hotlines Link -->
                    <a href="user_hotlines.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_hotlines.php', $current_page); ?>">
                        Hotlines
                    </a>
                    <!-- Guides Link -->
                    <a href="user_guides.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_guides.php', $current_page); ?>">
                        Guides
                    </a>
                </div>

                <!-- ➡️ Right Side: Icons and Profile Dropdown -->
                <div class="flex items-center space-x-3 relative">
                    
                    <!-- Notifications Icon (Circular) -->
                    <button class="icon-circle-btn text-gray-400 hover:text-red-500 relative hidden sm:flex" aria-label="Notifications">
                        <i class="fa-solid fa-bell text-lg"></i>
                        <!-- Optional: Notification Badge -->
                        <span class="absolute top-0.5 right-0.5 h-2 w-2 rounded-full bg-red-600 border border-red-500"></span>
                    </button>

                    <!-- Profile Dropdown Trigger (Circular Icon) -->
                    <button id="profile-menu-button" class="icon-circle-btn text-gray-400 hover:text-red-500 relative hidden sm:flex" aria-expanded="false" aria-haspopup="true">
                        <!-- Use PHP to set the user's initial or placeholder -->
                        <i class="fa-solid fa-user text-lg"></i>
                    </button>

                    <!-- Profile Dropdown Menu (Hidden by default) -->
                    <div id="profile-dropdown-menu" class="profile-dropdown absolute right-0 top-12 mt-2 w-72 rounded-lg shadow-xl z-50 p-3 hidden" role="menu" aria-orientation="vertical" aria-labelledby="profile-menu-button">
                        
                        <!-- Top Section: User Profile Link -->
                        <a href="user_profile.php" class="dropdown-item profile-link">
                            <i class="fa-solid fa-user-circle text-3xl mr-3 text-red-500"></i>
                            <div>
                                <p class="text-sm font-semibold text-white"><?php echo $user_full_name; ?></p>
                                <p class="text-xs text-gray-400">View your profile</p>
                            </div>
                        </a>
                        
                        <!-- Section 1: Contextual Links (Inspired by FB dropdown) -->
                        <a href="#" class="dropdown-item">
                            <span class="p-2 rounded-full bg-gray-700 text-gray-300 mr-3"><i class="fa-solid fa-gear"></i></span>
                            Settings & privacy
                        </a>
                        <a href="#" class="dropdown-item">
                            <span class="p-2 rounded-full bg-gray-700 text-gray-300 mr-3"><i class="fa-solid fa-circle-question"></i></span>
                            Help & support
                        </a>
                        <a href="#" class="dropdown-item">
                            <span class="p-2 rounded-full bg-gray-700 text-gray-300 mr-3"><i class="fa-solid fa-comment-dots"></i></span>
                            Give feedback
                        </a>

                        <!-- Logout Link (Integrated into dropdown) -->
                        <div class="pt-2 mt-2 border-t border-gray-700/50">
                            <a href="login.php" class="dropdown-item text-red-400 hover:text-red-300">
                                <span class="p-2 rounded-full bg-gray-700 mr-3"><i class="fa-solid fa-right-from-bracket"></i></span>
                                Log Out
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Menu Button (Hamburger) -->
                    <button id="menu-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500 sm:hidden" aria-controls="mobile-menu-drawer" aria-expanded="false">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown Content -->
        <div id="mobile-menu-drawer" class="mobile-menu-drawer sm:hidden header-bg border-t border-gray-700/50">
            <div class="px-2 pt-2 pb-3 space-y-2">
                <!-- Mobile Profile Link -->
                <a href="user_profile.php" class="block rounded-md px-3 py-2 text-base font-medium text-red-500 border-b border-gray-700/50 hover:bg-gray-800 transition duration-200">
                    <i class="fa-solid fa-user-circle mr-2"></i> <?php echo $user_full_name; ?>
                </a>

                <!-- Mobile Navigation Links -->
                <a href="dashboard.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('dashboard.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-house-user mr-2"></i> Dashboard
                </a>
                <a href="user_alerts.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('user_alerts.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-bell mr-2"></i> Alerts
                </a>
                <a href="user_hotlines.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('user_hotlines.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-phone-alt mr-2"></i> Hotlines
                </a>
                <a href="user_guides.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('user_guides.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-book-open mr-2"></i> Guides
                </a>

                <!-- Mobile Logout Button (Contextual) -->
                <div class="pt-4 border-t border-gray-700/50">
                    <a href="logout.php" class="block rounded-md px-3 py-2 text-base font-medium bg-red-600 text-white hover:bg-red-700 transition duration-200">
                        <i class="fa-solid fa-sign-out-alt mr-2"></i> Log Out
                    </a>
                </div>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
            const profileMenuButton = document.getElementById('profile-menu-button');
            const profileDropdownMenu = document.getElementById('profile-dropdown-menu');

            // --- 1. Mobile Menu Toggle ---
            if (menuToggle && mobileMenuDrawer) {
                menuToggle.addEventListener('click', () => {
                    const isExpanded = mobileMenuDrawer.classList.toggle('open');
                    menuToggle.setAttribute('aria-expanded', isExpanded);

                    // Toggle icon
                    const menuIcon = menuToggle.querySelector('i');
                    if (isExpanded) {
                        menuIcon.classList.replace('fa-bars', 'fa-xmark');
                    } else {
                        menuIcon.classList.replace('fa-xmark', 'fa-bars');
                    }
                });
            }
            
            // --- 2. Profile Dropdown Toggle ---
            if (profileMenuButton && profileDropdownMenu) {
                profileMenuButton.addEventListener('click', () => {
                    const isExpanded = profileDropdownMenu.classList.toggle('hidden');
                    profileMenuButton.setAttribute('aria-expanded', !isExpanded);
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', (event) => {
                    if (
                        !profileDropdownMenu.contains(event.target) && 
                        !profileMenuButton.contains(event.target) && 
                        !profileDropdownMenu.classList.contains('hidden')
                    ) {
                        profileDropdownMenu.classList.add('hidden');
                        profileMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>
    
    <!-- You can use this div in your main page body to ensure content starts below the fixed header: -->
    <!-- <div class="pt-24">...page content...</div> -->

</body>
</html>