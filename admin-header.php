<?php
    // admin_header.php - Reusable Header and Sidebar component for the SafeMati Admin Panel.
    // Uses SafeMati Red (bg-red-700) for the header and accents, maintaining a clean UI.

    // PHP PLACEHOLDERS (Replace with actual session data)
    $admin_name = "Jane Admin";
    $profile_image_url = "https://placehold.co/150x150/d1d5db/000000?text=JD"; // Gray placeholder image
    
    // PHP Placeholder for the currently active page 
    $active_link = $active_link ?? 'Dashboard';

    // Array of navigation links
    $nav_links = [
        'Dashboard' => ['icon' => 'fa-gauge-high', 'url' => 'admin_dashboard.php'],
        'Users' => ['icon' => 'fa-users', 'url' => 'admin_users.php'],
        'Alerts' => ['icon' => 'fa-bell', 'url' => 'admin_alerts.php'],
        'Reports' => ['icon' => 'fa-chart-line', 'url' => 'admin_reports.php'],
        'Hotlines Management' => ['icon' => 'fa-phone-volume', 'url' => 'admin_hotlines.php'],
        'Guides Management' => ['icon' => 'fa-book-open', 'url' => 'admin_guides.php'],
        'System Logs' => ['icon' => 'fa-list-ol', 'url' => 'admin_logs.php'],
        'Settings' => ['icon' => 'fa-gear', 'url' => 'admin_settings.php'],
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeMati Admin Panel</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Custom utility for the sidebar toggle on small screens (CSS-only hack) */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        #sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            height: calc(100vh - 64px); /* Full height minus header */
            top: 64px; /* Position below header */
        }
        
        #sidebar-toggle:checked ~ #main-wrapper #sidebar {
            transform: translateX(0);
        }
        
        @media (min-width: 768px) {
            #sidebar {
                transform: translateX(0); /* Always visible on desktop */
                width: 280px;
            }
            .content-area {
                margin-left: 280px;
                min-height: calc(100vh - 64px);
            }
        }
        
        @media (max-width: 767px) {
            .content-area {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

<!-- Hidden Checkbox for Mobile Sidebar Toggle -->
<input type="checkbox" id="sidebar-toggle" class="hidden">

<!-- 1. Top Header (Dark/Red) -->
<header class="bg-gray-900 fixed top-0 left-0 right-0 z-30 shadow-lg border-b border-gray-900" style="height: 64px;">
    <div class="flex items-center justify-between h-16 px-4 md:px-6 max-w-full mx-auto">

        <!-- Left: Logo/Brand and Mobile Toggle -->
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Button (Hamburger) - Neutral color on red background -->
            <label for="sidebar-toggle" class="md:hidden p-2 cursor-pointer text-white hover:bg-red-600 rounded-lg transition">
                <i class="fa-solid fa-bars text-xl"></i>
            </label>
            
            <!-- SafeMati Logo -->
            <img src="assets/safemati-logo.png" alt="SafeMati Logo" class="h-14 w-auto object-contain">
            <!-- <span class="text-white text-xl font-bold tracking-wide hidden sm:block">Admin Panel</span> -->
        </div>

        <!-- Center: Search Bar (Neutral White) -->
        <div class="flex-1 max-w-lg mx-4 hidden sm:block">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" placeholder="Search for users, alerts, or reports..." 
                       class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 transition"
                >
            </div>
        </div>

        <!-- Right: Notifications & Profile (White icons on Red background) -->
        <div class="flex items-center space-x-4">
            
            <!-- Notification Icon -->
            <div class="relative hidden sm:block">
                <button class="p-2 text-white hover:text-red-100 hover:bg-red-600 rounded-full transition">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <!-- Notification dot (subtle accent) -->
                    <span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-300 border border-red-700"></span>
                </button>
            </div>
            
            <!-- Admin Profile Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-2 p-1.5 rounded-full hover:bg-red-600 transition focus:outline-none" aria-expanded="false">
                    <!-- Profile Photo Placeholder -->
                    <img src="<?php echo $profile_image_url; ?>" alt="Admin Profile" class="h-8 w-8 rounded-full border border-red-300 object-cover bg-gray-200">
                    <!-- Admin Name (White text) -->
                    <span class="text-sm font-medium text-white hidden md:inline">
                        <?php echo htmlspecialchars($admin_name); ?>
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-red-300 hidden md:inline"></i>
                </button>

                <!-- Dropdown Menu (Neutral White) -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-30">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fa-solid fa-user-circle mr-2 w-4"></i> Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fa-solid fa-gear mr-2 w-4"></i> Settings
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Container for Sidebar and Content -->
<div id="main-wrapper" class="flex" style="margin-top: 64px;">
    
    <!-- 2. Left Sidebar (Fixed) - Neutral White with Red Accent -->
    <aside id="sidebar" class="fixed left-0 bg-white w-72 border-r border-gray-200 z-20 md:static md:translate-x-0 overflow-y-auto shadow-xl md:shadow-none">
        
        <nav class="space-y-2 px-4 py-4">
            <?php foreach ($nav_links as $name => $link): ?>
                <?php
                    $isActive = ($name === $active_link);
                    // Base classes for all links
                    $linkClasses = "flex items-center space-x-3 p-3 text-sm font-medium rounded-lg transition duration-150";
                    
                    // Default hover state
                    $linkClasses .= " text-gray-700 hover:bg-red-50 hover:text-red-700"; 
                    
                    // Active state: Plain background, but highlighted text color, removing border/shadow
                    if ($isActive) {
                        $linkClasses = "flex items-center space-x-3 p-3 text-sm font-medium rounded-lg text-red-700 bg-white transition duration-150"; 
                    }
                ?>
                <a href="<?php echo htmlspecialchars($link['url']); ?>" class="<?php echo $linkClasses; ?>">
                    <i class="fa-solid <?php echo htmlspecialchars($link['icon']); ?> w-5 text-center"></i>
                    <span><?php echo htmlspecialchars($name); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Sidebar Footer -->
        <div class="mt-auto p-4 border-t border-gray-200 hidden md:block">
            <span class="text-xs text-gray-400">SafeMati Disaster Response</span>
        </div>
    </aside>

    
    <!-- This content section is commented out in the original file, but included for completeness of the structure -->
    <!-- <div class="flex-1 content-area p-4 md:p-8 w-full">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome to <?php echo htmlspecialchars($active_link); ?></h1>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 min-h-[500px]">
            <p class="text-gray-600">This is the main content area for the <?php echo htmlspecialchars($active_link); ?> page. Include your main page layout here.</p>
        </div>
    </div> -->
</div>
<!-- End of Main Container -->

<script>
    // Close sidebar on mobile when clicking a link
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const navLinks = document.querySelectorAll('#sidebar a');

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                // Only collapse on small screens
                if (window.innerWidth < 768) {
                    sidebarToggle.checked = false;
                }
            });
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                const toggle = document.querySelector('label[for="sidebar-toggle"]');
                
                if (sidebarToggle.checked && 
                    !sidebar.contains(e.target) && 
                    !toggle.contains(e.target)) {
                    sidebarToggle.checked = false;
                }
            }
        });
    });
</script>
</body>
</html>