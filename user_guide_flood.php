<?php 
include 'user_header.php';
require_once 'db_connect.php';

$guide_id = 1; // Flood guide ID
$user_id = $_SESSION['user_id'];

// Check if guide is bookmarked
$bookmark_query = "SELECT * FROM user_bookmarked_guides WHERE user_id = ? AND guide_id = ?";
$bookmark_stmt = $conn->prepare($bookmark_query);
$bookmark_stmt->bind_param("ii", $user_id, $guide_id);
$bookmark_stmt->execute();
$is_bookmarked = $bookmark_stmt->get_result()->num_rows > 0;
$bookmark_stmt->close();

// Check if guide is completed
$progress_query = "SELECT * FROM user_guide_progress WHERE user_id = ? AND guide_id = ? AND is_completed = 1";
$progress_stmt = $conn->prepare($progress_query);
$progress_stmt->bind_param("ii", $user_id, $guide_id);
$progress_stmt->execute();
$is_completed = $progress_stmt->get_result()->num_rows > 0;
$progress_stmt->close();
?>

<style>
    .guide-content-section {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border: 2px solid #374151;
        transition: all 0.3s ease;
    }
    
    .guide-content-section:hover {
        border-color: #ef4444;
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.2);
    }
    
    .bookmark-btn, .complete-btn {
        transition: all 0.3s ease;
    }
    
    .bookmark-btn:hover, .complete-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.5);
    }
    
    .bookmark-btn.active {
        background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
    }
    
    .checklist-item {
        transition: all 0.2s ease;
    }
    
    .checklist-item:hover {
        background-color: #1f2937;
    }
</style>

<div class="pt-24 pb-16 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Back Button -->
        <a href="user_guides.php" class="inline-flex items-center text-red-400 hover:text-red-300 mb-6 font-semibold transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to All Guides
        </a>
        
        <!-- Guide Header -->
        <div class="guide-content-section p-8 rounded-xl shadow-2xl mb-8">
            <div class="flex items-start justify-between">
                <div class="flex-grow">
                    <div class="flex items-center mb-4">
                        <i class="fa-solid fa-water text-6xl text-blue-400 mr-6"></i>
                        <div>
                            <h1 class="text-4xl font-extrabold text-white mb-2">Flood Safety Guide</h1>
                            <p class="text-gray-400 text-lg">Essential preparedness and response strategies for flooding</p>
                        </div>
                    </div>
                    
                    <?php if ($is_completed): ?>
                    <div class="inline-flex items-center px-4 py-2 bg-green-600/30 text-green-400 rounded-full border border-green-500 mb-4">
                        <i class="fa-solid fa-circle-check mr-2"></i>
                        <span class="font-semibold">Completed</span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="flex flex-col gap-3">
                    <!-- Bookmark Button -->
                    <button id="bookmark-btn" class="bookmark-btn px-6 py-3 rounded-lg font-bold text-white <?php echo $is_bookmarked ? 'active' : 'bg-gray-700 hover:bg-gray-600'; ?>" data-guide-id="<?php echo $guide_id; ?>">
                        <i class="fa-solid fa-bookmark mr-2"></i>
                        <span id="bookmark-text"><?php echo $is_bookmarked ? 'Bookmarked' : 'Bookmark'; ?></span>
                    </button>
                    
                    <!-- Mark as Complete Button -->
                    <?php if (!$is_completed): ?>
                    <button id="complete-btn" class="complete-btn px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg font-bold text-white" data-guide-id="<?php echo $guide_id; ?>">
                        <i class="fa-solid fa-check mr-2"></i> Mark as Complete
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Guide Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Before Flooding Section -->
                <div class="guide-content-section p-8 rounded-xl shadow-2xl">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b border-red-500 pb-3">
                        <i class="fa-solid fa-clipboard-list text-red-500 mr-2"></i>
                        Before a Flood
                    </h2>
                    
                    <div class="space-y-6 text-gray-300">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-3">1. Know Your Risk</h3>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li>Check if your area is in a flood-prone zone</li>
                                <li>Understand local warning systems and evacuation routes</li>
                                <li>Learn about PAGASA flood alerts for Mati City</li>
                                <li>Identify the nearest evacuation center in your barangay</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold text-white mb-3">2. Prepare an Emergency Kit</h3>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li><strong>Water:</strong> At least 1 gallon per person per day for 3 days</li>
                                <li><strong>Food:</strong> Non-perishable items for 3 days</li>
                                <li><strong>Medicine:</strong> First aid kit and prescription medications</li>
                                <li><strong>Documents:</strong> Copies of important papers in waterproof container</li>
                                <li><strong>Tools:</strong> Flashlight, batteries, whistle, mobile phone with charger</li>
                                <li><strong>Hygiene:</strong> Soap, sanitizer, wet wipes, face masks</li>
                                <li><strong>Cash:</strong> Small denominations as ATMs may not work</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold text-white mb-3">3. Protect Your Property</h3>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li>Install check valves in plumbing to prevent backflow</li>
                                <li>Clear gutters and downspouts regularly</li>
                                <li>Move valuable items to upper floors</li>
                                <li>Elevate electrical appliances above potential flood levels</li>
                                <li>Store important documents in waterproof containers</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- During Flooding Section -->
                <div class="guide-content-section p-8 rounded-xl shadow-2xl">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b border-red-500 pb-3">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i>
                        During a Flood
                    </h2>
                    
                    <div class="space-y-6 text-gray-300">
                        <div class="bg-red-900/30 border-2 border-red-500 rounded-lg p-6 mb-6">
                            <h3 class="text-xl font-bold text-red-400 mb-3">
                                <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                                CRITICAL SAFETY RULES
                            </h3>
                            <ul class="list-disc list-inside space-y-2 ml-4 text-white">
                                <li><strong>NEVER walk through flowing water</strong> - 6 inches can knock you over</li>
                                <li><strong>NEVER drive through flooded roads</strong> - Turn Around, Don't Drown!</li>
                                <li><strong>AVOID contact with floodwater</strong> - It may be contaminated</li>
                                <li><strong>STAY AWAY from power lines</strong> - Electrocution risk</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold text-white mb-3">What to Do:</h3>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li>Monitor SafeMati alerts and radio updates constantly</li>
                                <li>Evacuate immediately if ordered by authorities</li>
                                <li>Move to higher ground if water is rising</li>
                                <li>Go to the highest level of your building if unable to evacuate</li>
                                <li>Call for help only if life-threatening emergency</li>
                                <li>Signal for help (wave white cloth, flashlight at night)</li>
                                <li>Do not return home until authorities say it's safe</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- After Flooding Section -->
                <div class="guide-content-section p-8 rounded-xl shadow-2xl">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b border-red-500 pb-3">
                        <i class="fa-solid fa-house-circle-check text-green-500 mr-2"></i>
                        After a Flood
                    </h2>
                    
                    <div class="space-y-6 text-gray-300">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-3">Return Safely</h3>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li>Wait for official clearance before returning home</li>
                                <li>Avoid buildings with standing water around them</li>
                                <li>Enter your home carefully - watch for structural damage</li>
                                <li>Take photos of damage for insurance claims</li>
                                <li>Check for gas leaks - if you smell gas, leave immediately</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold text-white mb-3">Clean-Up Safety</h3>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li>Wear rubber boots, gloves, and face masks during cleanup</li>
                                <li>Discard food that came in contact with floodwater</li>
                                <li>Clean and disinfect everything touched by floodwater</li>
                                <li>Remove and discard drywall and insulation soaked with dirty water</li>
                                <li>Be alert for snakes or other animals in your home</li>
                                <li>Seek medical attention if injured or feeling ill</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Quick Reference Checklist -->
                <div class="guide-content-section p-6 rounded-xl shadow-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 border-b border-red-500 pb-2">
                        <i class="fa-solid fa-list-check text-red-500 mr-2"></i>
                        Quick Checklist
                    </h3>
                    
                    <div class="space-y-2">
                        <label class="checklist-item flex items-start p-3 bg-gray-800 rounded-lg cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 text-red-600 rounded">
                            <span class="ml-3 text-sm text-gray-300">Emergency kit prepared</span>
                        </label>
                        
                        <label class="checklist-item flex items-start p-3 bg-gray-800 rounded-lg cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 text-red-600 rounded">
                            <span class="ml-3 text-sm text-gray-300">Know evacuation routes</span>
                        </label>
                        
                        <label class="checklist-item flex items-start p-3 bg-gray-800 rounded-lg cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 text-red-600 rounded">
                            <span class="ml-3 text-sm text-gray-300">Important documents secured</span>
                        </label>
                        
                        <label class="checklist-item flex items-start p-3 bg-gray-800 rounded-lg cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 text-red-600 rounded">
                            <span class="ml-3 text-sm text-gray-300">Family communication plan</span>
                        </label>
                        
                        <label class="checklist-item flex items-start p-3 bg-gray-800 rounded-lg cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 text-red-600 rounded">
                            <span class="ml-3 text-sm text-gray-300">Know local warning signs</span>
                        </label>
                        
                        <label class="checklist-item flex items-start p-3 bg-gray-800 rounded-lg cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 text-red-600 rounded">
                            <span class="ml-3 text-sm text-gray-300">Have emergency contacts</span>
                        </label>
                    </div>
                </div>
                
                <!-- Emergency Contacts -->
                <div class="guide-content-section p-6 rounded-xl shadow-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 border-b border-red-500 pb-2">
                        <i class="fa-solid fa-phone text-red-500 mr-2"></i>
                        Emergency Contacts
                    </h3>
                    
                    <div class="space-y-3">
                        <a href="tel:911" class="flex items-center p-3 bg-red-600 hover:bg-red-700 rounded-lg transition">
                            <i class="fa-solid fa-phone-volume text-white text-xl mr-3"></i>
                            <div>
                                <p class="text-white font-bold text-lg">911</p>
                                <p class="text-red-100 text-xs">Emergency Hotline</p>
                            </div>
                        </a>
                        
                        <a href="tel:082-821-1122" class="flex items-center p-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                            <i class="fa-solid fa-life-ring text-blue-400 text-xl mr-3"></i>
                            <div>
                                <p class="text-white font-bold">082-821-1122</p>
                                <p class="text-gray-400 text-xs">Mati CDRRMO</p>
                            </div>
                        </a>
                        
                        <a href="user_hotlines.php" class="block text-center p-3 bg-gray-800 hover:bg-gray-700 text-red-400 font-semibold rounded-lg transition">
                            View All Hotlines <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Related Guides -->
                <div class="guide-content-section p-6 rounded-xl shadow-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 border-b border-red-500 pb-2">
                        <i class="fa-solid fa-book text-red-500 mr-2"></i>
                        Related Guides
                    </h3>
                    
                    <div class="space-y-2">
                        <a href="user_guide_typhoon.php" class="block p-3 bg-gray-800 hover:bg-gray-700 rounded-lg transition">
                            <div class="flex items-center">
                                <i class="fa-solid fa-wind text-sky-400 text-2xl mr-3"></i>
                                <span class="text-white font-semibold">Typhoon Guide</span>
                            </div>
                        </a>
                        
                        <a href="user_guide_landslide.php" class="block p-3 bg-gray-800 hover:bg-gray-700 rounded-lg transition">
                            <div class="flex items-center">
                                <i class="fa-solid fa-hill-avalanche text-gray-500 text-2xl mr-3"></i>
                                <span class="text-white font-semibold">Landslide Guide</span>
                            </div>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const bookmarkBtn = document.getElementById('bookmark-btn');
    const completeBtn = document.getElementById('complete-btn');
    const bookmarkText = document.getElementById('bookmark-text');
    
    // Bookmark toggle
    if (bookmarkBtn) {
        bookmarkBtn.addEventListener('click', function() {
            const guideId = this.dataset.guideId;
            const formData = new FormData();
            formData.append('guide_id', guideId);
            
            fetch('ajax/toggle_bookmark.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.action === 'added') {
                        bookmarkBtn.classList.add('active');
                        bookmarkBtn.classList.remove('bg-gray-700', 'hover:bg-gray-600');
                        bookmarkText.textContent = 'Bookmarked';
                    } else {
                        bookmarkBtn.classList.remove('active');
                        bookmarkBtn.classList.add('bg-gray-700', 'hover:bg-gray-600');
                        bookmarkText.textContent = 'Bookmark';
                    }
                    
                    // Show feedback
                    showNotification(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating bookmark', 'error');
            });
        });
    }
    
    // Mark as complete
    if (completeBtn) {
        completeBtn.addEventListener('click', function() {
            const guideId = this.dataset.guideId;
            const formData = new FormData();
            formData.append('guide_id', guideId);
            
            fetch('ajax/mark_guide_complete.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Replace button with completed badge
                    completeBtn.outerHTML = `
                        <div class="inline-flex items-center px-4 py-2 bg-green-600/30 text-green-400 rounded-full border border-green-500">
                            <i class="fa-solid fa-circle-check mr-2"></i>
                            <span class="font-semibold">Completed</span>
                        </div>
                    `;
                    showNotification(data.message);
                    
                    // Reload page after 1.5 seconds to update progress bar
                    setTimeout(() => {
                        window.location.href = 'user_guides.php';
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error marking guide complete', 'error');
            });
        });
    }
    
    // Notification toast function
    function showNotification(message, type = 'success') {
        const bgColor = type === 'success' ? 'bg-green-600' : 'bg-red-600';
        const toast = document.createElement('div');
        toast.className = `fixed top-24 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-2xl z-50 transform transition-all duration-300 translate-x-full`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
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
});
</script>

<?php include 'user_footer.php'; ?>
