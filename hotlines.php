<?php 
    include 'header.php'; 

    // Try loading hotlines from DB, fallback to inline array
    $hotlines = [];
    try {
        require_once __DIR__ . '/db.php';
        if (isset($pdo) && $pdo) {
            $stmt = $pdo->query("SELECT name, phone, category, icon, color FROM hotlines WHERE is_active=1 ORDER BY sort_order, created_at DESC LIMIT 200");
            $hotlines = $stmt->fetchAll();
        }
    } catch (Exception $e) {
        // ignore, will fallback to static list
    }

    if (empty($hotlines)) {
        $hotlines = [
            ['name' => 'Mati City Police Station', 'phone' => '911', 'category' => 'Police', 'icon' => 'fa-shield-halved', 'color' => 'blue-500'],
            ['name' => 'Mati Traffic Management', 'phone' => '082-822-1234', 'category' => 'Police', 'icon' => 'fa-car-side', 'color' => 'blue-400'],
            ['name' => 'Bureau of Fire Protection - Mati', 'phone' => '160', 'category' => 'Fire', 'icon' => 'fa-fire-extinguisher', 'color' => 'orange-500'],
            ['name' => 'Mati Doctors Hospital', 'phone' => '082-823-5678', 'category' => 'Medical', 'icon' => 'fa-kit-medical', 'color' => 'red-500'],
            ['name' => 'Provincial Health Office', 'phone' => '082-823-8765', 'category' => 'Medical', 'icon' => 'fa-stethoscope', 'color' => 'red-400'],
            ['name' => 'Mati CDRRMO (Disaster Office)', 'phone' => '911', 'category' => 'Rescue', 'icon' => 'fa-life-ring', 'color' => 'green-500'],
            ['name' => 'Philippine Coast Guard - Mati', 'phone' => '082-821-1122', 'category' => 'Rescue', 'icon' => 'fa-anchor', 'color' => 'green-400'],
            ['name' => 'Davao Oriental Electric Coop (DORECO)', 'phone' => '082-824-9000', 'category' => 'Utilities', 'icon' => 'fa-bolt', 'color' => 'yellow-500'],
            ['name' => 'Mati Water District (MWD)', 'phone' => '082-825-1000', 'category' => 'Utilities', 'icon' => 'fa-faucet-drip', 'color' => 'sky-500'],
            ['name' => 'Mati City Hall Information Desk', 'phone' => '082-820-2020', 'category' => 'LGU / City Offices', 'icon' => 'fa-city', 'color' => 'purple-500'],
        ];
    }

    // Normalize categories
    $categories = array_values(array_unique(array_map(function($h){ return $h['category'] ?? ''; }, $hotlines)));
?>

<style>
    /* Custom style for the active filter button */
    .filter-btn-active {
        background: linear-gradient(to right, #DC2626, #B91C1C); /* Red 600 to Red 700 */
        color: white !important;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
    }

    /* Guide Card Styling for Hover Effect */
    .hotline-card {
        transition: all 0.3s ease;
        border: 2px solid #333; /* Default dark border */
        background-color: #1a1a1a; /* Darker background for card */
    }
    .hotline-card:hover {
        transform: translateY(-5px);
        /* Red glow effect on hover */
        box-shadow: 0 0 25px rgba(239, 68, 68, 0.4); 
        border-color: #EF4444; /* red-500 */
        cursor: default;
    }
    
    /* CTA Section Background Style */
    .cta-background {
        background: linear-gradient(90deg, #DC2626, #B91C1C); /* Red 600 to Red 700 */
        box-shadow: 0 -10px 20px rgba(0,0,0,0.5);
    }
</style>

<div class="space-y-16 py-16">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- 1️⃣ Hero / Intro Section -->
        <section class="mb-12">
            <br><br>

            <div class="max-w-8xl">

                <h1 class="text-5xl sm:text-6xl font-extrabold leading-tight text-white mb-4">
                    Emergency Hotlines <span class="text-red-400">at Your Fingertips.</span>
                </h1>
                <p class="text-xl text-gray-300">
                    Find contact numbers for critical services and local agencies across Mati City. Search or filter by category for the quickest access.
                </p>
            </div>
        </section>

        <!-- 2️⃣ Search and Filter Section -->
        <section class="p-6 bg-gray-900 rounded-xl shadow-2xl mb-12">
            <h2 class="text-2xl font-bold text-white mb-4">Find a Hotline</h2>
            
            <!-- Search Bar -->
            <div class="relative mb-6">
                <input 
                    type="text" 
                    id="search-input" 
                    placeholder="Search for hotline (e.g., police, fire, hospital, 911)" 
                    class="w-full p-4 pl-12 text-lg rounded-xl bg-gray-800 text-white border-2 border-gray-700 focus:border-red-500 focus:ring-red-500 shadow-lg transition duration-200"
                >
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            
            <!-- Filter Buttons -->
            <div id="filter-container" class="flex flex-wrap gap-3">
                <button data-category="All" class="filter-btn filter-btn-active px-4 py-2 text-sm font-semibold rounded-full bg-gray-700 text-gray-300 hover:bg-red-700 hover:text-white transition duration-200 shadow-md">
                    All Categories
                </button>
                <?php foreach ($categories as $category): ?>
                    <button data-category="<?= htmlspecialchars($category) ?>" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full bg-gray-700 text-gray-300 hover:bg-red-700 hover:text-white transition duration-200 shadow-md">
                        <?= htmlspecialchars($category) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 3️⃣ Hotline List Section -->
        <section>
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-8 border-b border-red-700/50 pb-2">All Emergency Contacts</h2>
            
            <div id="hotline-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <?php 
                    // Generate Hotline Cards from PHP data
                    foreach ($hotlines as $index => $line) {
                        $line_category = htmlspecialchars($line['category']);
                        $line_name = htmlspecialchars($line['name']);
                        $line_number = htmlspecialchars($line['phone'] ?? ($line['number'] ?? ''));
                        $line_icon = htmlspecialchars($line['icon']);
                        $line_color = htmlspecialchars($line['color']);
                ?>
                    <div 
                        class="hotline-card p-6 rounded-xl shadow-xl"
                        data-name="<?= strtolower($line_name) ?>"
                        data-number="<?= $line_number ?>"
                        data-category="<?= $line_category ?>"
                    >
                        <div class="flex items-start justify-between">
                           
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-700 text-white shadow-md">
                                <?= $line_category ?>
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-white mt-4 mb-2"><?= $line_name ?></h3>
                        
                        <!-- Contact Number (Clickable for Mobile) -->
                        <a href="tel:<?= $line_number ?>" class="text-4xl font-extrabold text-red-400 block tracking-wide hover:text-red-300 transition-colors">
                            <?= $line_number ?>
                        </a>

                        <!-- 4️⃣ Optional: Actionable Features (Copy/Call) -->
                        <div class="mt-4 flex space-x-3">
                            <!-- Copy Button -->
                            <button 
                                class="copy-btn p-2 bg-gray-800 text-gray-300 rounded-full hover:bg-red-600 hover:text-white transition group"
                                data-number="<?= $line_number ?>"
                                aria-label="Copy phone number"
                            >
                                <i class="fa-solid fa-copy"></i>
                                <span class="absolute p-1 bg-gray-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none -mt-10">Copy Number</span>
                            </button>
                            
                            <!-- Call Button (Main Action) -->
                            <a 
                                href="tel:<?= $line_number ?>" 
                                class="p-2 bg-red-700 text-white rounded-full hover:bg-red-800 transition group"
                                aria-label="Call emergency number"
                            >
                                <i class="fa-solid fa-phone"></i>
                                <span class="absolute p-1 bg-gray-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none -mt-10">Call Now</span>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- No Results Message (Hidden by default) -->
            <div id="no-results" class="text-center p-12 bg-gray-900 rounded-xl mt-8 hidden">
                <i class="fa-solid fa-circle-exclamation text-5xl text-red-500 mb-4"></i>
                <p class="text-xl text-gray-300 font-semibold">No hotlines found matching your search and filter criteria.</p>
                <p class="text-gray-400">Please try a different search term or select "All Categories".</p>
            </div>
            
        </section>

    </div>

    <!-- 5️⃣ Call-to-Action Section -->
    <section class="py-16 overflow-hidden">
        <div class="cta-background rounded-xl">
            <div class="max-w-7xl mx-auto p-10 text-center">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
                    Don't just read the numbers, receive alerts in real-time.
                </h2>
                <p class="text-lg text-white/90 mb-8">
                    Stay informed and connected during emergencies. Sign up now for real-time alerts directly from SafeMati.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <button class="w-full sm:w-auto px-8 py-4 bg-white text-red-700 font-bold rounded-lg shadow-xl uppercase text-lg hover:bg-gray-100 transform hover:scale-[1.02] transition duration-300">
                        <a href="signup.php">Sign Up Now</a>
                    </button>
                    <button class="w-full sm:w-auto px-8 py-4 bg-gray-900/50 text-white font-semibold border-2 border-white rounded-lg hover:bg-white/20 transition duration-300 uppercase text-lg">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </section> 

</div>

<script>
    // --- JavaScript for Search and Filter Functionality ---

    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const hotlineCards = document.querySelectorAll('.hotline-card');
        const noResultsMessage = document.getElementById('no-results');
        const copyButtons = document.querySelectorAll('.copy-btn');
        let activeCategory = 'All';

        // Helper function to update the visibility of cards based on search and filter
        function filterHotlines() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            hotlineCards.forEach(card => {
                const name = card.dataset.name;
                const number = card.dataset.number;
                const category = card.dataset.category;

                const matchesSearch = (
                    name.includes(searchTerm) || 
                    number.includes(searchTerm) ||
                    category.toLowerCase().includes(searchTerm)
                );

                const matchesCategory = (activeCategory === 'All' || category === activeCategory);

                if (matchesSearch && matchesCategory) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }
        }

        // 1. Search Input Listener
        searchInput.addEventListener('keyup', filterHotlines);

        // 2. Filter Button Listeners
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update active category
                activeCategory = button.dataset.category;
                
                // Update button styles
                filterButtons.forEach(btn => btn.classList.remove('filter-btn-active'));
                button.classList.add('filter-btn-active');
                
                // Re-filter the hotlines
                filterHotlines();
            });
        });

        // 3. Copy Button Functionality
        copyButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const numberToCopy = button.dataset.number;
                
                // Use temporary element for execCommand
                const tempInput = document.createElement('input');
                tempInput.value = numberToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                
                // Optionally provide feedback (e.g., change icon temporarily)
                const icon = button.querySelector('i');
                const originalIconClass = icon.className;
                icon.className = 'fa-solid fa-check text-green-400';
                
                // Restore original icon after a short delay
                setTimeout(() => {
                    icon.className = originalIconClass;
                }, 1000);
            });
        });

        // Initial filter on load
        filterHotlines();
    });
</script>

<?php 
    include 'footer.php'; 
?>