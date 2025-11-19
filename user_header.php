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

// 3. Fetch User Data from Database
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    require_once 'db_connect.php';
    $user_query = "SELECT * FROM users WHERE user_id = ?";
    $user_stmt = $conn->prepare($user_query);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_data = $user_result->fetch_assoc();
    $user_stmt->close();
    
    if ($user_data) {
        // Update session with latest data
        $_SESSION['user_name'] = $user_data['name'];
        $_SESSION['user_email'] = $user_data['email'];
        $_SESSION['user_barangay'] = $user_data['barangay'];
        $_SESSION['user_phone'] = $user_data['phone_number'] ?? '';
        
        $user_full_name = htmlspecialchars($user_data['name']);
        $user_email = htmlspecialchars($user_data['email']);
        $user_barangay = htmlspecialchars($user_data['barangay']);
        $user_initial = strtoupper(substr($user_data['name'], 0, 1));
        $user_profile_pic = $user_data['profile_picture'] ?? '';
    }
} else {
    // Fallback values
    $user_full_name = htmlspecialchars($_SESSION['user_name'] ?? 'User');
    $user_email = htmlspecialchars($_SESSION['user_email'] ?? 'user@safemati.com');
    $user_barangay = htmlspecialchars($_SESSION['user_barangay'] ?? 'Mati City');
    $user_initial = strtoupper(substr($user_full_name, 0, 1));
    $user_profile_pic = '';
}
    
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
                    <a href="user_dashboard.php" class="flex items-center">
                        <img src="assets/safemati-logo.png" alt="SafeMati Logo" 
                             class="h-12 w-auto rounded-full mr-3">
                    </a>
                </div>

                <!-- Center: Desktop Navigation (Hidden on Mobile) -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 h-full items-center">
                    <!-- Dashboard Link -->
                    <a href="user_dashboard.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_dashboard.php', $current_page); ?>">
                        Dashboard
                    </a>
                    <!-- Alerts Link -->
                    <a href="user_alerts.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_alerts.php', $current_page); ?>">
                        Alerts
                    </a>
                    <!-- Disaster Guides Link -->
                    <a href="user_guides.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_guides.php', $current_page); ?>">
                        Disaster Guides
                    </a>
                    <!-- Emergency Hotlines Link -->
                    <a href="user_hotlines.php" class="inline-flex items-center h-full px-1 pt-1 text-sm font-medium transition duration-200 
                        <?php echo is_active('user_hotlines.php', $current_page); ?>">
                        Emergency Hotlines
                    </a>
                </div>

                <!-- ➡️ Right Side: Icons and Profile Dropdown -->
                <div class="flex items-center space-x-3 relative">
                    
                    <!-- Notifications Icon (Circular) -->
                    <button id="notification-menu-button" class="icon-circle-btn text-gray-400 hover:text-red-500 relative hidden sm:flex" aria-label="Notifications" aria-expanded="false" aria-haspopup="true">
                        <i class="fa-solid fa-bell text-lg"></i>
                        <!-- Notification Badge with Count -->
                        <span id="notification-badge" class="absolute top-0.5 right-0.5 min-w-[18px] h-[18px] rounded-full bg-red-600 border border-red-500 flex items-center justify-center text-[10px] font-bold hidden">0</span>
                    </button>
                    
                    <!-- Notification Dropdown Menu (Hidden by default) -->
                    <div id="notification-dropdown-menu" class="profile-dropdown absolute right-12 top-12 mt-2 w-96 rounded-lg shadow-xl z-50 hidden" role="menu" aria-orientation="vertical" aria-labelledby="notification-menu-button">
                        <div class="p-4 border-b border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-white">Notifications</h3>
                                <button id="mark-all-read-btn" class="text-xs text-red-400 hover:text-red-300">Mark all as read</button>
                            </div>
                        </div>
                        
                        <!-- Notification List -->
                        <div id="notification-list" class="max-h-96 overflow-y-auto">
                            <!-- Loading state -->
                            <div class="p-8 text-center text-gray-400">
                                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                                <p>Loading notifications...</p>
                            </div>
                        </div>
                        
                        <div class="p-3 border-t border-gray-700 text-center">
                            <a href="user_notifications.php" class="text-sm text-red-400 hover:text-red-300 font-semibold">
                                View All Notifications <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Profile Dropdown Trigger (Circular Icon) -->
                    <button id="profile-menu-button" class="icon-circle-btn text-gray-400 hover:text-red-500 relative hidden sm:flex overflow-hidden" aria-expanded="false" aria-haspopup="true">
                        <?php if (!empty($user_profile_pic) && file_exists($user_profile_pic)): ?>
                            <img src="<?php echo htmlspecialchars($user_profile_pic); ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <i class="fa-solid fa-user text-lg"></i>
                        <?php endif; ?>
                    </button>

                    <!-- Profile Dropdown Menu (Hidden by default) -->
                    <div id="profile-dropdown-menu" class="profile-dropdown absolute right-0 top-12 mt-2 w-72 rounded-lg shadow-xl z-50 p-3 hidden" role="menu" aria-orientation="vertical" aria-labelledby="profile-menu-button">
                        
                        <!-- Top Section: User Profile Link -->
                        <a href="user_profile.php" class="dropdown-item profile-link">
                            <?php if (!empty($user_profile_pic) && file_exists($user_profile_pic)): ?>
                                <img src="<?php echo htmlspecialchars($user_profile_pic); ?>" alt="Profile" class="w-12 h-12 rounded-full object-cover mr-3 border-2 border-red-500">
                            <?php else: ?>
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-white font-bold text-xl mr-3 border-2 border-red-500">
                                    <?php echo $user_initial; ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="text-sm font-semibold text-white"><?php echo $user_full_name; ?></p>
                                <p class="text-xs text-gray-400">View your profile</p>
                            </div>
                        </a>
                        
                        <!-- Section 1: Contextual Links (Inspired by FB dropdown) -->
                        <a href="user_settings.php" class="dropdown-item">
                            <span class="p-2 rounded-full bg-gray-700 text-gray-300 mr-3"><i class="fa-solid fa-gear"></i></span>
                            Settings & privacy
                        </a>
                        <a href="user_help.php" class="dropdown-item">
                            <span class="p-2 rounded-full bg-gray-700 text-gray-300 mr-3"><i class="fa-solid fa-circle-question"></i></span>
                            Help & support
                        </a>
                        <a href="user_feedback.php" class="dropdown-item">
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
                <a href="user_dashboard.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('user_dashboard.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-house-user mr-2"></i> Dashboard
                </a>
                <a href="user_alerts.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('user_alerts.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-bell mr-2"></i> Alerts
                </a>
                <a href="user_guides.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('user_guides.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-book-open mr-2"></i> Disaster Guides
                </a>
                <a href="user_hotlines.php" class="block rounded-md px-3 py-2 text-base font-medium 
                    <?php echo is_active('user_hotlines.php', $current_page); ?> hover:bg-gray-800">
                    <i class="fa-solid fa-phone-alt mr-2"></i> Emergency Hotlines
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
            const notificationMenuButton = document.getElementById('notification-menu-button');
            const notificationDropdownMenu = document.getElementById('notification-dropdown-menu');
            const notificationBadge = document.getElementById('notification-badge');
            const notificationList = document.getElementById('notification-list');
            const markAllReadBtn = document.getElementById('mark-all-read-btn');

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
                    // Close notification dropdown if open
                    if (notificationDropdownMenu && !notificationDropdownMenu.classList.contains('hidden')) {
                        notificationDropdownMenu.classList.add('hidden');
                    }
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
            
            // --- 3. Notification Dropdown Toggle ---
            if (notificationMenuButton && notificationDropdownMenu) {
                // Load notifications function
                function loadNotifications() {
                    fetch('ajax/get_notifications.php?limit=5')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update badge
                                if (data.unread_count > 0) {
                                    notificationBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                                    notificationBadge.classList.remove('hidden');
                                } else {
                                    notificationBadge.classList.add('hidden');
                                }
                                
                                // Update notification list
                                if (data.notifications.length === 0) {
                                    notificationList.innerHTML = `
                                        <div class="p-8 text-center text-gray-400">
                                            <i class="fa-solid fa-bell-slash text-3xl mb-2"></i>
                                            <p>No notifications yet</p>
                                        </div>
                                    `;
                                } else {
                                    notificationList.innerHTML = data.notifications.map(notif => `
                                        <div class="notification-item p-4 hover:bg-gray-700 cursor-pointer border-l-4 ${notif.is_read == 0 ? 'border-red-500 bg-gray-800/50' : 'border-transparent'} transition" data-id="${notif.notification_id}">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 mr-3">
                                                    <i class="fa-solid ${getNotificationIcon(notif.type)} text-${getNotificationColor(notif.type)}-500 text-xl"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <p class="text-white font-semibold text-sm">${notif.title}</p>
                                                    <p class="text-gray-400 text-xs mt-1">${notif.message.substring(0, 80)}${notif.message.length > 80 ? '...' : ''}</p>
                                                    <p class="text-gray-500 text-xs mt-1">${timeAgo(notif.created_at)}</p>
                                                </div>
                                                ${notif.is_read == 0 ? '<span class="flex-shrink-0 ml-2 w-2 h-2 bg-red-500 rounded-full"></span>' : ''}
                                            </div>
                                        </div>
                                    `).join('');
                                    
                                    // Add click handlers to mark as read
                                    document.querySelectorAll('.notification-item').forEach(item => {
                                        item.addEventListener('click', function() {
                                            const notifId = this.dataset.id;
                                            markNotificationRead(notifId);
                                        });
                                    });
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error loading notifications:', error);
                            notificationList.innerHTML = `
                                <div class="p-8 text-center text-red-400">
                                    <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
                                    <p>Error loading notifications</p>
                                </div>
                            `;
                        });
                }
                
                // Helper functions
                function getNotificationIcon(type) {
                    const icons = {
                        'alert': 'fa-triangle-exclamation',
                        'weather': 'fa-cloud-sun-rain',
                        'safety': 'fa-shield-halved',
                        'system': 'fa-gear'
                    };
                    return icons[type] || 'fa-bell';
                }
                
                function getNotificationColor(type) {
                    const colors = {
                        'alert': 'red',
                        'weather': 'blue',
                        'safety': 'green',
                        'system': 'gray'
                    };
                    return colors[type] || 'gray';
                }
                
                function timeAgo(datetime) {
                    const now = new Date();
                    const past = new Date(datetime);
                    const diffMs = now - past;
                    const diffMins = Math.floor(diffMs / 60000);
                    
                    if (diffMins < 1) return 'Just now';
                    if (diffMins < 60) return `${diffMins} min ago`;
                    const diffHours = Math.floor(diffMins / 60);
                    if (diffHours < 24) return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
                    const diffDays = Math.floor(diffHours / 24);
                    return `${diffDays} day${diffDays > 1 ? 's' : ''} ago`;
                }
                
                function markNotificationRead(notifId) {
                    const formData = new FormData();
                    formData.append('notification_id', notifId);
                    
                    fetch('ajax/mark_notification_read.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadNotifications(); // Reload notifications
                        }
                    })
                    .catch(error => console.error('Error marking notification read:', error));
                }
                
                // Toggle notification dropdown
                notificationMenuButton.addEventListener('click', () => {
                    const isExpanded = notificationDropdownMenu.classList.toggle('hidden');
                    notificationMenuButton.setAttribute('aria-expanded', !isExpanded);
                    
                    // Close profile dropdown if open
                    if (profileDropdownMenu && !profileDropdownMenu.classList.contains('hidden')) {
                        profileDropdownMenu.classList.add('hidden');
                    }
                    
                    // Load notifications when opened
                    if (!isExpanded) {
                        loadNotifications();
                    }
                });
                
                // Mark all as read
                if (markAllReadBtn) {
                    markAllReadBtn.addEventListener('click', () => {
                        const formData = new FormData();
                        formData.append('mark_all', 'true');
                        
                        fetch('ajax/mark_notification_read.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                loadNotifications();
                            }
                        })
                        .catch(error => console.error('Error marking all read:', error));
                    });
                }
                
                // Close dropdown when clicking outside
                document.addEventListener('click', (event) => {
                    if (
                        !notificationDropdownMenu.contains(event.target) && 
                        !notificationMenuButton.contains(event.target) && 
                        !notificationDropdownMenu.classList.contains('hidden')
                    ) {
                        notificationDropdownMenu.classList.add('hidden');
                        notificationMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Load notifications on page load to update badge
                loadNotifications();
                
                // Auto-refresh notifications every 30 seconds
                setInterval(loadNotifications, 30000);
            }
        });
    </script>
    
    <!-- You can use this div in your main page body to ensure content starts below the fixed header: -->
    <!-- <div class="pt-24">...page content...</div> -->

</body>
</html>