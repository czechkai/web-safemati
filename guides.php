<?php 
    include 'header.php'; 
?>

<style>
    /* Guide Card Styling for Hover Effect */
    .guide-card {
        transition: all 0.3s ease;
        border: 2px solid #333; /* Default dark border */
    }
    .guide-card:hover {
        transform: translateY(-8px);
        /* Red glow effect on hover */
        box-shadow: 0 0 25px rgba(239, 68, 68, 0.4); 
        border-color: #EF4444; /* red-500 */
        cursor: pointer;
    }

    /* CTA Section Background Style */
    .cta-background {
        background: linear-gradient(90deg, #DC2626, #B91C1C); /* Red 600 to Red 700 */
        box-shadow: 0 -10px 20px rgba(0,0,0,0.5);
    }
    
    /* Resource Card within Sidebar */
    .resource-link {
        transition: background-color 0.2s ease;
    }
    .resource-link:hover {
        background-color: rgba(0, 0, 0, 0.2); /* Darker overlay on hover */
    }
</style>

<div class="space-y-16">
    
    <!-- 1️⃣ Main Content: Introduction, Guides Grid, and Sidebar (Combined Section) -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            
            <!-- NEW: Page Introduction Text (Replaces Hero Banner) -->
            <div class="max-w-4xl mx-auto text-center mb-16 pt-8"><br>
                <!-- <i class="fa-solid fa-book-open-reader text-6xl text-red-500 mb-4"></i> -->
                <h1 class="text-5xl sm:text-6xl font-extrabold leading-tight text-white mb-4">
                    Learn How to <span class="text-red-400">Stay Safe</span> During Any Disaster.
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Explore practical guides to help you prepare, respond, and recover from natural and man-made hazards in Mati City.
                </p>
            </div>
            
            <!-- Grid container for Main Content (8/12) and Sidebar (4/12) -->
            <div class="lg:grid lg:grid-cols-12 lg:gap-12">
                
                <!-- Main Guides Column (2/3 width on desktop) -->
                <div class="lg:col-span-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-8 border-b border-red-700/50 pb-2">Essential Safety Guides</h2>
                    
                    <!-- Guide Cards (2 columns on medium screens and up) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php
                        // Try to load guides from DB; fallback to static cards if DB unavailable or empty
                        $db_guides = [];
                        try {
                            require_once __DIR__ . '/db.php';
                            if (isset($pdo) && $pdo) {
                                $stmt = $pdo->query("SELECT id, title, slug, content FROM guides WHERE is_published=1 ORDER BY sort_order, created_at DESC LIMIT 100");
                                $db_guides = $stmt->fetchAll();
                            }
                        } catch (Exception $e) {
                            // ignore and fall back to static
                        }

                        if (!empty($db_guides)) {
                            foreach ($db_guides as $g) {
                                $title = htmlspecialchars($g['title']);
                                $slug = htmlspecialchars($g['slug']);
                                $excerpt = htmlspecialchars(mb_strimwidth(strip_tags($g['content']), 0, 220, '...'));
                                $link = 'guide.php?slug=' . urlencode($slug);
                                echo "<div class=\"guide-card p-6 bg-gray-900 rounded-lg shadow-xl hover:shadow-red-800/50\">";
                                echo "<i class=\"fa-solid fa-book-open-reader text-5xl text-red-400 mb-4\"></i>";
                                echo "<h3 class=\"text-2xl font-bold text-white mb-3\">$title</h3>";
                                echo "<p class=\"text-gray-400 mb-5 text-base\">$excerpt</p>";
                                echo "<a href=\"$link\" class=\"inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors\">View Guide <i class=\"fa-solid fa-arrow-right ml-2 text-sm\"></i></a>";
                                echo "</div>";
                            }
                        } else {
                            // Fallback static cards (original content)
                        ?>

                        <!-- Guide Card 1: Flood -->
                        <div class="guide-card p-6 bg-gray-900 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-water text-5xl text-blue-400 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Flood Safety Guide</h3>
                            <p class="text-gray-400 mb-5 text-base">Learn how to prepare your home and family, navigate high-water situations, and what to do after the water recedes.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                View Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <!-- Guide Card 2: Fire -->
                        <div class="guide-card p-6 bg-gray-900 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-fire text-5xl text-orange-500 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Fire Prevention & Response</h3>
                            <p class="text-gray-400 mb-5 text-base">Essential tips for preventing residential fires and a step-by-step guide for safe evacuation and emergency calls.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                View Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <!-- Guide Card 3: Earthquake -->
                        <div class="guide-card p-6 bg-gray-900 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-house-crack text-5xl text-yellow-500 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Earthquake Preparedness</h3>
                            <p class="text-gray-400 mb-5 text-base">The critical 'Drop, Cover, and Hold On' protocol, what to do before, during, and immediately after a tremor hits.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                View Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <!-- Guide Card 4: Typhoon -->
                        <div class="guide-card p-6 bg-gray-900 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-wind text-5xl text-sky-400 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Typhoon & Storm Guide</h3>
                            <p class="text-gray-400 mb-5 text-base">Understanding PAGASA storm signals, securing your property, and finding the nearest evacuation centers in Mati.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                View Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                        
                        <!-- Guide Card 5: Landslide -->
                        <div class="guide-card p-6 bg-gray-900 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-hill-avalanche text-5xl text-gray-500 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Landslide Awareness</h3>
                            <p class="text-gray-400 mb-5 text-base">Identifying warning signs in unstable slopes and hillsides, and the immediate evacuation procedures to follow.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                View Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <!-- Guide Card 6: Tsunami -->
                        <div class="guide-card p-6 bg-gray-900 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-wave-square text-5xl text-teal-400 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Tsunami Evacuation</h3>
                            <p class="text-gray-400 mb-5 text-base">Specific guidance for coastal barangays on recognizing natural warnings and moving to designated high ground.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                View Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <?php } // end fallback static ?>
                    </div>
                </div>

                <!-- Sidebar Column (1/3 width on desktop) -->
                <div class="lg:col-span-4 mt-12 lg:mt-0">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-8 border-b border-red-700/50 pb-2">Other Resources</h2>
                    
                    <!-- Resource Sidebar Block -->
                    <div class="p-6 bg-red-800 rounded-xl shadow-2xl space-y-4">
                        <p class="text-lg font-semibold text-white mb-4 border-b border-white/50 pb-2">Downloadable Checklists (PDF)</p>
                        
                        <!-- Resource 1: Emergency Kit Checklist -->
                        <a href="#" class="resource-link flex items-center p-3 rounded-lg bg-red-700 hover:bg-red-900 transition-colors">
                            <i class="fa-solid fa-kit-medical text-3xl text-white mr-4 flex-shrink-0"></i>
                            <div class="flex-grow">
                                <p class="text-white font-medium">Emergency Kit Checklist</p>
                                <p class="text-red-200 text-sm">Must-have items for your go-bag</p>
                            </div>
                            <i class="fa-solid fa-download text-xl text-white ml-4 flex-shrink-0"></i>
                        </a>

                        <!-- Resource 2: Evacuation Route Map -->
                        <a href="#" class="resource-link flex items-center p-3 rounded-lg bg-red-700 hover:bg-red-900 transition-colors">
                            <i class="fa-solid fa-map-location-dot text-3xl text-white mr-4 flex-shrink-0"></i>
                            <div class="flex-grow">
                                <p class="text-white font-medium">Mati City Evacuation Routes</p>
                                <p class="text-red-200 text-sm">Printable map of local safe zones</p>
                            </div>
                            <i class="fa-solid fa-download text-xl text-white ml-4 flex-shrink-0"></i>
                        </a>
                        
                        <!-- Resource 3: Family Communication Plan -->
                        <a href="#" class="resource-link flex items-center p-3 rounded-lg bg-red-700 hover:bg-red-900 transition-colors">
                            <i class="fa-solid fa-users-viewfinder text-3xl text-white mr-4 flex-shrink-0"></i>
                            <div class="flex-grow">
                                <p class="text-white font-medium">Family Communication Plan</p>
                                <p class="text-red-200 text-sm">Worksheet for emergency contacts</p>
                            </div>
                            <i class="fa-solid fa-download text-xl text-white ml-4 flex-shrink-0"></i>
                        </a>

                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- 2️⃣ Call-to-Action Section -->
    <section class="py-16 overflow-hidden">
        <div class="cta-background rounded-xl">
            <div class="max-w-7xl mx-auto p-10 text-center">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
                    Don't just read about safety, receive it in real-time.
                </h2>
                <p class="text-lg text-white/90 mb-8">
                    Get real-time alerts and stay prepared with SafeMati. Sign up now to receive notifications directly from Mati City’s emergency systems.
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

</main> <!-- The closing tag for the <main> element opened in header.php -->

<?php 
    include 'footer.php'; 
?>