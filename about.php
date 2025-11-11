<?php 
    include 'header.php'; 
?>

<style>
    .cta-background {
        background-image: url('assets/img-cta-banner.jpg');
        background-size: cover;
        background-position: center;
        position: relative;
        isolation: isolate;
        width: 100%; 
    }
    .cta-background::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(220, 38, 38, 0.8), rgba(239, 68, 68, 0.8)); 
        z-index: -1;
        border-radius: inherit;
    }

    /* UPDATED: Hero banner is now full screen (100vh) */
    .about-hero-background {
        background-image: url('assets/about-safemati.png');
        background-size: cover;
        background-position: center;
        position: relative;
        isolation: isolate;
        min-height: 100vh; /* FULL SCREEN HEIGHT */
        width: 100%;
    }
    .about-hero-background::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: -1;
        border-radius: inherit;
    }

    .mission-vision-card {
        transition: all 0.3s ease;
    }

    .mission-vision-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
        border-color: #EF4444; /* red-500 */
    }

    /* Custom style for the vertical timeline connector line */
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 17px; /* Align with the center of the icon circle */
        top: 40px; 
        bottom: -20px; /* Extend the line downwards */
        width: 2px;
        background-color: #DC2626; /* red-600 */
        z-index: 10;
    }
</style>

<div class="space-y-16">
    
    <!-- 1️⃣ About Hero Banner -->
    <!-- The hero now occupies the entire viewport height -->
    <section class="about-hero-background flex items-center justify-center text-center py-32 rounded-xl shadow-2xl">
        <div class="max-w-4xl px-4 z-0">
            <h1 class="text-5xl sm:text-6xl font-extrabold leading-tight text-white mb-4">
            Stay Safe and Prepared
 <!-- <span class="text-red-500">A Resilient Mati City</span> -->
            </h1>
            <p class="text-xl text-red-00">
                SafeMati is your local disaster risk reduction and real-time alert system, designed to protect residents through information, awareness, and preparedness.

            </p>
        </div>
    </section>

    <!-- 2️⃣ Mission, Vision, and Goals (MVG) -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-12 text-center border-b border-red-700/50 pb-2">Our Core Pillars</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Mission Card -->
                <div class="mission-vision-card p-8 bg-gray-900 rounded-xl border-t-4 border-red-500 shadow-lg">
                    <i class="fa-solid fa-flag text-5xl text-red-500 mb-4"></i>
                    <h3 class="text-2xl font-bold text-white mb-3">Our Mission</h3>
                    <p class="text-gray-300">To provide the residents and visitors of Mati City with **reliable, real-time disaster information** and tools necessary to make informed decisions that safeguard lives and property.</p>
                </div>
                
                <!-- Vision Card -->
                <div class="mission-vision-card p-8 bg-gray-900 rounded-xl border-t-4 border-red-500 shadow-lg">
                    <i class="fa-solid fa-eye text-5xl text-red-500 mb-4"></i>
                    <h3 class="text-2xl font-bold text-white mb-3">Our Vision</h3>
                    <p class="text-gray-300">To see Mati City recognized as the **most disaster-resilient city** in the Davao Region, where preparedness is a culture and no life is lost due to lack of information.</p>
                </div>
                
                <!-- Goals Card -->
                <div class="mission-vision-card p-8 bg-gray-900 rounded-xl border-t-4 border-red-500 shadow-lg">
                    <i class="fa-solid fa-bullseye text-5xl text-red-500 mb-4"></i>
                    <h3 class="text-2xl font-bold text-white mb-3">Our Goals</h3>
                    <ul class="list-disc list-inside text-gray-300 space-y-2">
                        <li>Achieve 99.9% uptime for all alert systems.</li>
                        <li>Integrate with all local emergency response units.</li>
                        <li>Maintain a library of 50+ local preparedness guides.</li>
                    </ul>
                </div>
                
            </div>
        </div>
    </section>

    <!-- 2.5️⃣ How SafeMati Works (Vertical Process & Map) -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-12 text-center border-b border-red-700/50 pb-2">How SafeMati Works</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                <!-- Left Column: Vertical Process Timeline -->
                <div class="bg-gray-900 p-8 rounded-xl shadow-2xl">
                    <h3 class="text-2xl font-semibold text-white mb-8 border-b border-gray-700 pb-3">The Alert Lifecycle</h3>
                    
                    <div class="space-y-10">
                        
                        <!-- Step 1: Data Acquisition -->
                        <div class="timeline-item relative pl-12">
                            <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-red-600 flex items-center justify-center z-20 shadow-lg border-2 border-white">
                                <i class="fa-solid fa-cloud-arrow-down text-sm text-white"></i>
                            </div>
                            <h4 class="text-xl font-bold text-red-500 mb-1">1. Data Acquisition</h4>
                            <p class="text-gray-300">Official alerts are constantly pulled from government sources like NDRRMC, PAGASA, and PHIVOLCS into our secure processing hub.</p>
                        </div>

                        <!-- Step 2: Verification and Zoning -->
                        <div class="timeline-item relative pl-12">
                            <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-red-600 flex items-center justify-center z-20 shadow-lg border-2 border-white">
                                <i class="fa-solid fa-map-location-dot text-sm text-white"></i>
                            </div>
                            <h4 class="text-xl font-bold text-red-500 mb-1">2. Verification & Zoning</h4>
                            <p class="text-gray-300">Local authorities verify the threat, designate affected **barangays or zones** within Mati, and prepare localized instructions.</p>
                        </div>

                        <!-- Step 3: Alert Transmission -->
                        <div class="timeline-item relative pl-12">
                            <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-red-600 flex items-center justify-center z-20 shadow-lg border-2 border-white">
                                <i class="fa-solid fa-bullhorn text-sm text-white"></i>
                            </div>
                            <h4 class="text-xl font-bold text-red-500 mb-1">3. Alert Transmission</h4>
                            <p class="text-gray-300">The customized alert is instantly pushed to the SafeMati app, website, and SMS service for all registered users in the affected area.</p>
                        </div>

                        <!-- Step 4: Community Response -->
                        <div class="timeline-item relative pl-12">
                            <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-red-600 flex items-center justify-center z-20 shadow-lg border-2 border-white">
                                <i class="fa-solid fa-house-chimney-crack text-sm text-white"></i>
                            </div>
                            <h4 class="text-xl font-bold text-red-500 mb-1">4. Community Response</h4>
                            <p class="text-gray-300">Users follow the provided safety protocols and evacuation instructions, maximizing safety and minimizing chaos.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Embedded Map -->
                <div class="w-full h-[550px] bg-gray-900 rounded-xl shadow-2xl overflow-hidden border border-red-500/50">
                    <h3 class="text-2xl font-semibold text-white p-4 bg-red-700/20"> Mati City, Davao Oriental</h3>
                    <!-- Google Maps Embed for Mati City -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15730.292928503833!2d126.20847999999999!3d6.942730000000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x35f42c676770f405:0x52482e98c1995116!2sMati%20City%2C%20Davao%20Oriental!5e0!3m2!1sen!2sph!4v1678878298765!5m2!1sen!2sph" 
                        width="100%" 
                        height="500" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="mt-[-4px]"
                    ></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- 3️⃣ The Team / Core Values Section (Simplified) -->
    <section class="py-16 bg-gray-800 rounded-xl shadow-inner">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-12 border-b border-red-700/50 pb-2">Our Core Values</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                
                <!-- Value 1: Reliability -->
                <div class="p-4">
                    <i class="fa-solid fa-check-circle text-5xl text-red-500 mb-3"></i>
                    <h4 class="text-xl font-semibold text-white mb-2">Reliability</h4>
                    <p class="text-gray-400 text-sm">Timely and accurate information, always.</p>
                </div>

                <!-- Value 2: Community -->
                <div class="p-4">
                    <i class="fa-solid fa-users text-5xl text-red-500 mb-3"></i>
                    <h4 class="text-xl font-semibold text-white mb-2">Community</h4>
                    <p class="text-gray-400 text-sm">Safety through collaboration and inclusion.</p>
                </div>
                
                <!-- Value 3: Innovation -->
                <div class="p-4">
                    <i class="fa-solid fa-lightbulb text-5xl text-red-500 mb-3"></i>
                    <h4 class="text-xl font-semibold text-white mb-2">Innovation</h4>
                    <p class="text-gray-400 text-sm">Utilizing the best available technology.</p>
                </div>
                
                <!-- Value 4: Transparency -->
                <div class="p-4">
                    <i class="fa-solid fa-clipboard-list text-5xl text-red-500 mb-3"></i>
                    <h4 class="text-xl font-semibold text-white mb-2">Transparency</h4>
                    <p class="text-gray-400 text-sm">Open communication about data and sources.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4️⃣ Official Partners/Sources Section -->
    

    <!-- 5️⃣ CTA Section (Reused from index) -->
    <section class="py-16 overflow-hidden">
        <div class="cta-background">
            <div class="max-w-7xl mx-auto p-10 text-center">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
                    Be part of a safer Mati City.
                </h2>
                <p class="text-lg text-white/90 mb-8">
                    Sign up today to receive real-time alerts and safety updates directly to your device.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <button class="w-full sm:w-auto px-8 py-4 bg-white text-red-700 font-bold rounded-lg shadow-xl uppercase text-lg hover:bg-gray-100 transform hover:scale-[1.02] transition duration-300">
                        Sign Up Now
                    </button>
                    <button class="w-full sm:w-auto px-8 py-4 bg-gray-900/50 text-white font-semibold border-2 border-white rounded-lg hover:bg-white/20 transition duration-300 uppercase text-lg">
                        Learn More
                    </button>
                </div>
            </div>
        </div>
    </section> 

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-12 border-b border-red-700/50 pb-2">Official Data Sources</h2>
            <p class="text-lg text-gray-300 mb-10 max-w-3xl mx-auto">
                SafeMati information is sourced directly from accredited government agencies to ensure maximum reliability and speed.
            </p>
            
            <!-- Partner Icons Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-8 items-center justify-center p-6 bg-gray-900 rounded-xl shadow-xl border border-gray-700">
                
                <!-- Icon 1: NDRRMC -->
                <div class="p-2">
                    <i class="fa-solid fa-circle-nodes text-5xl text-red-500 mb-3"></i>
                    <p class="text-sm font-semibold text-gray-300 text-center">NDRRMC</p>
                </div>

                <!-- Icon 2: Pagasa -->
                <div class="p-2">
                    <i class="fa-solid fa-cloud-sun-rain text-5xl text-red-500 mb-3"></i>
                    <p class="text-sm font-semibold text-gray-300 text-center">PAGASA</p>
                </div>
                
                <!-- Icon 3: LGU Mati -->
                <div class="p-2">
                    <i class="fa-solid fa-city text-5xl text-red-500 mb-3"></i>
                    <p class="text-sm font-semibold text-gray-300 text-center">LGU-Mati</p>
                </div>

                <!-- Icon 4: Health Services -->
                <div class="p-2">
                    <i class="fa-solid fa-hospital text-5xl text-red-500 mb-3"></i>
                    <h4 class="text-sm font-semibold text-gray-300 text-center">Health Services</h4>
                </div>
                
                <!-- Icon 5: PHIVOLCS -->
                <div class="p-2">
                    <i class="fa-solid fa-mountain-sun text-5xl text-red-500 mb-3"></i>
                    <p class="text-sm font-semibold text-gray-300 text-center">PHIVOLCS</p>
                </div>
            </div>
        </div>
    </section>

</main> <!-- The closing tag for the <main> element opened in header.php -->

<?php 
    include 'footer.php'; 
?>