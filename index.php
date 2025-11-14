<?php 
    // This loads the HTML head, opening body tag, fixed header, and mobile menu script
    include 'header.php'; 
?>

    <!-- Inline styles for page-specific effects like the Hero background animation --><style>
        /* Hero Background with Image */
        .hero-background {
            background-image: url('assets/img-hero-banner.jpg');
            background-size: cover; /* Cover the entire section */
            background-position: center; /* Center the image */
            position: relative; /* Needed for overlay */
            isolation: isolate; /* Creates a new stacking context for children z-index */
        }
        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* RED TINT FIX: Dark Red overlay with reduced opacity (0.4) for visibility */
            background: rgba(0, 0, 0, 0.8); /* Dark Red overlay for text readability, with more transparency */
            z-index: -1; /* Place behind text content */
            border-radius: inherit; /* Inherit border-radius from parent */
        }

        .alert-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .alert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
        }
        
        /* CTA Section Background with Gradient Image */
        .cta-background {
            background-image: url('assets/img-cta-banner.jpg'); /* Use a more abstract red gradient image here */
            background-size: cover;
            background-position: center;
            position: relative;
            isolation: isolate;
        }
        .cta-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(185, 28, 28, 0.7), rgba(220, 38, 38, 0.7)); /* Subtle red gradient overlay */
            z-index: -1;
            border-radius: inherit;
        }
    </style>
<!DOCTYPE html>
<html>
    <body>
        
    
    <!-- 1️⃣ Hero Section -->
    <!-- min-h-screen ensures full viewport height -->
    <section class="hero-background min-h-screen flex items-center justify-center text-center py-20 rounded-xl shadow-2xl">
        <!-- MODIFIED: Changed max-w-4xl to max-w-6xl to use more horizontal space on wide screens -->
        <div class="max-w-6xl px-4 z-0"> <!-- Ensure content is above the overlay -->
            <!-- MODIFIED: Slightly increased font size on large screens (lg:text-7xl) -->
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-tight text-white mb-6">
                Stay Safe. Stay Alert. <span class="text-red-500">Anywhere in Mati City.</span>
            </h1>
            
            <!-- MODIFIED: Increased subtext size on large screens (lg:text-2xl) and increased margin (mb-12) -->
            <p class="text-lg sm:text-xl lg:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto">
                Real-time disaster alerts, emergency hotlines, and guides to protect you and your community.
            </p>
            
            <!-- Updated Call-to-Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <!-- Primary Button: Explore Alerts -->
                <button class="w-full sm:w-auto px-10 py-4 btn-gradient text-white font-bold rounded-lg shadow-xl uppercase text-lg hover:shadow-red-500/50 transition duration-300">
                    <i class="fa-solid fa-bell mr-2"></i> Explore Alerts
                </button>
                
                <!-- Secondary Button: Learn More -->
                <button class="w-full sm:w-auto px-10 py-4 text-red-400 font-semibold border-2 border-red-500 rounded-lg bg-transparent hover:bg-red-900/30 transition duration-300 uppercase text-lg">
                    Learn More
                </button>
            </div>
        </div>
    </section>
    
    <!-- 2️⃣ About SafeMati / Mission Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-10 text-center border-b border-red-700/50 pb-2">What is SafeMati?</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Text Content -->
                <div class="text-lg text-gray-300 space-y-6">
                    <p>SafeMati is Mati City’s dedicated **Disaster Risk Reduction and Alert System**. Our mission is to empower every resident and visitor with the critical information needed to stay safe before, during, and after an emergency.</p>
                    <p>We provide **real-time alerts** sourced from official agencies, maintain **up-to-date emergency hotlines**, and offer **comprehensive preparedness guides** so you can act decisively when seconds count.</p>
                    <p class="text-red-400 font-semibold">We believe a well-informed community is a resilient community.</p>
                </div>

                <!-- Visual Element: Icon Grid - FIXED LAYOUT -->
                <div class="grid grid-cols-3 gap-6 p-6 bg-gray-900 rounded-xl">
                    
                    <!-- Card 1: Real-Time Alerts -->
                    <div class="text-center p-6 bg-gray-800 rounded-xl border border-gray-700 hover:border-red-500 transition duration-300">
                        <i class="fa-solid fa-satellite-dish text-6xl text-red-500 mb-4"></i>
                        <p class="text-base sm:text-lg font-bold text-white leading-snug">Real-Time Alerts</p>
                    </div>

                    <!-- Card 2: 24/7 Hotlines -->
                    <div class="text-center p-6 bg-gray-800 rounded-xl border border-gray-700 hover:border-red-500 transition duration-300">
                        <i class="fa-solid fa-headset text-6xl text-red-500 mb-4"></i>
                        <p class="text-base sm:text-lg font-bold text-white leading-snug">24/7 Hotlines</p>
                    </div>

                    <!-- Card 3: Community Resilience -->
                    <div class="text-center p-6 bg-gray-800 rounded-xl border border-gray-700 hover:border-red-500 transition duration-300">
                        <i class="fa-solid fa-shield-halved text-6xl text-red-500 mb-4"></i>
                        <p class="text-base sm:text-lg font-bold text-white leading-snug">Community Resilience</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3️⃣ Statistics / Numbers Animation Section -->
    <section class="py-16 bg-gray-800 rounded-xl shadow-inner my-12" id="stats-section">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-12">SafeMati Impact in Numbers</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
                
                <!-- Stat Card 1: Alerts Sent -->
                <div class="p-6">
                    <i class="fa-solid fa-cloud-arrow-up text-5xl text-red-500 mb-4"></i>
                    <div data-target="500" class="counter text-6xl font-extrabold text-white mb-2" id="stat1">0</div>
                    <p class="text-red-400 text-xl font-semibold border-t border-red-700/50 pt-2">+ Emergency Alerts Sent</p>
                </div>
                
                <!-- Stat Card 2: Guides Available -->
                <div class="p-6">
                    <i class="fa-solid fa-layer-group text-5xl text-red-500 mb-4"></i>
                    <div data-target="50" class="counter text-6xl font-extrabold text-white mb-2" id="stat2">0</div>
                    <p class="text-red-400 text-xl font-semibold border-t border-red-700/50 pt-2">+ Comprehensive Guides</p>
                </div>
                
                <!-- Stat Card 3: Residents Protected -->
                <div class="p-6">
                    <i class="fa-solid fa-user-shield text-5xl text-red-500 mb-4"></i>
                    <div data-target="1000" class="counter text-6xl font-extrabold text-white mb-2" id="stat3">0</div>
                    <p class="text-red-400 text-xl font-semibold border-t border-red-700/50 pt-2">+ Mati Residents Protected</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4️⃣ Resources / Disaster Guides Section -->
    <section class="py-16 bg-gray-900/70 rounded-xl shadow-xl">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-10">Disaster Preparedness Resources</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                
                <!-- Guide Card 1: Earthquake -->
                <div class="p-4 bg-gray-800 rounded-xl border-t-2 border-red-500 hover:bg-gray-700 transition duration-300 cursor-pointer">
                    <i class="fa-solid fa-house-crack text-4xl text-red-500 mb-3"></i>
                    <h4 class="text-lg font-semibold text-white">Earthquake Safety</h4>
                    <p class="text-gray-400 text-xs mt-1">Drop, Cover, and Hold On Guide.</p>
                </div>

                <!-- Guide Card 2: Typhoon / Flood -->
                <div class="p-4 bg-gray-800 rounded-xl border-t-2 border-red-500 hover:bg-gray-700 transition duration-300 cursor-pointer">
                    <i class="fa-solid fa-cloud-showers-heavy text-4xl text-red-500 mb-3"></i>
                    <h4 class="text-lg font-semibold text-white">Typhoon & Flood Prep</h4>
                    <p class="text-gray-400 text-xs mt-1">Creating your emergency kit.</p>
                </div>
                
                <!-- Guide Card 3: Tsunami -->
                <div class="p-4 bg-gray-800 rounded-xl border-t-2 border-red-500 hover:bg-gray-700 transition duration-300 cursor-pointer">
                    <i class="fa-solid fa-water text-4xl text-red-500 mb-3"></i>
                    <h4 class="text-lg font-semibold text-white">Tsunami Evacuation</h4>
                    <p class="text-gray-400 text-xs mt-1">Local evacuation routes map.</p>
                </div>
                
                <!-- Guide Card 4: First Aid -->
                <div class="p-4 bg-gray-800 rounded-xl border-t-2 border-red-500 hover:bg-gray-700 transition duration-300 cursor-pointer">
                    <i class="fa-solid fa-briefcase-medical text-4xl text-red-500 mb-3"></i>
                    <h4 class="text-lg font-semibold text-white">Basic First Aid</h4>
                    <p class="text-gray-400 text-xs mt-1">Essential life-saving techniques.</p>
                </div>
            </div>
            
            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center px-6 py-3 btn-gradient text-sm font-bold rounded-lg uppercase shadow-lg hover:shadow-red-500/50 transition duration-300">
                    Explore All Guides <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 5️⃣ Call to Action / Sign Up Section -->
    <section class="py-16 my-12 rounded-xl shadow-2xl overflow-hidden">
        <!-- Using a custom background class with image and gradient overlay -->
        <div class="cta-background p-10 text-center rounded-xl">
            <!-- Updated Headline -->
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
                Be Prepared. Get Started with SafeMati Today.
            </h2>
            <p class="text-lg text-white/90 mb-8">
                Your safety is our priority. Get protected in minutes.
            </p>
            <!-- CTA Buttons - Standardized Look -->
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                 <!-- Sign Up (Primary/White) -->
                <button class="w-full sm:w-auto px-8 py-4 bg-white text-red-700 font-bold rounded-lg shadow-xl uppercase text-lg hover:bg-gray-100 transform hover:scale-[1.02] transition duration-300">
                    <a href="signup.php">Sign Up Now</a>
                </button>
                <!-- Login (Secondary/Outlined) -->
                <button class="w-full sm:w-auto px-8 py-4 text-white font-semibold border-2 border-white rounded-lg bg-transparent hover:bg-white/20 transition duration-300 uppercase text-lg">
                    <a href="login.php">Login</a>
                </button>
            </div>
        </div><br><br>
    </section> 

</main> <!-- The closing tag for the <main> element opened in header.php -->

<!-- JavaScript for the Statistics Counter Animation -->
<script>
    // Function to handle the count-up animation
    function animateCount(targetElement, targetNumber) {
        let currentNumber = 0;
        const duration = 2000; // 2 seconds
        const startTime = performance.now();

        function updateCount(timestamp) {
            const elapsedTime = timestamp - startTime;
            const progress = Math.min(elapsedTime / duration, 1);
            
            // Apply easing function (easeOutQuad) for a smoother stop
            const easedProgress = 1 - Math.pow(1 - progress, 2);
            
            currentNumber = Math.floor(easedProgress * targetNumber);
            // Add '+' to the end of the text
            targetElement.textContent = currentNumber.toLocaleString() + '+';

            if (progress < 1) {
                requestAnimationFrame(updateCount);
            } else {
                targetElement.textContent = targetNumber.toLocaleString() + '+'; // Ensure final value is accurate
            }
        }
        requestAnimationFrame(updateCount);
    }

    // Intersection Observer to trigger the animation when the section is visible
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.counter');
        const observerOptions = {
            root: null, // viewport
            rootMargin: '0px',
            threshold: 0.5 // trigger when 50% of the element is visible
        };
        
        // Use a Set to track which counters have already animated
        const animatedCounters = new Set(); 

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                const targetElement = entry.target;
                
                // Only animate if intersecting and not already animated
                if (entry.isIntersecting && !animatedCounters.has(targetElement.id)) {
                    const targetNumber = parseInt(targetElement.getAttribute('data-target'));
                    
                    animateCount(targetElement, targetNumber);
                    
                    // Mark as animated and stop observing
                    animatedCounters.add(targetElement.id);
                    observer.unobserve(targetElement);
                }
            });
        }, observerOptions);

        counters.forEach(counter => {
            observer.observe(counter);
        });
    });
</script>

    </body>
</html>

<?php 
    // This loads the footer markup, the final closing body, and html tags
    include 'footer.php'; 
?>