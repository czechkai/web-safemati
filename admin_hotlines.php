<?php
    $admin_name = "Jane Admin"; $profile_image_url = "https://placehold.co/150x150/d1d5db/000000?text=JD"; $active_link = 'Hotlines Management';
    $nav_links = ['Dashboard' => ['icon' => 'fa-gauge-high', 'url' => 'admin_dashboard.php'], 'Users' => ['icon' => 'fa-users', 'url' => 'admin_users.php'], 'Alerts' => ['icon' => 'fa-bell', 'url' => 'admin_alerts.php'], 'Reports' => ['icon' => 'fa-chart-line', 'url' => 'admin_reports.php'], 'Hotlines Management' => ['icon' => 'fa-phone-volume', 'url' => 'admin_hotlines.php'], 'Guides Management' => ['icon' => 'fa-book-open', 'url' => 'admin_guides.php'], 'System Logs' => ['icon' => 'fa-list-ol', 'url' => 'admin_logs.php'], 'Settings' => ['icon' => 'fa-gear', 'url' => 'admin_settings.php']];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Hotlines - SafeMati Admin Panel</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"><style>body{margin:0;padding:0;overflow-x:hidden}#sidebar{transform:translateX(-100%);transition:transform .3s ease-in-out;height:calc(100vh - 64px);top:64px}#sidebar-toggle:checked ~ #main-wrapper #sidebar{transform:translateX(0)}@media (min-width:768px){#sidebar{transform:translateX(0);width:280px}.content-area{margin-left:262px;min-height:calc(100vh - 64px)}}@media (max-width:767px){.content-area{margin-left:0}}</style></head><body class="bg-gray-50 font-sans"><input type="checkbox" id="sidebar-toggle" class="hidden"><header class="bg-gray-900 fixed top-0 left-0 right-0 z-30 shadow-lg border-b border-gray-900" style="height:64px"><div class="flex items-center justify-between h-16 px-4 md:px-6 max-w-full mx-auto"><div class="flex items-center space-x-4"><label for="sidebar-toggle" class="md:hidden p-2 cursor-pointer text-white hover:bg-red-600 rounded-lg transition"><i class="fa-solid fa-bars text-xl"></i></label><img src="assets/safemati-logo.png" alt="SafeMati Logo" class="h-14 w-auto object-contain"></div><div class="flex-1 max-w-lg mx-4 hidden sm:block"><div class="relative"><i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i><input type="text" placeholder="Search for users, alerts, or reports..." class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 transition"></div></div><div class="flex items-center space-x-4"><div class="relative hidden sm:block"><button class="p-2 text-white hover:text-red-100 hover:bg-red-600 rounded-full transition"><i class="fa-regular fa-bell text-xl"></i><span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-300 border border-red-700"></span></button></div><div class="relative group"><button class="flex items-center space-x-2 p-1.5 rounded-full hover:bg-red-600 transition focus:outline-none"><img src="<?php echo $profile_image_url;?>" alt="Admin Profile" class="h-8 w-8 rounded-full border border-red-300 object-cover bg-gray-200"><span class="text-sm font-medium text-white hidden md:inline"><?php echo htmlspecialchars($admin_name);?></span><i class="fa-solid fa-chevron-down text-xs text-red-300 hidden md:inline"></i></button><div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-30"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-user-circle mr-2 w-4"></i> Profile</a><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-gear mr-2 w-4"></i> Settings</a><div class="border-t border-gray-100 my-1"></div><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Logout</a></div></div></div></div></header><div id="main-wrapper" class="flex" style="margin-top:64px"><aside id="sidebar" class="fixed left-0 bg-white w-72 border-r border-gray-200 z-20 md:static md:translate-x-0 overflow-y-auto shadow-xl md:shadow-none"><nav class="space-y-2 px-4 py-4"><?php foreach($nav_links as $name=>$link):?><?php $isActive=($name===$active_link);$linkClasses="flex items-center space-x-3 p-3 text-sm font-medium rounded-lg transition duration-150";$linkClasses.=" text-gray-700 hover:bg-red-50 hover:text-red-700";if($isActive){$linkClasses="flex items-center space-x-3 p-3 text-sm font-medium rounded-lg text-red-700 bg-red-50 transition duration-150";}?><a href="<?php echo htmlspecialchars($link['url']);?>" class="<?php echo $linkClasses;?>"><i class="fa-solid <?php echo htmlspecialchars($link['icon']);?> w-5 text-center"></i><span><?php echo htmlspecialchars($name);?></span></a><?php endforeach;?></nav><div class="mt-auto p-4 border-t border-gray-200 hidden md:block"><span class="text-xs text-gray-400">SafeMati Disaster Response</span></div></aside>

<!-- Main Content Area -->
<div class="flex-1 content-area p-4 md:p-6 w-full bg-gray-50 max-w-7xl">
    
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="text-3xl font-bold text-gray-800">Hotlines Management</h1>
        <p class="text-gray-600 mt-1">Manage emergency hotlines and contact information</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Total Hotlines</p>
            <h3 class="text-3xl font-bold text-gray-800">45</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Active</p>
            <h3 class="text-3xl font-bold text-green-600">42</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Inactive</p>
            <h3 class="text-3xl font-bold text-gray-600">3</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <p class="text-sm text-gray-600 mb-1">Regions Covered</p>
            <h3 class="text-3xl font-bold text-red-700">17</h3>
        </div>
    </div>

    <!-- Add Hotline Form -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Add New Hotline</h2>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agency/Department Name</label>
                    <input type="text" placeholder="e.g., Philippine National Police" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>Select category...</option>
                        <option>Police</option>
                        <option>Fire Department</option>
                        <option>Medical/Ambulance</option>
                        <option>Disaster Response</option>
                        <option>Coast Guard</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hotline Number</label>
                    <input type="text" placeholder="e.g., 117 or +63 2 8888 8888" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>Select region...</option>
                        <option>National</option>
                        <option>NCR - Metro Manila</option>
                        <option>Region I - Ilocos</option>
                        <option>Region II - Cagayan Valley</option>
                        <option>Region III - Central Luzon</option>
                        <option>Region IV-A - CALABARZON</option>
                        <option>Region V - Bicol</option>
                        <option>Region VI - Western Visayas</option>
                        <option>Region VII - Central Visayas</option>
                        <option>Region VIII - Eastern Visayas</option>
                        <option>Region IX - Zamboanga Peninsula</option>
                        <option>Region X - Northern Mindanao</option>
                        <option>Region XI - Davao</option>
                        <option>Region XII - SOCCSKSARGEN</option>
                        <option>Region XIII - Caraga</option>
                        <option>CAR - Cordillera</option>
                        <option>BARMM</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                <textarea rows="2" placeholder="Additional information about the hotline..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400"></textarea>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-plus mr-2"></i> Add Hotline
                </button>
                <button type="reset" class="bg-white hover:bg-gray-50 text-gray-800 border border-gray-300 px-6 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-rotate-left mr-2"></i> Reset
                </button>
            </div>
        </form>
    </div>

    <!-- Hotlines Table Section -->
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
        
        <!-- Table Header with Search and Filter -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
            <h2 class="text-xl font-bold text-gray-800">All Hotlines</h2>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                <!-- Search -->
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Search hotlines..." 
                           class="pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400 w-full sm:w-64">
                </div>
                
                <!-- Category Filter -->
                <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                    <option>All Categories</option>
                    <option>Police</option>
                    <option>Fire Department</option>
                    <option>Medical/Ambulance</option>
                    <option>Disaster Response</option>
                    <option>Coast Guard</option>
                    <option>Other</option>
                </select>
                
                <!-- Region Filter -->
                <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300 focus:border-red-400">
                    <option>All Regions</option>
                    <option>National</option>
                    <option>NCR - Metro Manila</option>
                    <option>Visayas</option>
                    <option>Mindanao</option>
                </select>
            </div>
        </div>

        <!-- Hotlines Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Agency/Department</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Category</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Hotline Number</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Region</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Last Updated</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <!-- Hotline Row 1 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-shield text-red-700"></i>
                                <span class="text-gray-800 font-medium">Philippine National Police</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Police</td>
                        <td class="py-3 px-4">
                            <span class="text-gray-800 font-medium">117</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">National</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 20, 2025</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Hotline Row 2 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-fire-extinguisher text-red-700"></i>
                                <span class="text-gray-800 font-medium">Bureau of Fire Protection</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Fire Department</td>
                        <td class="py-3 px-4">
                            <span class="text-gray-800 font-medium">160</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">National</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 19, 2025</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Hotline Row 3 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-truck-medical text-red-700"></i>
                                <span class="text-gray-800 font-medium">Red Cross Emergency</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Medical/Ambulance</td>
                        <td class="py-3 px-4">
                            <span class="text-gray-800 font-medium">143</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">National</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 18, 2025</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Hotline Row 4 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-house-tsunami text-red-700"></i>
                                <span class="text-gray-800 font-medium">NDRRMC Operations Center</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Disaster Response</td>
                        <td class="py-3 px-4">
                            <span class="text-gray-800 font-medium">+63 2 8911 5061</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">National</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 17, 2025</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Hotline Row 5 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-ship text-red-700"></i>
                                <span class="text-gray-800 font-medium">Philippine Coast Guard</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Coast Guard</td>
                        <td class="py-3 px-4">
                            <span class="text-gray-800 font-medium">+63 2 8527 8481</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">National</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 16, 2025</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Hotline Row 6 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-hospital text-red-700"></i>
                                <span class="text-gray-800 font-medium">Metro Manila Emergency</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Medical/Ambulance</td>
                        <td class="py-3 px-4">
                            <span class="text-gray-800 font-medium">+63 2 8888 8888</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">NCR - Metro Manila</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 15, 2025</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Hotline Row 7 -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-phone text-red-700"></i>
                                <span class="text-gray-800 font-medium">Cebu Emergency Hotline</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Other</td>
                        <td class="py-3 px-4">
                            <span class="text-gray-800 font-medium">+63 32 411 4000</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Region VII - Central Visayas</td>
                        <td class="py-3 px-4">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">Inactive</span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Nov 10, 2025</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-600 hover:text-red-700 p-1" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
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
            <p class="text-sm text-gray-600">Showing 1 to 7 of 45 hotlines</p>
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
<script>document.addEventListener('DOMContentLoaded',()=>{const sidebarToggle=document.getElementById('sidebar-toggle');const navLinks=document.querySelectorAll('#sidebar a');navLinks.forEach(link=>{link.addEventListener('click',()=>{if(window.innerWidth<768){sidebarToggle.checked=false;}});});document.addEventListener('click',(e)=>{if(window.innerWidth<768){const sidebar=document.getElementById('sidebar');const toggle=document.querySelector('label[for="sidebar-toggle"]');if(sidebarToggle.checked&&!sidebar.contains(e.target)&&!toggle.contains(e.target)){sidebarToggle.checked=false;}}});});</script></body></html>
