<?php
    $admin_name = "Jane Admin"; $profile_image_url = "https://placehold.co/150x150/d1d5db/000000?text=JD"; $active_link = 'System Logs';
    $nav_links = ['Dashboard' => ['icon' => 'fa-gauge-high', 'url' => 'admin_dashboard.php'], 'Users' => ['icon' => 'fa-users', 'url' => 'admin_users.php'], 'Alerts' => ['icon' => 'fa-bell', 'url' => 'admin_alerts.php'], 'Reports' => ['icon' => 'fa-chart-line', 'url' => 'admin_reports.php'], 'Hotlines Management' => ['icon' => 'fa-phone-volume', 'url' => 'admin_hotlines.php'], 'Guides Management' => ['icon' => 'fa-book-open', 'url' => 'admin_guides.php'], 'System Logs' => ['icon' => 'fa-list-ol', 'url' => 'admin_logs.php'], 'Settings' => ['icon' => 'fa-gear', 'url' => 'admin_settings.php']];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>System Logs - SafeMati Admin Panel</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"><style>body{margin:0;padding:0;overflow-x:hidden}#sidebar{transform:translateX(-100%);transition:transform .3s ease-in-out;height:calc(100vh - 64px);top:64px}#sidebar-toggle:checked ~ #main-wrapper #sidebar{transform:translateX(0)}@media (min-width:768px){#sidebar{transform:translateX(0);width:280px}.content-area{margin-left:262px;min-height:calc(100vh - 64px)}}@media (max-width:767px){.content-area{margin-left:0}}</style></head><body class="bg-gray-50 font-sans"><input type="checkbox" id="sidebar-toggle" class="hidden"><header class="bg-gray-900 fixed top-0 left-0 right-0 z-30 shadow-lg border-b border-gray-900" style="height:64px"><div class="flex items-center justify-between h-16 px-4 md:px-6 max-w-full mx-auto"><div class="flex items-center space-x-4"><label for="sidebar-toggle" class="md:hidden p-2 cursor-pointer text-white hover:bg-red-600 rounded-lg transition"><i class="fa-solid fa-bars text-xl"></i></label><img src="assets/safemati-logo.png" alt="SafeMati Logo" class="h-14 w-auto object-contain"></div><div class="flex-1 max-w-lg mx-4 hidden sm:block"><div class="relative"><i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i><input type="text" placeholder="Search for users, alerts, or reports..." class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 transition"></div></div><div class="flex items-center space-x-4"><div class="relative hidden sm:block"><button class="p-2 text-white hover:text-red-100 hover:bg-red-600 rounded-full transition"><i class="fa-regular fa-bell text-xl"></i><span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-300 border border-red-700"></span></button></div><div class="relative group"><button class="flex items-center space-x-2 p-1.5 rounded-full hover:bg-red-600 transition focus:outline-none"><img src="<?php echo $profile_image_url;?>" alt="Admin Profile" class="h-8 w-8 rounded-full border border-red-300 object-cover bg-gray-200"><span class="text-sm font-medium text-white hidden md:inline"><?php echo htmlspecialchars($admin_name);?></span><i class="fa-solid fa-chevron-down text-xs text-red-300 hidden md:inline"></i></button><div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-30"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-user-circle mr-2 w-4"></i> Profile</a><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-gear mr-2 w-4"></i> Settings</a><div class="border-t border-gray-100 my-1"></div><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Logout</a></div></div></div></div></header><div id="main-wrapper" class="flex" style="margin-top:64px"><aside id="sidebar" class="fixed left-0 bg-white w-72 border-r border-gray-200 z-20 md:static md:translate-x-0 overflow-y-auto shadow-xl md:shadow-none"><nav class="space-y-2 px-4 py-4"><?php foreach($nav_links as $name=>$link):?><?php $isActive=($name===$active_link);$linkClasses="flex items-center space-x-3 p-3 text-sm font-medium rounded-lg transition duration-150";$linkClasses.=" text-gray-700 hover:bg-red-50 hover:text-red-700";if($isActive){$linkClasses="flex items-center space-x-3 p-3 text-sm font-medium rounded-lg text-red-700 bg-red-50 transition duration-150";}?><a href="<?php echo htmlspecialchars($link['url']);?>" class="<?php echo $linkClasses;?>"><i class="fa-solid <?php echo htmlspecialchars($link['icon']);?> w-5 text-center"></i><span><?php echo htmlspecialchars($name);?></span></a><?php endforeach;?></nav><div class="mt-auto p-4 border-t border-gray-200 hidden md:block"><span class="text-xs text-gray-400">SafeMati Disaster Response</span></div></aside>

<!-- Main Content Area -->
<div class="flex-1 content-area p-4 md:p-6 w-full bg-gray-50 max-w-7xl">
    
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="text-3xl font-bold text-gray-800">System Logs</h1>
        <p class="text-gray-600 mt-1">Monitor system activities and events</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Total Logs</p>
            <h3 class="text-3xl font-bold text-gray-800">5,432</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Today</p>
            <h3 class="text-3xl font-bold text-red-700">156</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Errors</p>
            <h3 class="text-3xl font-bold text-orange-600">8</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Warnings</p>
            <h3 class="text-3xl font-bold text-yellow-600">23</h3>
        </div>
    </div>

    <!-- System Logs Section -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
        
        <!-- Table Header with Search and Filter -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
            <h2 class="text-xl font-bold text-gray-800">Activity Logs</h2>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                <!-- Search -->
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Search logs..." 
                           class="pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 w-full sm:w-64">
                </div>
                
                <!-- Type Filter -->
                <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                    <option>All Types</option>
                    <option>Info</option>
                    <option>Warning</option>
                    <option>Error</option>
                    <option>Success</option>
                </select>
                
                <!-- Category Filter -->
                <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                    <option>All Categories</option>
                    <option>User Activity</option>
                    <option>System</option>
                    <option>Security</option>
                    <option>Database</option>
                </select>

                <!-- Date Filter -->
                <input type="date" class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">

                <!-- Export -->
                <button class="bg-white hover:bg-gray-50 text-gray-800 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-download mr-2"></i> Export
                </button>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Timestamp</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Type</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Category</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">User/Source</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Action</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Details</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">IP Address</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <!-- Log Row 1 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 10:45 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Success</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">User Activity</td>
                        <td class="py-3 px-4 text-gray-800">Juan Dela Cruz</td>
                        <td class="py-3 px-4 text-gray-800">User Login</td>
                        <td class="py-3 px-4 text-gray-600">Successful authentication</td>
                        <td class="py-3 px-4 text-gray-600">192.168.1.45</td>
                    </tr>

                    <!-- Log Row 2 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 10:30 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Info</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">System</td>
                        <td class="py-3 px-4 text-gray-800">System Admin</td>
                        <td class="py-3 px-4 text-gray-800">Alert Created</td>
                        <td class="py-3 px-4 text-gray-600">Flood warning issued for Metro Manila</td>
                        <td class="py-3 px-4 text-gray-600">192.168.1.1</td>
                    </tr>

                    <!-- Log Row 3 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 10:15 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Warning</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Security</td>
                        <td class="py-3 px-4 text-gray-800">Unknown</td>
                        <td class="py-3 px-4 text-gray-800">Failed Login Attempt</td>
                        <td class="py-3 px-4 text-gray-600">Multiple failed login attempts detected</td>
                        <td class="py-3 px-4 text-gray-600">203.124.45.78</td>
                    </tr>

                    <!-- Log Row 4 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 9:45 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Success</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Database</td>
                        <td class="py-3 px-4 text-gray-800">System</td>
                        <td class="py-3 px-4 text-gray-800">Database Backup</td>
                        <td class="py-3 px-4 text-gray-600">Automated backup completed successfully</td>
                        <td class="py-3 px-4 text-gray-600">Local</td>
                    </tr>

                    <!-- Log Row 5 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 9:30 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Info</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">User Activity</td>
                        <td class="py-3 px-4 text-gray-800">Maria Santos</td>
                        <td class="py-3 px-4 text-gray-800">Report Submitted</td>
                        <td class="py-3 px-4 text-gray-600">Emergency report #RPT-002 created</td>
                        <td class="py-3 px-4 text-gray-600">192.168.1.52</td>
                    </tr>

                    <!-- Log Row 6 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 9:00 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Error</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">System</td>
                        <td class="py-3 px-4 text-gray-800">System</td>
                        <td class="py-3 px-4 text-gray-800">Email Service</td>
                        <td class="py-3 px-4 text-gray-600">Failed to send notification emails</td>
                        <td class="py-3 px-4 text-gray-600">Local</td>
                    </tr>

                    <!-- Log Row 7 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 8:30 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Success</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">User Activity</td>
                        <td class="py-3 px-4 text-gray-800">Pedro Reyes</td>
                        <td class="py-3 px-4 text-gray-800">Profile Updated</td>
                        <td class="py-3 px-4 text-gray-600">User profile information updated</td>
                        <td class="py-3 px-4 text-gray-600">192.168.1.67</td>
                    </tr>

                    <!-- Log Row 8 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 8:00 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Info</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">System</td>
                        <td class="py-3 px-4 text-gray-800">System Admin</td>
                        <td class="py-3 px-4 text-gray-800">Guide Published</td>
                        <td class="py-3 px-4 text-gray-600">Earthquake Safety Guide updated</td>
                        <td class="py-3 px-4 text-gray-600">192.168.1.1</td>
                    </tr>

                    <!-- Log Row 9 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 7:45 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Warning</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">System</td>
                        <td class="py-3 px-4 text-gray-800">System</td>
                        <td class="py-3 px-4 text-gray-800">High Server Load</td>
                        <td class="py-3 px-4 text-gray-600">Server CPU usage reached 85%</td>
                        <td class="py-3 px-4 text-gray-600">Local</td>
                    </tr>

                    <!-- Log Row 10 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-600">Nov 24, 2025 7:00 AM</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Success</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">User Activity</td>
                        <td class="py-3 px-4 text-gray-800">Ana Garcia</td>
                        <td class="py-3 px-4 text-gray-800">User Registration</td>
                        <td class="py-3 px-4 text-gray-600">New user account created</td>
                        <td class="py-3 px-4 text-gray-600">192.168.1.88</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">Showing 1 to 10 of 5,432 logs</p>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">Previous</button>
                <button class="px-3 py-1 bg-red-700 text-white rounded text-sm">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">3</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">...</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">544</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-50">Next</button>
            </div>
        </div>

    </div>

    <!-- Quick Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        
        <!-- Recent Errors -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Errors</h2>
            <div class="space-y-3">
                <div class="p-3 bg-red-50 border border-red-100 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <i class="fa-solid fa-circle-exclamation text-red-600 mt-1"></i>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800 font-medium">Email Service Failure</p>
                            <p class="text-xs text-gray-600 mt-1">Failed to send notification emails</p>
                            <p class="text-xs text-gray-500 mt-1">Nov 24, 2025 9:00 AM</p>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-red-50 border border-red-100 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <i class="fa-solid fa-circle-exclamation text-red-600 mt-1"></i>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800 font-medium">Database Connection Error</p>
                            <p class="text-xs text-gray-600 mt-1">Temporary connection timeout</p>
                            <p class="text-xs text-gray-500 mt-1">Nov 23, 2025 11:30 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">System Status</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Web Server</span>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs font-medium">Online</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Database</span>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs font-medium">Connected</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Email Service</span>
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-medium">Error</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">API Services</span>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs font-medium">Operational</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Storage</span>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs font-medium">45% Used</span>
                </div>
            </div>
        </div>

    </div>

</div>
<script>document.addEventListener('DOMContentLoaded',()=>{const sidebarToggle=document.getElementById('sidebar-toggle');const navLinks=document.querySelectorAll('#sidebar a');navLinks.forEach(link=>{link.addEventListener('click',()=>{if(window.innerWidth<768){sidebarToggle.checked=false;}});});document.addEventListener('click',(e)=>{if(window.innerWidth<768){const sidebar=document.getElementById('sidebar');const toggle=document.querySelector('label[for="sidebar-toggle"]');if(sidebarToggle.checked&&!sidebar.contains(e.target)&&!toggle.contains(e.target)){sidebarToggle.checked=false;}}});});</script></body></html>
