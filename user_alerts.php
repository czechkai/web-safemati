<?php
    // --- PHP Placeholder Data Structure ---

    // Define the sample alert data. This data is designed to be looped over by PHP.
    // The 'is_safe' property controls the initial state of the Mark as Safe button.
    $alerts = [
        [
            'id' => 1,
            'type' => 'Flood',
            'title' => 'Severe Flood Warning in Brgy. Central',
            'severity' => 'Severe',
            'timestamp' => '10 minutes ago',
            'description' => 'Heavy rainfall has caused river levels to rise rapidly. Evacuation to designated centers is strongly advised for low-lying areas.',
            'is_safe' => false,
        ],
        [
            'id' => 2,
            'type' => 'Fire',
            'title' => 'Fire Advisory in Purok 5, Dahican',
            'severity' => 'Advisory',
            'timestamp' => '2 hours ago',
            'description' => 'A small grass fire has been reported. Firefighters are on site. Residents should keep pathways clear and secure flammable materials.',
            'is_safe' => true,
        ],
        [
            'id' => 3,
            'type' => 'Earthquake',
            'title' => 'Moderate Earthquake Alert - Matiao',
            'severity' => 'Moderate',
            'timestamp' => 'Yesterday, 8:15 AM',
            'description' => 'A magnitude 5.2 earthquake struck. Check your homes for damage and be prepared for aftershocks.',
            'is_safe' => false,
        ],
        [
            'id' => 4,
            'type' => 'Typhoon',
            'title' => 'Typhoon Watch for Mati City',
            'severity' => 'Severe',
            'timestamp' => '2 days ago',
            'description' => 'Typhoon "SafeMati" is approaching. Secure your property, prepare emergency kits, and monitor updates closely.',
            'is_safe' => false,
        ],
        [
            'id' => 5,
            'type' => 'Landslide',
            'title' => 'Landslide Advisory near Badas Road',
            'severity' => 'Advisory',
            'timestamp' => '5 days ago',
            'description' => 'Minor soil movement detected. Use alternate routes and avoid steep slopes until further notice.',
            'is_safe' => false,
        ],
        [
            'id' => 6,
            'type' => 'Flood',
            'title' => 'Advisory: Tides High in Bucana',
            'severity' => 'Advisory',
            'timestamp' => '6 days ago',
            'description' => 'High tides are expected to peak at 2.5m today. Coastal residents should take necessary precautions.',
            'is_safe' => false,
        ],
    ];

    // Helper data for mapping icons and colors - Red/Gray/Black palette
    $alert_map = [
        'Flood' => ['icon' => 'fa-water', 'color' => 'text-red-400'],
        'Fire' => ['icon' => 'fa-fire', 'color' => 'text-red-500'],
        'Earthquake' => ['icon' => 'fa-house-crack', 'color' => 'text-red-400'],
        'Landslide' => ['icon' => 'fa-mountain', 'color' => 'text-gray-300'],
        'Typhoon' => ['icon' => 'fa-wind', 'color' => 'text-red-300'],
    ];

    $severity_map = [
        'Severe' => ['bg' => 'bg-red-600', 'text' => 'text-white', 'border' => '#ef4444'],
        'Moderate' => ['bg' => 'bg-red-500', 'text' => 'text-white', 'border' => '#f87171'],
        'Advisory' => ['bg' => 'bg-gray-600', 'text' => 'text-white', 'border' => '#9ca3af'],
    ];

    // Encode PHP data for JavaScript use
    $alerts_json = json_encode($alerts);

    // --- Start HTML and Header Inclusion ---
    // NOTE: Replace these with actual include paths in your environment
    include 'user_header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeMati Alerts</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Define custom keyframes and utility classes for the gradient button */
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 10px rgba(255, 69, 0, 0.6), 0 0 20px rgba(255, 69, 0, 0.4); }
            50% { box-shadow: 0 0 15px rgba(255, 69, 0, 0.8), 0 0 30px rgba(255, 69, 0, 0.6); }
        }
        .btn-red-gradient {
            background-image: linear-gradient(to right, #ef4444, #dc2626, #b91c1c); /* Red-500 to Red-700 */
            transition: all 0.3s ease-in-out;
            transform-origin: center;
        }
        .btn-red-gradient:hover {
            opacity: 0.9;
            transform: scale(1.02);
            animation: glow 1.5s infinite alternate; /* Hover glow animation */
        }
        .btn-safe {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Smooth, slightly bouncy transition */
        }

        /* Custom scrollbar for filter bar on desktop */
        .filter-scroll::-webkit-scrollbar {
            height: 6px;
        }
        .filter-scroll::-webkit-scrollbar-thumb {
            background-color: #fca5a5; /* Red-300 */
            border-radius: 3px;
        }
        .filter-scroll::-webkit-scrollbar-track {
            background-color: #fee2e2; /* Red-100 */
        }
    </style>
</head>
<body class="bg-gray-900 font-sans min-h-screen flex flex-col">

    <!-- SIMULATED user_header.php START -->
    <header class="bg-gray-800 shadow-md border-b border-red-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-extrabold text-red-500">SafeMati</h1>
            <nav>
                <a href="#" class="text-gray-300 hover:text-red-500 p-2 rounded-full transition"><i class="fa-solid fa-user-circle"></i> Profile</a>
            </nav>
        </div>
    </header>
    <!-- SIMULATED user_header.php END -->

    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8" style="min-height: calc(100vh - 200px);">
        <h1 class="text-4xl font-bold text-white mb-8 border-b border-red-500 pb-4">Real-Time Disaster Alerts</h1>

        <!-- 4. Filters Above Alert Grid -->
        <div class="mb-8 overflow-x-auto filter-scroll">
            <div id="filter-bar" class="flex space-x-3 pb-2 w-max sm:w-full">
                <?php
                    $categories = array_keys($alert_map);
                    array_unshift($categories, 'ALL');
                    foreach ($categories as $category):
                ?>
                    <button
                        data-filter="<?php echo strtolower($category); ?>"
                        class="filter-pill whitespace-nowrap px-4 py-2 text-sm font-medium rounded-full border-2 border-red-500 text-red-400 bg-gray-800 hover:bg-gray-700 transition duration-200 shadow-sm
                        <?php echo ($category === 'ALL') ? 'bg-red-500 text-white border-red-500 !hover:bg-red-500' : ''; ?>"
                        >
                        <?php echo $category; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 5. Empty State UI (Hidden by default) -->
        <div id="empty-state" class="hidden flex flex-col items-center justify-center py-24 text-center text-gray-500">
            <i class="fa-regular fa-bell-slash text-9xl opacity-30 mb-4"></i>
            <p class="text-xl font-semibold text-gray-400">No active alerts found in this category.</p>
            <p class="text-sm mt-2 text-gray-500">Stay informed and stay safe. Check back later for updates.</p>
        </div>

        <!-- Alert Grid Container -->
        <div
            id="alerts-grid"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
            <?php
                // PHP loop to generate alert cards
                foreach ($alerts as $alert):
                    $map = $alert_map[$alert['type']];
                    $sev = $severity_map[$alert['severity']];
            ?>
                <!-- Alert Card Structure (1-3 Columns Responsive) -->
                <div
                    class="alert-card bg-gray-800 p-6 rounded-xl shadow-lg border-t-4 transition duration-300 hover:shadow-2xl hover:-translate-y-0.5 border border-gray-700 flex flex-col min-h-[320px]"
                    data-alert-id="<?php echo $alert['id']; ?>"
                    data-alert-type="<?php echo strtolower($alert['type']); ?>"
                    data-is-safe="<?php echo $alert['is_safe'] ? 'true' : 'false'; ?>"
                    style="border-top-color: <?php echo $sev['border']; ?>;"
                >
                    <!-- Header: Icon, Title, and Severity Badge -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-start space-x-3">
                            <i class="fa-solid <?php echo $map['icon']; ?> <?php echo $map['color']; ?> text-3xl pt-1"></i>
                            <div>
                                <h2 class="text-xl font-extrabold text-white leading-snug"><?php echo htmlspecialchars($alert['title']); ?></h2>
                                <p class="text-xs text-gray-400 mt-0.5"><?php echo htmlspecialchars($alert['timestamp']); ?></p>
                            </div>
                        </div>

                        <!-- Severity Badge -->
                        <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-md <?php echo $sev['bg'] . ' ' . $sev['text']; ?>">
                            <?php echo htmlspecialchars($alert['severity']); ?>
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="flex-grow">
                        <p class="text-gray-300 mb-6 text-sm line-clamp-3">
                            <?php echo htmlspecialchars($alert['description']); ?>
                        </p>
                    </div>

                    <!-- 2. Buttons Area -->
                    <div class="mt-auto flex justify-end space-x-3 border-t border-gray-700 pt-4">
                        <!-- View Details (Secondary) -->
                        <button class="px-4 py-2 text-sm font-semibold rounded-lg bg-gray-700 text-gray-200 hover:bg-gray-600 transition duration-150">
                            View Details
                        </button>

                        <!-- Mark as Safe Button (Primary - Dynamic with Undo) -->
                        <?php
                            $btn_id = 'safe-btn-' . $alert['id'];
                            $btn_safe_class = $alert['is_safe'] ? 'bg-green-600 hover:bg-green-700' : 'btn-red-gradient shadow-lg';
                            $btn_safe_text = $alert['is_safe'] ? "You're Safe" : "Mark as Safe";
                            $btn_safe_icon = $alert['is_safe'] ? 'fa-check' : 'fa-shield-halved';
                        ?>
                        <button
                            id="<?php echo $btn_id; ?>"
                            class="safe-toggle-btn px-4 py-2 text-sm font-bold rounded-lg text-white shadow-md btn-safe <?php echo $btn_safe_class; ?>"
                            data-alert-id="<?php echo $alert['id']; ?>"
                            data-is-safe="<?php echo $alert['is_safe'] ? 'true' : 'false'; ?>"
                            onclick="toggleSafeState(this)"
                        >
                            <i class="fa-solid <?php echo $btn_safe_icon; ?> mr-2"></i>
                            <span class="button-text"><?php echo $btn_safe_text; ?></span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <!-- SIMULATED user_footer.php END -->

    <?php
        // --- Footer Inclusion ---
        // include 'user_footer.php';
    ?>

    <script>
        // --- JavaScript Logic ---

        // 1. Data Initialization
        const initialAlerts = <?php echo $alerts_json; ?>;
        const alertGrid = document.getElementById('alerts-grid');
        const filterBar = document.getElementById('filter-bar');
        const emptyState = document.getElementById('empty-state');
        let currentFilter = 'all'; // Default filter

        // Function to simulate AJAX request
        function sendAjaxUpdate(alertId, isSafe) {
            console.log(`[AJAX DUMMY] Sending update for Alert ID ${alertId}: is_safe = ${isSafe}`);
            // In a real application, you would use fetch() here:
            /*
            fetch('/api/mark_safe.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: alertId, is_safe: isSafe })
            }).then(response => {
                if (response.ok) {
                    console.log('Update successful!');
                }
            }).catch(error => {
                console.error('Update failed:', error);
            });
            */
        }

        // 3. "Mark as Safe" UI Behavior and Animation (with UNDO support)
        function toggleSafeState(button) {
            const alertId = button.getAttribute('data-alert-id');
            const isSafe = button.getAttribute('data-is-safe') === 'true';

            // Toggle between safe and unsafe states
            const newIsSafe = !isSafe;
            button.setAttribute('data-is-safe', newIsSafe);

            const icon = button.querySelector('i');
            const textSpan = button.querySelector('.button-text');

            // Animation: Start with scale down
            button.style.transform = 'scale(0.9)';
            button.style.opacity = '0.5';

            setTimeout(() => {
                if (newIsSafe) {
                    // Marking as SAFE
                    button.classList.remove('btn-red-gradient', 'shadow-lg');
                    button.classList.add('bg-green-600', 'hover:bg-green-700');
                    
                    icon.classList.remove('fa-shield-halved');
                    icon.classList.add('fa-check');
                    textSpan.textContent = "You're Safe";
                } else {
                    // UNDO - Back to unsafe state
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('btn-red-gradient', 'shadow-lg');
                    
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-shield-halved');
                    textSpan.textContent = "Mark as Safe";
                }

                // Final transition: Scale up and fade in
                button.style.transform = 'scale(1)';
                button.style.opacity = '1';
                button.style.animation = newIsSafe ? 'none' : '';

                // Send AJAX update
                sendAjaxUpdate(alertId, newIsSafe);
            }, 50);

            // Update the card's data attribute
            const card = button.closest('.alert-card');
            if(card) {
                card.setAttribute('data-is-safe', newIsSafe);
            }
        }


        // 4. Filtering Logic
        function updateFilterUI(newFilter) {
            document.querySelectorAll('.filter-pill').forEach(btn => {
                btn.classList.remove('bg-red-500', 'text-white', 'border-red-500', '!hover:bg-red-500');
                btn.classList.add('bg-gray-800', 'text-red-400', 'border-red-500');

                if (btn.getAttribute('data-filter') === newFilter) {
                    btn.classList.remove('bg-gray-800', 'text-red-400', 'border-red-500');
                    btn.classList.add('bg-red-500', 'text-white', 'border-red-500', '!hover:bg-red-500');
                }
            });
        }

        function filterAlerts(filter) {
            currentFilter = filter;
            let foundAlerts = false;

            document.querySelectorAll('.alert-card').forEach(card => {
                const cardType = card.getAttribute('data-alert-type');

                if (filter === 'all' || cardType === filter) {
                    // Show the card (using classes for transition)
                    card.classList.remove('hidden');
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                    foundAlerts = true;
                } else {
                    // Hide the card with a fade-out animation
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        card.classList.add('hidden');
                    }, 300); // Match transition duration
                }
            });

            // 5. Empty State UI check
            if (foundAlerts) {
                emptyState.classList.add('hidden');
            } else {
                emptyState.classList.remove('hidden');
            }

            // Update filter button appearance
            updateFilterUI(filter);
        }

        // Initialize listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Setup filter click listeners
            filterBar.addEventListener('click', (e) => {
                const target = e.target.closest('.filter-pill');
                if (target) {
                    const filter = target.getAttribute('data-filter');
                    filterAlerts(filter);
                }
            });

            // Ensure initial state is correct (ALL filter active)
            filterAlerts(currentFilter);
        });

    </script>
</body>
</html>
<?php
   include 'user_footer.php';
?>