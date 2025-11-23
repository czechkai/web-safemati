<?php
    $admin_name = "Jane Admin"; $profile_image_url = "https://placehold.co/150x150/d1d5db/000000?text=JD"; $active_link = 'Settings';
    $nav_links = ['Dashboard' => ['icon' => 'fa-gauge-high', 'url' => 'admin_dashboard.php'], 'Users' => ['icon' => 'fa-users', 'url' => 'admin_users.php'], 'Alerts' => ['icon' => 'fa-bell', 'url' => 'admin_alerts.php'], 'Reports' => ['icon' => 'fa-chart-line', 'url' => 'admin_reports.php'], 'Hotlines Management' => ['icon' => 'fa-phone-volume', 'url' => 'admin_hotlines.php'], 'Guides Management' => ['icon' => 'fa-book-open', 'url' => 'admin_guides.php'], 'System Logs' => ['icon' => 'fa-list-ol', 'url' => 'admin_logs.php'], 'Settings' => ['icon' => 'fa-gear', 'url' => 'admin_settings.php']];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Settings - SafeMati Admin Panel</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"><style>body{margin:0;padding:0;overflow-x:hidden}#sidebar{transform:translateX(-100%);transition:transform .3s ease-in-out;height:calc(100vh - 64px);top:64px}#sidebar-toggle:checked ~ #main-wrapper #sidebar{transform:translateX(0)}@media (min-width:768px){#sidebar{transform:translateX(0);width:280px}.content-area{margin-left:262px;min-height:calc(100vh - 64px)}}@media (max-width:767px){.content-area{margin-left:0}}</style></head><body class="bg-gray-50 font-sans"><input type="checkbox" id="sidebar-toggle" class="hidden"><header class="bg-gray-900 fixed top-0 left-0 right-0 z-30 shadow-lg border-b border-gray-900" style="height:64px"><div class="flex items-center justify-between h-16 px-4 md:px-6 max-w-full mx-auto"><div class="flex items-center space-x-4"><label for="sidebar-toggle" class="md:hidden p-2 cursor-pointer text-white hover:bg-red-600 rounded-lg transition"><i class="fa-solid fa-bars text-xl"></i></label><img src="assets/safemati-logo.png" alt="SafeMati Logo" class="h-14 w-auto object-contain"></div><div class="flex-1 max-w-lg mx-4 hidden sm:block"><div class="relative"><i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i><input type="text" placeholder="Search for users, alerts, or reports..." class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 transition"></div></div><div class="flex items-center space-x-4"><div class="relative hidden sm:block"><button class="p-2 text-white hover:text-red-100 hover:bg-red-600 rounded-full transition"><i class="fa-regular fa-bell text-xl"></i><span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-300 border border-red-700"></span></button></div><div class="relative group"><button class="flex items-center space-x-2 p-1.5 rounded-full hover:bg-red-600 transition focus:outline-none"><img src="<?php echo $profile_image_url;?>" alt="Admin Profile" class="h-8 w-8 rounded-full border border-red-300 object-cover bg-gray-200"><span class="text-sm font-medium text-white hidden md:inline"><?php echo htmlspecialchars($admin_name);?></span><i class="fa-solid fa-chevron-down text-xs text-red-300 hidden md:inline"></i></button><div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-30"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-user-circle mr-2 w-4"></i> Profile</a><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-gear mr-2 w-4"></i> Settings</a><div class="border-t border-gray-100 my-1"></div><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Logout</a></div></div></div></div></header><div id="main-wrapper" class="flex" style="margin-top:64px"><aside id="sidebar" class="fixed left-0 bg-white w-72 border-r border-gray-200 z-20 md:static md:translate-x-0 overflow-y-auto shadow-xl md:shadow-none"><nav class="space-y-2 px-4 py-4"><?php foreach($nav_links as $name=>$link):?><?php $isActive=($name===$active_link);$linkClasses="flex items-center space-x-3 p-3 text-sm font-medium rounded-lg transition duration-150";$linkClasses.=" text-gray-700 hover:bg-red-50 hover:text-red-700";if($isActive){$linkClasses="flex items-center space-x-3 p-3 text-sm font-medium rounded-lg text-red-700 bg-red-50 transition duration-150";}?><a href="<?php echo htmlspecialchars($link['url']);?>" class="<?php echo $linkClasses;?>"><i class="fa-solid <?php echo htmlspecialchars($link['icon']);?> w-5 text-center"></i><span><?php echo htmlspecialchars($name);?></span></a><?php endforeach;?></nav><div class="mt-auto p-4 border-t border-gray-200 hidden md:block"><span class="text-xs text-gray-400">SafeMati Disaster Response</span></div></aside>

<!-- Main Content Area -->
<div class="flex-1 content-area p-4 md:p-6 w-full bg-gray-50 max-w-7xl">
    
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="text-3xl font-bold text-gray-800">System Settings</h1>
        <p class="text-gray-600 mt-1">Configure system preferences and options</p>
    </div>

    <!-- Settings Tabs -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Settings Tabs">
                <button class="py-4 px-1 border-b-2 border-red-700 text-red-700 font-medium text-sm">
                    General
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                    Notifications
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                    Security
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                    Email
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                    Backup
                </button>
            </nav>
        </div>
    </div>

    <!-- General Settings -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">General Settings</h2>
        
        <form class="space-y-6">
            <!-- System Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">System Name</label>
                <input type="text" value="SafeMati Disaster Response System" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                <p class="text-xs text-gray-500 mt-1">This name appears throughout the application</p>
            </div>

            <!-- System Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">System Description</label>
                <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">A comprehensive disaster preparedness and emergency response platform for the Philippines.</textarea>
            </div>

            <!-- Timezone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>Asia/Manila (GMT+8)</option>
                        <option>Asia/Tokyo (GMT+9)</option>
                        <option>UTC</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>MM/DD/YYYY</option>
                        <option>DD/MM/YYYY</option>
                        <option>YYYY-MM-DD</option>
                    </select>
                </div>
            </div>

            <!-- Language -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Language</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>English</option>
                        <option>Filipino</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Items Per Page</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">Maintenance Mode</p>
                    <p class="text-xs text-gray-500">Enable maintenance mode to prevent user access</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                </label>
            </div>

            <!-- Save Button -->
            <div class="pt-4 border-t border-gray-200">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-save mr-2"></i> Save General Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Notification Settings -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Notification Settings</h2>
        
        <form class="space-y-4">
            <!-- Email Notifications -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">Email Notifications</p>
                    <p class="text-xs text-gray-500">Send email notifications for alerts and reports</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                </label>
            </div>

            <!-- SMS Notifications -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">SMS Notifications</p>
                    <p class="text-xs text-gray-500">Send SMS alerts for critical emergencies</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                </label>
            </div>

            <!-- Push Notifications -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">Push Notifications</p>
                    <p class="text-xs text-gray-500">Send mobile push notifications</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                </label>
            </div>

            <!-- Admin Notifications -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">Admin Notifications</p>
                    <p class="text-xs text-gray-500">Receive notifications for system events</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                </label>
            </div>

            <!-- Save Button -->
            <div class="pt-4 border-t border-gray-200">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-save mr-2"></i> Save Notification Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Security Settings -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Security Settings</h2>
        
        <form class="space-y-6">
            <!-- Password Requirements -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Password Length</label>
                <input type="number" value="8" min="6" max="20" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
            </div>

            <!-- Session Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                    <input type="number" value="30" min="5" max="120" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Login Attempts</label>
                    <input type="number" value="5" min="3" max="10" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                </div>
            </div>

            <!-- Security Features -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">Two-Factor Authentication</p>
                    <p class="text-xs text-gray-500">Require 2FA for admin accounts</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">IP Whitelist</p>
                    <p class="text-xs text-gray-500">Restrict admin access to specific IP addresses</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                </label>
            </div>

            <!-- Save Button -->
            <div class="pt-4 border-t border-gray-200">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-save mr-2"></i> Save Security Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Database & Backup Settings -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Database & Backup</h2>
        
        <div class="space-y-6">
            <!-- Database Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-1">Database Status</p>
                    <p class="text-lg font-bold text-green-600">Connected</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-1">Database Size</p>
                    <p class="text-lg font-bold text-gray-800">245 MB</p>
                </div>
            </div>

            <!-- Last Backup -->
            <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Last Backup</p>
                        <p class="text-xs text-gray-600 mt-1">Nov 24, 2025 9:45 AM</p>
                    </div>
                    <button class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-download mr-2"></i> Backup Now
                    </button>
                </div>
            </div>

            <!-- Automatic Backup -->
            <form class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Automatic Daily Backup</p>
                        <p class="text-xs text-gray-500">Schedule automatic database backups</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-700"></div>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Backup Time</label>
                    <input type="time" value="02:00" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition">
                        <i class="fa-solid fa-save mr-2"></i> Save Backup Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-red-200 mb-6">
        <h2 class="text-xl font-bold text-red-700 mb-4">Danger Zone</h2>
        <p class="text-sm text-gray-600 mb-4">These actions are irreversible. Please be careful.</p>
        
        <div class="space-y-3">
            <button class="w-full md:w-auto bg-white hover:bg-red-50 text-red-700 border border-red-300 px-6 py-2 rounded-lg font-medium transition">
                <i class="fa-solid fa-trash mr-2"></i> Clear All Logs
            </button>
            <button class="w-full md:w-auto bg-white hover:bg-red-50 text-red-700 border border-red-300 px-6 py-2 rounded-lg font-medium transition ml-0 md:ml-3">
                <i class="fa-solid fa-rotate-left mr-2"></i> Reset All Settings
            </button>
        </div>
    </div>

</div>
<script>document.addEventListener('DOMContentLoaded',()=>{const sidebarToggle=document.getElementById('sidebar-toggle');const navLinks=document.querySelectorAll('#sidebar a');navLinks.forEach(link=>{link.addEventListener('click',()=>{if(window.innerWidth<768){sidebarToggle.checked=false;}});});document.addEventListener('click',(e)=>{if(window.innerWidth<768){const sidebar=document.getElementById('sidebar');const toggle=document.querySelector('label[for="sidebar-toggle"]');if(sidebarToggle.checked&&!sidebar.contains(e.target)&&!toggle.contains(e.target)){sidebarToggle.checked=false;}}});});</script></body></html>
