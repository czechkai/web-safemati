<?php 
    // This loads the HTML head, opening body tag, fixed header, 
    // mobile menu script, and enforces the session check/redirect.
    include 'user_header.php'; 

    // --- 1. WELCOME / USER GREETING DATA ---
    $user_first_name = $_SESSION['user_name'] ?? 'User';

    // --- 2. TODAY'S QUICK STATS DATA (SIMULATED) ---
    $stats = [
        ['count' => '3 Active', 'label' => 'Alerts Today', 'icon' => 'fa-triangle-exclamation', 'color' => 'text-red-500', 'link' => 'user_alerts.php'],
        ['count' => 'Clear Sky', 'label' => 'Weather Status', 'icon' => 'fa-cloud-sun', 'color' => 'text-blue-400', 'link' => '#weather-overview'],
        ['count' => '5 Available', 'label' => 'Evac Centers Open', 'icon' => 'fa-person-shelter', 'color' => 'text-green-500', 'link' => 'user_hazard_map.php'],
        ['count' => '2 New', 'label' => 'Unread Updates', 'icon' => 'fa-bell', 'color' => 'text-yellow-500', 'link' => 'user_notifications.php'],
    ];

    // --- 3. LATEST ALERTS SECTION DATA (SIMULATED) ---
    // Consistent red/gray theme for all alerts
    $latest_alerts = [
        [
            'id' => 1,
            'title' => 'Flood Watch in Barangay Central',
            'category' => 'Flood',
            'datetime' => 'Issued: Nov 19, 2025 - 3:14 PM',
            'description' => 'Heavy rains expected in low-lying areas. Residents near rivers advised to monitor water levels.',
            'full_details' => 'Heavy rainfall has caused river levels to rise rapidly in Barangay Central. Local authorities are monitoring the situation closely. Residents in low-lying areas should prepare evacuation kits and be ready to move to higher ground if water levels continue to rise. Avoid crossing flooded roads and stay updated with official announcements.',
            'color_class' => 'border-l-red-600',
            'category_class' => 'bg-red-600/20 text-red-400 border-red-500/50',
            'is_safe' => false
        ],
        [
            'id' => 2,
            'title' => 'Structural Fire near Public Market',
            'category' => 'Fire',
            'datetime' => 'Reported: Nov 19, 2025 - 1:05 PM',
            'description' => 'BFP teams are responding. Avoid the area near the public market for safety.',
            'full_details' => 'A structural fire has been reported near the Public Market area. BFP (Bureau of Fire Protection) teams are currently on-site and actively working to contain the blaze. Residents and motorists are advised to avoid the area to allow emergency vehicles clear access. Keep windows closed if you live nearby to avoid smoke inhalation.',
            'color_class' => 'border-l-red-600',
            'category_class' => 'bg-red-600/20 text-red-400 border-red-500/50',
            'is_safe' => false
        ],
        [
            'id' => 3,
            'title' => 'M 4.2 Earthquake Advisory',
            'category' => 'Earthquake',
            'datetime' => 'Recorded: Nov 18, 2025 - 10:00 AM',
            'description' => 'Minor tremor felt. No tsunami warning issued. Check buildings for cracks.',
            'full_details' => 'A magnitude 4.2 earthquake was recorded at 10:00 AM. The tremor was felt across Mati City but no major damage has been reported. PHIVOLCS confirms no tsunami warning has been issued. Residents are advised to inspect buildings for structural cracks and report any damage to local authorities. Be prepared for possible aftershocks.',
            'color_class' => 'border-l-red-600',
            'category_class' => 'bg-red-600/20 text-red-400 border-red-500/50',
            'is_safe' => false
        ],
    ];

    // --- 5. SAFETY TIPS OF THE DAY DATA (SIMULATED) ---
    $safety_tips = [
        "Prepare a 'Go-Bag' with essentials like water, food, first aid, and copies of important documents.",
        "Know the nearest evacuation route and the designated safe zone from your home and workplace.",
        "Keep a battery-powered radio and extra batteries handy to receive official updates during power outages.",
        "Secure tall furniture to the walls to prevent them from toppling over during an earthquake.",
    ];
    $today_tip = $safety_tips[array_rand($safety_tips)];

    // --- 6. WEATHER OVERVIEW DATA (SIMULATED) ---
    $weather_data = [
        'city' => 'Mati City',
        'temperature' => '31°C',
        'condition' => 'Partly Cloudy',
        'humidity' => '75%',
        'wind' => '15 km/h NE'
    ];
?>

<!-- IMPORTANT FIX: Added pt-24 to push content below the fixed header -->br
<div class="pt-24 p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-12"><br><br>

    <!-- 1. Welcome Header -->
    <header class="p-6 sm:p-8 rounded-2xl shadow-2xl transition transform bg-gradient-to-r from-gray-900 to-gray-800 border border-red-700/50">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-2">
            Welcome back, <span class="text-red-500 drop-shadow-lg"><?= htmlspecialchars($user_first_name); ?></span>!
        </h1>
        <p class="text-gray-400 text-lg">Stay updated with the latest safety information for Mati City.</p>
    </header>

    <!-- 2. Today’s Quick Stats (4 Cards) -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <?php foreach ($stats as $stat): ?>
        <a href="<?= $stat['link']; ?>" class="group block bg-gray-800 p-5 rounded-xl shadow-xl border border-gray-700 transition duration-300 transform hover:scale-[1.05] hover:border-red-500 hover:shadow-red-900/40">
            <div class="flex flex-col items-center justify-center text-center">
                <i class="fa-solid <?= $stat['icon']; ?> <?= $stat['color']; ?> text-3xl sm:text-4xl mb-3 opacity-90 group-hover:opacity-100 transition"></i>
                <p class="text-xl sm:text-2xl font-bold text-white mb-1 leading-tight"><?= $stat['count']; ?></p>
                <p class="text-xs sm:text-sm text-gray-400 font-medium tracking-wider uppercase"><?= $stat['label']; ?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </section>

    <!-- Main Content Grid (Alerts, Quick Actions, Tips, Weather, Map) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left Column (Span 2): Latest Alerts Feed -->
        <section class="lg:col-span-2 space-y-6">
            <h2 class="text-2xl font-bold text-white border-b border-red-700/50 pb-3 mb-6"><i class="fa-solid fa-bell-c text-red-500 mr-2"></i> Critical & Latest Alerts</h2>

            <?php foreach ($latest_alerts as $index => $alert): ?>
            <div id="alert-card-<?= $alert['id']; ?>" class="bg-gray-800 p-6 rounded-xl shadow-xl border-l-8 <?= $alert['color_class']; ?> transition duration-200 hover:bg-gray-700/50 hover:shadow-2xl flex flex-col min-h-[280px]" data-is-safe="<?= $alert['is_safe'] ? 'true' : 'false'; ?>">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-bold text-white"><?= $alert['title']; ?></h3>
                    <span class="text-xs font-bold px-3 py-1 rounded-full <?= $alert['category_class']; ?> border flex-shrink-0">
                        <?= $alert['category']; ?>
                    </span>
                </div>
                <p class="text-gray-400 text-sm italic mb-4"><?= $alert['datetime']; ?></p>
                <div class="flex-grow">
                    <p class="text-gray-300 mb-5 leading-relaxed"><?= $alert['description']; ?></p>
                </div>
                <div class="mt-auto flex gap-3">
                    <button onclick="openAlertModal(<?= $alert['id']; ?>)" class="btn-gradient-sm inline-flex items-center text-sm font-bold px-4 py-2 rounded-lg transition duration-150 transform hover:scale-[1.03]">
                        <i class="fa-solid fa-circle-info mr-2"></i> View Details
                    </button>
                    <button onclick="markAsSafe(<?= $alert['id']; ?>)" id="safe-btn-<?= $alert['id']; ?>" class="safe-button bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition duration-150 inline-flex items-center">
                        <i class="fa-solid fa-shield-check mr-2"></i> Mark as Safe
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </section>

        <!-- Right Column (Span 1): Side Widgets -->
        <div class="lg:col-span-1 space-y-10">
            
            <!-- 5. Safety Tips of the Day -->
            <section>
                <h2 class="text-xl font-bold text-white mb-4"><i class="fa-solid fa-lightbulb mr-2 text-yellow-400"></i> Safety Tip of the Day</h2>
                <div class="bg-gray-800 p-5 rounded-xl shadow-xl border border-gray-700">
                    <p class="text-gray-300 italic text-md leading-relaxed">
                        "<?= $today_tip; ?>"
                    </p>
                </div>
            </section>
            
            <!-- 4. Quick Actions Section -->
            <section>
                <h2 class="text-xl font-bold text-white mb-4"><i class="fa-solid fa-bolt mr-2 text-red-500"></i> Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    
                    <?php 
                        $actions = [
                            ['title' => 'View All Alerts', 'icon' => 'fa-list-ul', 'link' => 'user_alerts.php'],
                            ['title' => 'Report Emergency', 'icon' => 'fa-triangle-exclamation', 'link' => 'user_report_emergency.php'],
                            ['title' => 'Emergency Hotlines', 'icon' => 'fa-phone-volume', 'link' => 'user_hotlines.php'],
                            ['title' => 'Disaster Guides', 'icon' => 'fa-book-open', 'link' => 'user_guides.php'],
                        ];
                    ?>
                    
                    <?php foreach ($actions as $action): ?>
                    <a href="<?= $action['link']; ?>" class="action-tile p-4 bg-gray-800 rounded-xl text-center border border-gray-700 transition duration-200 transform hover:scale-[1.05] hover:border-red-500 hover:bg-gray-700">
                        <i class="fa-solid <?= $action['icon']; ?> text-3xl text-red-500 mb-2 drop-shadow-md"></i>
                        <p class="text-xs font-medium text-white"><?= $action['title']; ?></p>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            
            <!-- 6. Weather Overview -->
            <section>
                <h2 class="text-xl font-bold text-white mb-4">
                    <i class="fa-solid fa-cloud-sun mr-2 text-blue-400"></i> Weather Overview
                </h2>
                <div class="weather-card p-6 w-full rounded-2xl text-white bg-gradient-to-br from-blue-900/40 to-blue-800/40 border-2 border-blue-700/50">
                    
                    <h2 class="text-3xl font-extrabold mb-1 tracking-tight">
                        Mati City
                    </h2>
                    <p class="text-gray-400 mb-6 text-sm">Davao Oriental, Philippines</p>

                    <!-- Current Conditions -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <p id="current-temp" class="text-7xl font-light mr-4 text-blue-300">
                                31<span class="text-4xl align-top">°C</span>
                            </p>
                            <div>
                                <p id="description" class="text-xl font-semibold">Partly Sunny</p>
                                <p id="real-feel" class="text-sm text-gray-400">RealFeel: 37°C</p>
                            </div>
                        </div>
                        <!-- Weather icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-400">
                            <circle cx="12" cy="12" r="6"/>
                            <path d="M12 2v2"/>
                            <path d="M12 20v2"/>
                            <path d="m4.93 4.93 1.41 1.41"/>
                            <path d="m17.66 17.66 1.41 1.41"/>
                            <path d="M2 12h2"/>
                            <path d="M20 12h2"/>
                            <path d="m6.34 17.66-1.41 1.41"/>
                            <path d="m19.07 4.93-1.41 1.41"/>
                        </svg>
                    </div>

                    <!-- Detailed Metrics -->
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        
                        <div class="data-point pb-4 flex items-center">
                            <i class="fa-solid fa-wind text-cyan-400 text-xl mr-3"></i>
                            <div>
                                <p class="text-gray-400">Wind</p>
                                <p class="font-medium">E 7 km/h</p>
                            </div>
                        </div>

                        <div class="data-point pb-4 flex items-center">
                            <i class="fa-solid fa-droplet text-cyan-400 text-xl mr-3"></i>
                            <div>
                                <p class="text-gray-400">Humidity</p>
                                <p class="font-medium">78%</p>
                            </div>
                        </div>

                        <div class="data-point pb-4 flex items-center">
                            <i class="fa-solid fa-gauge text-cyan-400 text-xl mr-3"></i>
                            <div>
                                <p class="text-gray-400">Pressure</p>
                                <p class="font-medium">1012 hPa</p>
                            </div>
                        </div>

                        <div class="data-point pb-4 flex items-center">
                            <i class="fa-solid fa-sun text-cyan-400 text-xl mr-3"></i>
                            <div>
                                <p class="text-gray-400">UV Index</p>
                                <p class="font-medium">Moderate (5)</p>
                            </div>
                        </div>
                        
                    </div>

                    <div class="mt-6 pt-4 border-t border-blue-700/50">
                        <p class="text-xs text-gray-500 mb-2">
                            Live data sourced from:
                        </p>
                        <a href="https://www.accuweather.com/en/ph/mati-city/262967/weather-forecast/262967" target="_blank" class="flex items-center text-sm font-semibold text-sky-400 hover:text-sky-300 transition-colors">
                            <i class="fas fa-external-link-alt text-xs mr-2"></i> AccuWeather - Mati City
                        </a>
                        <p class="text-xs text-red-400 mt-2">
                            *Simulated data - not real-time
                        </p>
                    </div>

                </div>
            </section>
            
            <!-- 7. City Hazard Map -->
            <section>
                <h2 class="text-xl font-bold text-white mb-4">
                    <i class="fa-solid fa-map-location-dot mr-2 text-red-500"></i> Hazard Map
                </h2>
                <div class="bg-gray-800 rounded-xl shadow-2xl border-2 border-gray-700 overflow-hidden">
                    <div class="relative w-full" style="height: 400px;">
                        <iframe 
                            src="https://hazardhunter.georisk.gov.ph/map" 
                            title="Philippine Hazard Hunter Map" 
                            class="w-full h-full border-none" 
                            allowfullscreen 
                            loading="lazy">
                            <div class="p-8 text-center bg-gray-900 flex flex-col justify-center items-center h-full">
                                <p class="text-lg text-gray-300 mb-4">
                                    <i class="fa-solid fa-triangle-exclamation text-yellow-500 mr-2"></i> 
                                    The external website restricts direct embedding.
                                </p>
                                <a href="https://hazardhunter.georisk.gov.ph/map" target="_blank" 
                                   class="inline-block px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg uppercase tracking-wide transition duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fa-solid fa-up-right-from-square mr-2"></i> View Map in New Tab
                                </a>
                            </div>
                        </iframe>
                    </div>
                    
                    <div class="p-4 bg-gray-700 border-t border-gray-600">
                        <p class="text-sm text-gray-400 text-center">
                            Map data provided by HazardHunter, Philippine Government
                        </p>
                    </div>
                </div>
            </section>

        </div>
    </div>

</div>

<!-- Alert Details Modal -->
<div id="alertModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-75 flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full border-2 border-red-500/30 transform transition-all">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700">
            <div class="flex items-center">
                <span id="modalCategory" class="text-xs font-bold px-3 py-1 rounded-full bg-red-600/20 text-red-400 border border-red-500/50 mr-3">
                    Category
                </span>
                <h2 id="modalTitle" class="text-2xl font-bold text-white">Alert Title</h2>
            </div>
            <button onclick="closeAlertModal()" class="text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <div class="flex items-center text-gray-400 text-sm">
                <i class="fa-solid fa-clock mr-2"></i>
                <span id="modalDatetime">Timestamp</span>
            </div>
            
            <div class="bg-gray-900 p-4 rounded-lg border border-gray-700">
                <p id="modalDescription" class="text-gray-300 leading-relaxed">
                    Alert description will appear here...
                </p>
            </div>
            
            <div class="bg-red-900/20 border-l-4 border-red-500 p-4 rounded">
                <h3 class="text-white font-bold mb-2 flex items-center">
                    <i class="fa-solid fa-circle-info text-red-500 mr-2"></i>
                    Full Details
                </h3>
                <p id="modalFullDetails" class="text-gray-300 text-sm leading-relaxed">
                    Full details will appear here...
                </p>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 p-6 border-t border-gray-700 bg-gray-900/50">
            <button onclick="closeAlertModal()" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition">
                Close
            </button>
            <button onclick="markAsSafeFromModal()" id="modalMarkSafeBtn" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition inline-flex items-center">
                <i class="fa-solid fa-shield-check mr-2"></i>
                Mark as Safe
            </button>
        </div>
    </div>
</div>

<!-- Custom CSS for button gradient -->
<style>
    /* Large Button Gradient (used for Full Map, Report, etc.) */
    .btn-gradient {
        background: linear-gradient(90deg, #e60000 0%, #990000 100%);
        transition: all 0.3s ease;
    }
    .btn-gradient:hover {
        background: linear-gradient(90deg, #ff1a1a 0%, #cc0000 100%);
        box-shadow: 0 4px 15px rgba(230, 0, 0, 0.4);
    }
    /* Small Button Gradient (used for Read More links) */
    .btn-gradient-sm {
        background: linear-gradient(90deg, #cc0000 0%, #a30000 100%);
        color: #fff;
        box-shadow: 0 2px 8px rgba(204, 0, 0, 0.3);
    }
    .btn-gradient-sm:hover {
        background: linear-gradient(90deg, #e60000 0%, #cc0000 100%);
        box-shadow: 0 2px 10px rgba(230, 0, 0, 0.5);
    }

    /* Additional subtle styling for the main container */
    body {
        background-color: #121212; /* Ensure background is dark */
    }
    
    /* Safe button states */
    .safe-button.is-safe {
        background: #16a34a !important;
        cursor: default;
    }
    .safe-button.is-safe:hover {
        background: #15803d !important;
    }
</style>

<script>
// Alert data for modal
const alertsData = <?php echo json_encode($latest_alerts); ?>;
let currentAlertId = null;

// Open alert modal
function openAlertModal(alertId) {
    const alert = alertsData.find(a => a.id === alertId);
    if (!alert) return;
    
    currentAlertId = alertId;
    
    // Populate modal
    document.getElementById('modalCategory').textContent = alert.category;
    document.getElementById('modalTitle').textContent = alert.title;
    document.getElementById('modalDatetime').textContent = alert.datetime;
    document.getElementById('modalDescription').textContent = alert.description;
    document.getElementById('modalFullDetails').textContent = alert.full_details;
    
    // Update mark as safe button state
    const card = document.getElementById('alert-card-' + alertId);
    const isSafe = card.getAttribute('data-is-safe') === 'true';
    const modalBtn = document.getElementById('modalMarkSafeBtn');
    
    if (isSafe) {
        modalBtn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> You\'re Safe';
        modalBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
        modalBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        modalBtn.style.cursor = 'default';
    } else {
        modalBtn.innerHTML = '<i class="fa-solid fa-shield-check mr-2"></i> Mark as Safe';
        modalBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
        modalBtn.classList.add('bg-red-600', 'hover:bg-red-700');
        modalBtn.style.cursor = 'pointer';
    }
    
    // Show modal
    document.getElementById('alertModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Close alert modal
function closeAlertModal() {
    document.getElementById('alertModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentAlertId = null;
}

// Mark as safe from modal
function markAsSafeFromModal() {
    if (currentAlertId) {
        markAsSafe(currentAlertId);
    }
}

// Mark as safe function
function markAsSafe(alertId) {
    const card = document.getElementById('alert-card-' + alertId);
    const button = document.getElementById('safe-btn-' + alertId);
    const isSafe = card.getAttribute('data-is-safe') === 'true';
    
    if (isSafe) return; // Already marked as safe
    
    // Update card state
    card.setAttribute('data-is-safe', 'true');
    
    // Update button appearance
    button.innerHTML = '<i class="fa-solid fa-check mr-2"></i> You\'re Safe';
    button.classList.remove('bg-red-600', 'hover:bg-red-700');
    button.classList.add('bg-green-600', 'hover:bg-green-700', 'is-safe');
    button.style.cursor = 'default';
    
    // Update modal button if modal is open
    if (currentAlertId === alertId) {
        const modalBtn = document.getElementById('modalMarkSafeBtn');
        modalBtn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> You\'re Safe';
        modalBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
        modalBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        modalBtn.style.cursor = 'default';
    }
    
    // Show success toast
    showToast('You marked yourself as safe from this alert!');
    
    // TODO: Send AJAX request to save state to database
    // fetch('ajax/mark_alert_safe.php', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify({ alert_id: alertId })
    // });
}

// Toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-24 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center';
    toast.innerHTML = `<i class="fa-solid fa-check-circle mr-2"></i> ${message}`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAlertModal();
    }
});

// Close modal on outside click
document.getElementById('alertModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAlertModal();
    }
});
</script>

<?php 
    // This loads the closing HTML tags and the footer markup.
    include 'user_footer.php'; 
?>