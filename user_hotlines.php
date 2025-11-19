<?php 
    include 'user_header.php';
    require_once 'db_connect.php';
    
    $user_id = $_SESSION['user_id'];
    
    // Get user's favorited hotlines
    $favorites_query = "SELECT hotline_id FROM user_favorite_hotlines WHERE user_id = ?";
    $favorites_stmt = $conn->prepare($favorites_query);
    $favorites_stmt->bind_param("i", $user_id);
    $favorites_stmt->execute();
    $favorites_result = $favorites_stmt->get_result();
    $user_favorites = array();
    while ($row = $favorites_result->fetch_assoc()) {
        $user_favorites[] = $row['hotline_id'];
    }
    $favorites_stmt->close();

    // --- Hotline Data Structure ---
    $hotlines = array(
        // Police
        array('id' => 1, 'name' => 'Mati City Police Station', 'number' => '911', 'category' => 'Police', 'icon' => 'fa-shield-halved', 'color' => 'blue-500'),
        array('id' => 2, 'name' => 'Mati Traffic Management', 'number' => '082-822-1234', 'category' => 'Police', 'icon' => 'fa-car-side', 'color' => 'blue-400'),
        // Fire
        array('id' => 3, 'name' => 'Bureau of Fire Protection - Mati', 'number' => '160', 'category' => 'Fire', 'icon' => 'fa-fire-extinguisher', 'color' => 'orange-500'),
        // Medical
        array('id' => 4, 'name' => 'Mati Doctors Hospital', 'number' => '082-823-5678', 'category' => 'Medical', 'icon' => 'fa-kit-medical', 'color' => 'red-500'),
        array('id' => 5, 'name' => 'Provincial Health Office', 'number' => '082-823-8765', 'category' => 'Medical', 'icon' => 'fa-stethoscope', 'color' => 'red-400'),
        // Rescue
        array('id' => 6, 'name' => 'Mati CDRRMO (Disaster Office)', 'number' => '911', 'category' => 'Rescue', 'icon' => 'fa-life-ring', 'color' => 'green-500'),
        array('id' => 7, 'name' => 'Philippine Coast Guard - Mati', 'number' => '082-821-1122', 'category' => 'Rescue', 'icon' => 'fa-anchor', 'color' => 'green-400'),
        // Utilities
        array('id' => 8, 'name' => 'Davao Oriental Electric Coop (DORECO)', 'number' => '082-824-9000', 'category' => 'Utilities', 'icon' => 'fa-bolt', 'color' => 'yellow-500'),
        array('id' => 9, 'name' => 'Mati Water District (MWD)', 'number' => '082-825-1000', 'category' => 'Utilities', 'icon' => 'fa-faucet-drip', 'color' => 'sky-500'),
        // LGU
        array('id' => 10, 'name' => 'Mati City Hall Information Desk', 'number' => '082-820-2020', 'category' => 'LGU / City Offices', 'icon' => 'fa-city', 'color' => 'purple-500'),
    );

    $categories = array_unique(array_column($hotlines, 'category'));
    $favorites = array_filter($hotlines, function($h) use ($user_favorites) { return in_array($h['id'], $user_favorites); });
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
            <div id="favorites-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php foreach ($favorites as $fav): ?>
                <div class="favorite-card p-4 bg-gray-700 rounded-lg flex items-center justify-between" data-hotline-id="<?php echo $fav['id']; ?>">
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
        <?php else: ?>
        <section id="no-favorites-section" class="p-8 bg-gradient-to-br from-gray-800 to-gray-900 border-2 border-gray-700 rounded-xl shadow-2xl mb-12 text-center">
            <i class="fa-solid fa-star text-5xl text-gray-600 mb-4"></i>
            <h2 class="text-xl font-bold text-white mb-2">No Favorite Hotlines Yet</h2>
            <p class="text-gray-400">Click the star icon on any hotline card below to add it to your favorites</p>
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
                    foreach ($hotlines as $line) {
                        $line_id = $line['id'];
                        $line_category = htmlspecialchars($line['category']);
                        $line_name = htmlspecialchars($line['name']);
                        $line_number = htmlspecialchars($line['number']);
                        $line_icon = htmlspecialchars($line['icon']);
                        $line_color = htmlspecialchars($line['color']);
                        $is_favorite = in_array($line_id, $user_favorites);
                ?>
                    <div 
                        class="hotline-card p-6 rounded-xl shadow-xl flex flex-col"
                        data-name="<?= strtolower($line_name) ?>"
                        data-number="<?= $line_number ?>"
                        data-category="<?= $line_category ?>"
                        data-hotline-id="<?= $line_id ?>"
                    >
                        <div class="flex items-start justify-between mb-4">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-600 text-white shadow-md">
                                <?= $line_category ?>
                            </span>
                            <!-- Favorite Star Button -->
                            <button class="favorite-btn text-2xl <?php echo $is_favorite ? 'active' : 'text-gray-500'; ?>" 
                                    data-hotline-id="<?= $line_id ?>"
                                    aria-label="Toggle favorite">
                                <i class="fa-solid fa-star"></i>
                            </button>
                        </div>
                        
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-white mb-2"><?= $line_name ?></h3>
                            
                            <!-- Contact Number (Clickable for Mobile) -->
                            <a href="tel:<?= $line_number ?>" class="text-4xl font-extrabold text-red-400 block tracking-wide hover:text-red-300 transition-colors mb-4">
                                <?= $line_number ?>
                            </a>
                        </div>

                        <!-- Action Buttons - Always at bottom -->
                        <div class="mt-auto flex space-x-3">
                            <!-- Copy Button -->
                            <button 
                                class="copy-btn flex-1 p-3 bg-gray-700 text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition font-semibold flex items-center justify-center"
                                data-number="<?= $line_number ?>"
                                aria-label="Copy phone number"
                            >
                                <i class="fa-solid fa-copy mr-2"></i>Copy
                            </button>
                            
                            <!-- Call Button (Main Action) -->
                            <a 
                                href="tel:<?= $line_number ?>" 
                                class="flex-1 p-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-center font-semibold flex items-center justify-center"
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

        // Favorite Button Functionality with Real-Time Updates
        favoriteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const hotlineId = this.dataset.hotlineId;
                const hotlineCard = this.closest('.hotline-card');
                const hotlineName = hotlineCard.querySelector('h3').textContent;
                const hotlineNumber = hotlineCard.dataset.number;
                
                const formData = new FormData();
                formData.append('hotline_id', hotlineId);
                
                fetch('ajax/toggle_favorite.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Toggle visual state
                        this.classList.toggle('active');
                        
                        // Animation feedback
                        this.style.transform = 'scale(1.3)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 200);
                        
                        // Update favorites section
                        updateFavoritesSection();
                        
                        // Show toast notification
                        showToast(data.message, 'success');
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error updating favorite', 'error');
                });
            });
        });
        
        // Update favorites section dynamically
        function updateFavoritesSection() {
            // Collect all favorited hotlines
            const favoritedCards = document.querySelectorAll('.hotline-card');
            const favorites = [];
            
            favoritedCards.forEach(card => {
                const starBtn = card.querySelector('.favorite-btn');
                if (starBtn && starBtn.classList.contains('active')) {
                    const hotlineId = card.dataset.hotlineId;
                    const hotlineName = card.querySelector('h3').textContent;
                    const hotlineNumber = card.dataset.number;
                    favorites.push({ id: hotlineId, name: hotlineName, number: hotlineNumber });
                }
            });
            
            // Update or create favorites section
            let favSection = document.querySelector('#favorites-container');
            let noFavSection = document.querySelector('#no-favorites-section');
            
            if (favorites.length > 0) {
                // Hide no-favorites message
                if (noFavSection) {
                    noFavSection.style.display = 'none';
                }
                
                // Create favorites section if it doesn't exist
                if (!favSection) {
                    const searchSection = document.querySelector('section.p-6.bg-gray-800');
                    const newSection = document.createElement('section');
                    newSection.className = 'p-6 bg-gradient-to-br from-gray-800 to-gray-900 border-2 border-red-500 rounded-xl shadow-2xl mb-12';
                    newSection.innerHTML = `
                        <h2 class="text-2xl font-bold text-white mb-4">
                            <i class="fa-solid fa-star text-yellow-300 mr-2"></i>
                            Your Favorite Hotlines
                        </h2>
                        <div id="favorites-container" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
                    `;
                    searchSection.parentNode.insertBefore(newSection, searchSection);
                    favSection = document.querySelector('#favorites-container');
                }
                
                // Update favorites list
                favSection.innerHTML = favorites.map(fav => `
                    <div class="favorite-card p-4 bg-gray-700 rounded-lg flex items-center justify-between" data-hotline-id="${fav.id}">
                        <div>
                            <p class="text-white font-semibold text-sm">${fav.name}</p>
                            <a href="tel:${fav.number}" class="text-2xl font-bold text-red-400 hover:text-red-300">
                                ${fav.number}
                            </a>
                        </div>
                        <a href="tel:${fav.number}" class="p-3 bg-red-600 hover:bg-red-700 rounded-full transition">
                            <i class="fa-solid fa-phone text-white"></i>
                        </a>
                    </div>
                `).join('');
                
                // Show favorites section
                if (favSection.parentElement) {
                    favSection.parentElement.style.display = 'block';
                }
            } else {
                // Show no-favorites message
                if (favSection && favSection.parentElement) {
                    favSection.parentElement.style.display = 'none';
                }
                if (noFavSection) {
                    noFavSection.style.display = 'block';
                }
            }
        }
        
        // Toast notification function
        function showToast(message, type = 'success') {
            const bgColor = type === 'success' ? 'bg-green-600' : 'bg-red-600';
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            const toast = document.createElement('div');
            toast.className = `fixed top-24 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-2xl z-50 transform transition-all duration-300 translate-x-full`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fa-solid fa-${icon} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.classList.remove('translate-x-full'), 100);
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Initial filter
        filterHotlines();
    });
</script>

<?php 
    include 'user_footer.php'; 
?>
