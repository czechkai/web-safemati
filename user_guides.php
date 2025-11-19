<?php 
    include 'user_header.php'; 
?>

<style>
    /* Guide Card Styling for Hover Effect */
    .guide-card {
        transition: all 0.3s ease;
        border: 2px solid #374151; /* gray-700 border */
        background-color: #1f2937; /* gray-800 */
    }
    .guide-card:hover {
        transform: translateY(-8px);
        /* Red glow effect on hover */
        box-shadow: 0 0 25px rgba(239, 68, 68, 0.5); 
        border-color: #EF4444; /* red-500 */
        cursor: pointer;
    }
    
    /* Resource Card within Sidebar */
    .resource-link {
        transition: background-color 0.2s ease;
    }
    .resource-link:hover {
        background-color: rgba(0, 0, 0, 0.3); /* Darker overlay on hover */
    }

    /* Badge for User-specific feature */
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
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .7;
        }
    }

    /* Progress tracker styling */
    .progress-tracker {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border: 2px solid #374151;
    }
</style>

<div class="pt-24 pb-16 space-y-16">
    
    <!-- Main Content Section -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            
            <!-- Page Introduction with User Badge -->
            <div class="max-w-4xl mx-auto text-center mb-16">
                <!-- <span class="user-badge text-white mb-4">Personalized for You</span> -->
                <h1 class="text-5xl sm:text-6xl font-extrabold leading-tight text-white mb-4 mt-4">
                    Learn How to <span class="text-red-500">Stay Safe</span> During Any Disaster.
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Track your progress through essential safety guides tailored for <?php echo htmlspecialchars($_SESSION['user_barangay'] ?? 'Mati City'); ?> residents.
                </p>
            </div>

            <!-- User-Specific Feature: Progress Tracker -->
            <div class="progress-tracker p-6 rounded-xl shadow-2xl mb-12">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fa-solid fa-chart-line text-red-500 mr-2"></i>
                        Your Safety Preparedness
                    </h3>
                    <span class="text-2xl font-extrabold text-red-500">3/6</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3 mb-2">
                    <div class="bg-gradient-to-r from-red-600 to-red-500 h-3 rounded-full" style="width: 50%"></div>
                </div>
                <p class="text-sm text-gray-400">You've completed 3 out of 6 essential guides. Keep learning!</p>
            </div>
            
            <!-- Grid container for Main Content and Sidebar -->
            <div class="lg:grid lg:grid-cols-12 lg:gap-12">
                
                <!-- Main Guides Column -->
                <div class="lg:col-span-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-8 border-b border-red-500 pb-2">Essential Safety Guides</h2>
                    
                    <!-- Guide Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Guide Card 1: Flood - COMPLETED -->
                        <div class="guide-card p-6 rounded-lg shadow-xl hover:shadow-red-800/50 relative">
                            <div class="absolute top-4 right-4">
                                <i class="fa-solid fa-circle-check text-3xl text-green-500"></i>
                            </div>
                            <i class="fa-solid fa-water text-5xl text-blue-400 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Flood Safety Guide</h3>
                            <p class="text-gray-400 mb-5 text-base">Learn how to prepare your home and family, navigate high-water situations, and what to do after the water recedes.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                Review Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <!-- Guide Card 2: Fire - COMPLETED -->
                        <div class="guide-card p-6 rounded-lg shadow-xl hover:shadow-red-800/50 relative">
                            <div class="absolute top-4 right-4">
                                <i class="fa-solid fa-circle-check text-3xl text-green-500"></i>
                            </div>
                            <i class="fa-solid fa-fire text-5xl text-orange-500 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Fire Prevention & Response</h3>
                            <p class="text-gray-400 mb-5 text-base">Essential tips for preventing residential fires and a step-by-step guide for safe evacuation and emergency calls.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                Review Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                        
                        <!-- Guide Card 3: Earthquake - COMPLETED -->
                        <div class="guide-card p-6 rounded-lg shadow-xl hover:shadow-red-800/50 relative">
                            <div class="absolute top-4 right-4">
                                <i class="fa-solid fa-circle-check text-3xl text-green-500"></i>
                            </div>
                            <i class="fa-solid fa-house-crack text-5xl text-yellow-500 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Earthquake Preparedness</h3>
                            <p class="text-gray-400 mb-5 text-base">The critical 'Drop, Cover, and Hold On' protocol, what to do before, during, and immediately after a tremor hits.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                Review Guide <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <!-- Guide Card 4: Typhoon - NOT COMPLETED -->
                        <div class="guide-card p-6 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-wind text-5xl text-sky-400 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Typhoon & Storm Guide</h3>
                            <p class="text-gray-400 mb-5 text-base">Understanding PAGASA storm signals, securing your property, and finding the nearest evacuation centers in Mati.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                Start Learning <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                        
                        <!-- Guide Card 5: Landslide - NOT COMPLETED -->
                        <div class="guide-card p-6 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-hill-avalanche text-5xl text-gray-500 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Landslide Awareness</h3>
                            <p class="text-gray-400 mb-5 text-base">Identifying warning signs in unstable slopes and hillsides, and the immediate evacuation procedures to follow.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                Start Learning <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>

                        <!-- Guide Card 6: Tsunami - NOT COMPLETED -->
                        <div class="guide-card p-6 rounded-lg shadow-xl hover:shadow-red-800/50">
                            <i class="fa-solid fa-wave-square text-5xl text-teal-400 mb-4"></i>
                            <h3 class="text-2xl font-bold text-white mb-3">Tsunami Evacuation</h3>
                            <p class="text-gray-400 mb-5 text-base">Specific guidance for coastal barangays on recognizing natural warnings and moving to designated high ground.</p>
                            <a href="#" class="inline-flex items-center text-red-400 font-semibold hover:text-red-300 transition-colors">
                                Start Learning <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                        
                    </div>
                </div>

                <!-- Sidebar Column - User Personalized -->
                <div class="lg:col-span-4 mt-12 lg:mt-0">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-8 border-b border-red-500 pb-2">Your Resources</h2>
                    
                    <!-- Personalized Info Box -->
                    <div class="p-6 bg-gradient-to-br from-red-600 to-red-700 rounded-xl shadow-2xl mb-6">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-map-location-dot text-3xl text-white mr-3"></i>
                            <div>
                                <p class="text-sm text-red-100 font-medium">Your Location</p>
                                <p class="text-lg font-bold text-white"><?php echo htmlspecialchars($_SESSION['user_barangay'] ?? 'Not Set'); ?></p>
                            </div>
                        </div>
                        <p class="text-sm text-red-100">Resources and guides are prioritized based on your barangay.</p>
                    </div>

                    <!-- Resource Sidebar Block -->
                    <div class="p-6 bg-gray-800 border-2 border-gray-700 rounded-xl shadow-2xl space-y-4">
                        <p class="text-lg font-semibold text-white mb-4 border-b border-gray-600 pb-2">
                            <i class="fa-solid fa-download mr-2 text-red-500"></i>
                            Downloadable Checklists
                        </p>
                        
                        <!-- Resource 1: Emergency Kit Checklist -->
                        <a href="#" class="resource-link flex items-center p-3 rounded-lg bg-gray-700 hover:bg-gray-600 transition-colors">
                            <i class="fa-solid fa-kit-medical text-3xl text-red-500 mr-4 flex-shrink-0"></i>
                            <div class="flex-grow">
                                <p class="text-white font-medium">Emergency Kit Checklist</p>
                                <p class="text-gray-400 text-sm">Must-have items for your go-bag</p>
                            </div>
                            <i class="fa-solid fa-download text-xl text-red-500 ml-4 flex-shrink-0"></i>
                        </a>

                        <!-- Resource 2: Evacuation Route Map -->
                        <a href="#" class="resource-link flex items-center p-3 rounded-lg bg-gray-700 hover:bg-gray-600 transition-colors">
                            <i class="fa-solid fa-map-location-dot text-3xl text-red-500 mr-4 flex-shrink-0"></i>
                            <div class="flex-grow">
                                <p class="text-white font-medium"><?php echo htmlspecialchars($_SESSION['user_barangay'] ?? 'Mati'); ?> Evacuation Routes</p>
                                <p class="text-gray-400 text-sm">Printable map of local safe zones</p>
                            </div>
                            <i class="fa-solid fa-download text-xl text-red-500 ml-4 flex-shrink-0"></i>
                        </a>
                        
                        <!-- Resource 3: Family Communication Plan -->
                        <a href="#" class="resource-link flex items-center p-3 rounded-lg bg-gray-700 hover:bg-gray-600 transition-colors">
                            <i class="fa-solid fa-users-viewfinder text-3xl text-red-500 mr-4 flex-shrink-0"></i>
                            <div class="flex-grow">
                                <p class="text-white font-medium">Family Communication Plan</p>
                                <p class="text-gray-400 text-sm">Worksheet for emergency contacts</p>
                            </div>
                            <i class="fa-solid fa-download text-xl text-red-500 ml-4 flex-shrink-0"></i>
                        </a>

                    </div>

                    <!-- Quick Action: Bookmark Feature -->
                    <div class="mt-6 p-4 bg-gray-800 border-2 border-gray-700 rounded-xl">
                        <p class="text-sm text-gray-400 mb-3">
                            <i class="fa-solid fa-bookmark text-red-500 mr-2"></i>
                            Save guides to review later
                        </p>
                        <button class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                            View Bookmarked Guides
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

</div>

<?php 
    include 'user_footer.php'; 
?>
