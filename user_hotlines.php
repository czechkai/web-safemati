<?php 
    include 'user_header.php'; 

    // --- Hotline Data Structure ---
    $hotlines = [
        // Police
        ['name' => 'Mati City Police Station', 'number' => '911', 'category' => 'Police', 'icon' => 'fa-shield-halved', 'color' => 'blue-500', 'is_favorite' => true],
        ['name' => 'Mati Traffic Management', 'number' => '082-822-1234', 'category' => 'Police', 'icon' => 'fa-car-side', 'color' => 'blue-400', 'is_favorite' => false],
        // Fire
        ['name' => 'Bureau of Fire Protection - Mati', 'number' => '160', 'category' => 'Fire', 'icon' => 'fa-fire-extinguisher', 'color' => 'orange-500', 'is_favorite' => true],
        // Medical
        ['name' => 'Mati Doctors Hospital', 'number' => '082-823-5678', 'category' => 'Medical', 'icon' => 'fa-kit-medical', 'color' => 'red-500', 'is_favorite' => true],
        ['name' => 'Provincial Health Office', 'number' => '082-823-8765', 'category' => 'Medical', 'icon' => 'fa-stethoscope', 'color' => 'red-400', 'is_favorite' => false],
        // Rescue
        ['name' => 'Mati CDRRMO (Disaster Office)', 'number' => '911', 'category' => 'Rescue', 'icon' => 'fa-life-ring', 'color' => 'green-500', 'is_favorite' => false],
        ['name' => 'Philippine Coast Guard - Mati', 'number' => '082-821-1122', 'category' => 'Rescue', 'icon' => 'fa-anchor', 'color' => 'green-400', 'is_favorite' => false],
        // Utilities
        ['name' => 'Davao Oriental Electric Coop (DORECO)', 'number' => '082-824-9000', 'category' => 'Utilities', 'icon' => 'fa-bolt', 'color' => 'yellow-500', 'is_favorite' => false],
        ['name' => 'Mati Water District (MWD)', 'number' => '082-825-1000', 'category' => 'Utilities', 'icon' => 'fa-faucet-drip', 'color' => 'sky-500', 'is_favorite' => false],
        // LGU
        ['name' => 'Mati City Hall Information Desk', 'number' => '082-820-2020', 'category' => 'LGU / City Offices', 'icon' => 'fa-city', 'color' => 'purple-500', 'is_favorite' => false],
    ];

    $categories = array_unique(array_column($hotlines, 'category'));
    $favorites = array_filter($hotlines, function($h) { return $h['is_favorite']; });
?>

<style>
    /* Custom style for the active filter button */
    .filter-btn-active {
        background: linear-gradient(to right, #EF4444, #DC2626); /* Red 500 to Red 600 */
        color: white !important;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.5);
    }

    /* Hotline Card Styling */
    .hotline-card {
        transition: all 0.3s ease;
        border: 2px solid #374151; /* gray-700 */
        background-color: #1f2937; /* gray-800 */
    }
    .hotline-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 25px rgba(239, 68, 68, 0.5); 
        border-color: #EF4444; /* red-500 */
        cursor: default;
    }

    /* User Badge Animation */
    .user-badge {
        display: inline-block;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .7; }
    }

    /* Favorite star animation */
    .favorite-btn {
        transition: all 0.2s ease;
    }
    .favorite-btn:hover {
        transform: scale(1.2);
    }
    .favorite-btn.active {
        color: #FCD34D !important; /* yellow-300 */
        filter: drop-shadow(0 0 8px rgba(252, 211, 77, 0.6));
    }
</style>

<div class="pt-24 pb-16 space-y-16">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Hero / Intro Section with User Badge -->
        <section class="mb-12">
            <!-- <span class="user-badge text-white mb-4">Quick Access Dashboard</span> -->
            <div class="max-w-8xl mt-4">
                <h1 class="text-5xl sm:text-6xl font-extrabold leading-tight text-white mb-4">
                    Emergency Hotlines <span class="text-red-500">at Your Fingertips.</span>
                </h1>
                <p class="text-xl text-gray-300">
                    Save favorites, call directly, and access critical contacts for <?php echo htmlspecialchars($_SESSION['user_barangay'] ?? 'Mati City'); ?> services.
                </p>
            </div>
        </section>

        <!-- User-Specific Feature: Favorite Hotlines -->
        <?php if (count($favorites) > 0): ?>
        <section class="p-6 bg-gradient-to-br from-gray-800 to-gray-900 border-2 border-red-500 rounded-xl shadow-2xl mb-12">
            <h2 class="text-2xl font-bold text-white mb-4">
                <i class="fa-solid fa-star text-yellow-300 mr-2"></i>
                Your Favorite Hotlines
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php foreach ($favorites as $fav): ?>
                <div class="p-4 bg-gray-700 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="text-white font-semibold text-sm"><?php echo htmlspecialchars($fav['name']); ?></p>
                        <a href="tel:<?php echo htmlspecialchars($fav['number']); ?>" class="text-2xl font-bold text-red-400 hover:text-red-300">
                            <?php echo htmlspecialchars($fav['number']); ?>
                        </a>
                    </div>
                    <a href="tel:<?php echo htmlspecialchars($fav['number']); ?>" class="p-3 bg-red-600 hover:bg-red-700 rounded-full transition">
                        <i class="fa-solid fa-phone text-white"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Search and Filter Section -->
        <section class="p-6 bg-gray-800 border-2 border-gray-700 rounded-xl shadow-2xl mb-12">
            <h2 class="text-2xl font-bold text-white mb-4">
                <i class="fa-solid fa-magnifying-glass mr-2 text-red-500"></i>
                Find a Hotline
            </h2>
            
            <!-- Search Bar -->
            <div class="relative mb-6">
                <input 
                    type="text" 
                    id="search-input" 
                    placeholder="Search for hotline (e.g., police, fire, hospital, 911)" 
                    class="w-full p-4 pl-12 text-lg rounded-xl bg-gray-700 text-white border-2 border-gray-600 focus:border-red-500 focus:ring-red-500 shadow-lg transition duration-200"
                >
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            
            <!-- Filter Buttons -->
            <div id="filter-container" class="flex flex-wrap gap-3">
                <button data-category="All" class="filter-btn filter-btn-active px-4 py-2 text-sm font-semibold rounded-full bg-gray-700 text-gray-300 hover:bg-red-600 hover:text-white transition duration-200 shadow-md">
                    All Categories
                </button>
                <?php foreach ($categories as $category): ?>
                    <button data-category="<?= htmlspecialchars($category) ?>" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full bg-gray-700 text-gray-300 hover:bg-red-600 hover:text-white transition duration-200 shadow-md">
                        <?= htmlspecialchars($category) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Hotline List Section -->
        <section>
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-8 border-b border-red-500 pb-2">All Emergency Contacts</h2>
            
            <div id="hotline-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <?php 
                    foreach ($hotlines as $index => $line) {
                        $line_category = htmlspecialchars($line['category']);
                        $line_name = htmlspecialchars($line['name']);
                        $line_number = htmlspecialchars($line['number']);
                        $line_icon = htmlspecialchars($line['icon']);
                        $line_color = htmlspecialchars($line['color']);
                        $is_favorite = $line['is_favorite'];
                ?>
                    <div 
                        class="hotline-card p-6 rounded-xl shadow-xl"
                        data-name="<?= strtolower($line_name) ?>"
                        data-number="<?= $line_number ?>"
                        data-category="<?= $line_category ?>"
                    >
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-600 text-white shadow-md">
                                <?= $line_category ?>
                            </span>
                            <!-- Favorite Star Button -->
                            <button class="favorite-btn text-2xl <?php echo $is_favorite ? 'active' : 'text-gray-500'; ?>" 
                                    data-hotline-id="<?= $index ?>"
                                    aria-label="Toggle favorite">
                                <i class="fa-solid fa-star"></i>
                            </button>
                        </div>
                        
                        <h3 class="text-xl font-bold text-white mt-4 mb-2"><?= $line_name ?></h3>
                        
                        <!-- Contact Number (Clickable for Mobile) -->
                        <a href="tel:<?= $line_number ?>" class="text-4xl font-extrabold text-red-400 block tracking-wide hover:text-red-300 transition-colors">
                            <?= $line_number ?>
                        </a>

                        <!-- Action Buttons -->
                        <div class="mt-4 flex space-x-3">
                            <!-- Copy Button -->
                            <button 
                                class="copy-btn flex-1 p-3 bg-gray-700 text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition font-semibold"
                                data-number="<?= $line_number ?>"
                                aria-label="Copy phone number"
                            >
                                <i class="fa-solid fa-copy mr-2"></i>Copy
                            </button>
                            
                            <!-- Call Button (Main Action) -->
                            <a 
                                href="tel:<?= $line_number ?>" 
                                class="flex-1 p-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-center font-semibold"
                                aria-label="Call emergency number"
                            >
                                <i class="fa-solid fa-phone mr-2"></i>Call Now
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="text-center p-12 bg-gray-800 border-2 border-gray-700 rounded-xl mt-8 hidden">
                <i class="fa-solid fa-circle-exclamation text-5xl text-red-500 mb-4"></i>
                <p class="text-xl text-gray-300 font-semibold">No hotlines found matching your search and filter criteria.</p>
                <p class="text-gray-400">Please try a different search term or select "All Categories".</p>
            </div>
            
        </section>

    </div>
</div>

<script>
    // --- JavaScript for Search, Filter, and Favorites ---

    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const hotlineCards = document.querySelectorAll('.hotline-card');
        const noResultsMessage = document.getElementById('no-results');
        const copyButtons = document.querySelectorAll('.copy-btn');
        const favoriteButtons = document.querySelectorAll('.favorite-btn');
        let activeCategory = 'All';

        // Filter hotlines function
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
            noResultsMessage.classList.toggle('hidden', visibleCount > 0);
        }

        // Search Input Listener
        searchInput.addEventListener('keyup', filterHotlines);

        // Filter Button Listeners
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                activeCategory = button.dataset.category;
                filterButtons.forEach(btn => btn.classList.remove('filter-btn-active'));
                button.classList.add('filter-btn-active');
                filterHotlines();
            });
        });

        // Copy Button Functionality
        copyButtons.forEach(button => {
            button.addEventListener('click', () => {
                const numberToCopy = button.dataset.number;
                navigator.clipboard.writeText(numberToCopy).then(() => {
                    const icon = button.querySelector('i');
                    const originalClass = icon.className;
                    icon.className = 'fa-solid fa-check text-green-400';
                    
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 1500);
                });
            });
        });

        // Favorite Button Functionality
        favoriteButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('active');
                const hotlineId = button.dataset.hotlineId;
                
                // Here you would send an AJAX request to save favorite status
                console.log(`Toggle favorite for hotline ID: ${hotlineId}`);
                
                // Optional: Show feedback
                const isFavorite = button.classList.contains('active');
                button.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 200);
            });
        });

        // Initial filter
        filterHotlines();
    });
</script>

<?php 
    include 'user_footer.php'; 
?>
