<?php
    $admin_name = "Jane Admin";
    $profile_image_url = "https://placehold.co/150x150/d1d5db/000000?text=JD";
    $active_link = 'Alerts';
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
    <title>Alerts - SafeMati Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { margin: 0; padding: 0; overflow-x: hidden; }
        #sidebar { transform: translateX(-100%); transition: transform 0.3s ease-in-out; height: calc(100vh - 64px); top: 64px; }
        #sidebar-toggle:checked ~ #main-wrapper #sidebar { transform: translateX(0); }
        @media (min-width: 768px) { #sidebar { transform: translateX(0); width: 280px; } .content-area { margin-left: 262px; min-height: calc(100vh - 64px); } }
        @media (max-width: 767px) { .content-area { margin-left: 0; } }
    </style>
</head>
<body class="bg-gray-50 font-sans">
<input type="checkbox" id="sidebar-toggle" class="hidden">
<header class="bg-gray-900 fixed top-0 left-0 right-0 z-30 shadow-lg border-b border-gray-900" style="height: 64px;">
    <div class="flex items-center justify-between h-16 px-4 md:px-6 max-w-full mx-auto">
        <div class="flex items-center space-x-4">
            <label for="sidebar-toggle" class="md:hidden p-2 cursor-pointer text-white hover:bg-red-600 rounded-lg transition"><i class="fa-solid fa-bars text-xl"></i></label>
            <img src="assets/safemati-logo.png" alt="SafeMati Logo" class="h-14 w-auto object-contain">
        </div>
        <div class="flex-1 max-w-lg mx-4 hidden sm:block"><div class="relative"><i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i><input type="text" placeholder="Search for users, alerts, or reports..." class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 transition"></div></div>
        <div class="flex items-center space-x-4"><div class="relative hidden sm:block"><button class="p-2 text-white hover:text-red-100 hover:bg-red-600 rounded-full transition"><i class="fa-regular fa-bell text-xl"></i><span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-300 border border-red-700"></span></button></div>
            <div class="relative group"><button class="flex items-center space-x-2 p-1.5 rounded-full hover:bg-red-600 transition focus:outline-none"><img src="<?php echo $profile_image_url; ?>" alt="Admin Profile" class="h-8 w-8 rounded-full border border-red-300 object-cover bg-gray-200"><span class="text-sm font-medium text-white hidden md:inline"><?php echo htmlspecialchars($admin_name); ?></span><i class="fa-solid fa-chevron-down text-xs text-red-300 hidden md:inline"></i></button><div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-30"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-user-circle mr-2 w-4"></i> Profile</a><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-gear mr-2 w-4"></i> Settings</a><div class="border-t border-gray-100 my-1"></div><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Logout</a></div></div>
        </div>
    </div>
</header>
<div id="main-wrapper" class="flex" style="margin-top: 64px;">
    <aside id="sidebar" class="fixed left-0 bg-white w-72 border-r border-gray-200 z-20 md:static md:translate-x-0 overflow-y-auto shadow-xl md:shadow-none"><nav class="space-y-2 px-4 py-4"><?php foreach ($nav_links as $name => $link): ?><?php $isActive = ($name === $active_link); $linkClasses = "flex items-center space-x-3 p-3 text-sm font-medium rounded-lg transition duration-150"; $linkClasses .= " text-gray-700 hover:bg-red-50 hover:text-red-700"; if ($isActive) { $linkClasses = "flex items-center space-x-3 p-3 text-sm font-medium rounded-lg text-red-700 bg-red-50 transition duration-150"; } ?><a href="<?php echo htmlspecialchars($link['url']); ?>" class="<?php echo $linkClasses; ?>"><i class="fa-solid <?php echo htmlspecialchars($link['icon']); ?> w-5 text-center"></i><span><?php echo htmlspecialchars($name); ?></span></a><?php endforeach; ?></nav><div class="mt-auto p-4 border-t border-gray-200 hidden md:block"><span class="text-xs text-gray-400">SafeMati Disaster Response</span></div></aside>

<!-- Main Content Area -->
<div class="flex-1 content-area p-4 md:p-6 w-full bg-gray-50 max-w-7xl">
    
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="text-3xl font-bold text-gray-800">Alerts Management</h1>
        <p class="text-gray-600 mt-1">Create and manage disaster alerts for users</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Active Alerts</p>
            <h3 class="text-3xl font-bold text-red-700">8</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Critical</p>
            <h3 class="text-3xl font-bold text-red-600">3</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">This Week</p>
            <h3 class="text-3xl font-bold text-gray-800">15</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Users Reached</p>
            <h3 class="text-3xl font-bold text-green-600">1,156</h3>
        </div>
    </div>

    <!-- Create Alert Form -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Create New Alert</h2>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alert Type</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>Select type...</option>
                        <option>Flood Warning</option>
                        <option>Typhoon Alert</option>
                        <option>Earthquake Advisory</option>
                        <option>Fire Alert</option>
                        <option>Landslide Warning</option>
                        <option>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Severity Level</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>Select severity...</option>
                        <option>Critical</option>
                        <option>High</option>
                        <option>Moderate</option>
                        <option>Low</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" placeholder="e.g., Metro Manila" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Effective Until</label>
                    <input type="datetime-local" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alert Title</label>
                <input type="text" placeholder="Brief alert title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alert Message</label>
                <textarea rows="4" placeholder="Detailed alert message and instructions..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400"></textarea>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Send Alert
                </button>
                <button type="button" class="bg-white hover:bg-gray-50 text-gray-800 border border-gray-300 px-6 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-save mr-2"></i> Save as Draft
                </button>
            </div>
        </form>
    </div>

    <!-- Alerts Table Section -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
        
        <!-- Table Header with Search and Filter -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
            <h2 class="text-xl font-bold text-gray-800">All Alerts</h2>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                <!-- Search -->
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Search alerts..." 
                           class="pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 w-full sm:w-64">
                </div>
                
                <!-- Filter -->
                <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                    <option>All Severities</option>
                    <option>Critical</option>
                    <option>High</option>
                    <option>Moderate</option>
                    <option>Low</option>
                </select>
                
                <!-- Status Filter -->
                <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Expired</option>
                    <option>Resolved</option>
                </select>
            </div>
        </div>

        <!-- Alerts Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Alert Type</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Title</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Location</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Severity</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Date Issued</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <!-- Alert Row 1 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-water text-red-700"></i>
                                <span class="text-gray-800 font-medium">Flood Warning</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-800">Heavy rainfall causing flooding</td>
                        <td class="py-3 px-4 text-gray-600">Metro Manila</td>
                        <td class="py-3 px-4">
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Critical</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 10:30 AM</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Resolve">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Alert Row 2 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-wind text-red-700"></i>
                                <span class="text-gray-800 font-medium">Typhoon Alert</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-800">Typhoon approaching eastern region</td>
                        <td class="py-3 px-4 text-gray-600">Visayas Region</td>
                        <td class="py-3 px-4">
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-medium">High</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 23, 2025 2:15 PM</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Resolve">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Alert Row 3 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-house-crack text-red-700"></i>
                                <span class="text-gray-800 font-medium">Earthquake</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-800">Magnitude 5.2 earthquake recorded</td>
                        <td class="py-3 px-4 text-gray-600">Mindanao</td>
                        <td class="py-3 px-4">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Moderate</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">Resolved</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 22, 2025 8:45 AM</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Resolve">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Alert Row 4 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-fire text-red-700"></i>
                                <span class="text-gray-800 font-medium">Fire Alert</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-800">Residential area fire reported</td>
                        <td class="py-3 px-4 text-gray-600">Quezon City</td>
                        <td class="py-3 px-4">
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Critical</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">Resolved</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 21, 2025 5:20 PM</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Resolve">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Alert Row 5 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-mountain text-red-700"></i>
                                <span class="text-gray-800 font-medium">Landslide</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-800">Landslide risk due to heavy rain</td>
                        <td class="py-3 px-4 text-gray-600">Baguio City</td>
                        <td class="py-3 px-4">
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-medium">High</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 20, 2025 11:00 AM</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Resolve">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">Showing 1 to 5 of 45 alerts</p>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">Previous</button>
                <button class="px-3 py-1 bg-red-700 text-white rounded text-sm">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">3</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">Next</button>
            </div>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const navLinks = document.querySelectorAll('#sidebar a');
        navLinks.forEach(link => { link.addEventListener('click', () => { if (window.innerWidth < 768) { sidebarToggle.checked = false; } }); });
        document.addEventListener('click', (e) => { if (window.innerWidth < 768) { const sidebar = document.getElementById('sidebar'); const toggle = document.querySelector('label[for="sidebar-toggle"]'); if (sidebarToggle.checked && !sidebar.contains(e.target) && !toggle.contains(e.target)) { sidebarToggle.checked = false; } } });
    });
</script>
</body>
</html>
