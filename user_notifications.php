<?php 
    include 'user_header.php';
    require_once 'db_connect.php';
    
    $user_id = $_SESSION['user_id'];
    $user_barangay = $_SESSION['user_barangay'] ?? '';
    
    // Mark notification as read via AJAX would be handled separately
    if (isset($_POST['mark_read']) && isset($_POST['notification_id'])) {
        $notif_id = $_POST['notification_id'];
        // Update logic would go here
    }
    
    // Fetch user's notifications (simulated data - will connect to real DB later)
    $notifications = array(
        array(
            'id' => 1,
            'type' => 'alert',
            'title' => 'New Critical Alert in Your Area',
            'message' => 'Flood warning issued for ' . $user_barangay . '. Please stay alert and prepared.',
            'icon' => 'fa-triangle-exclamation',
            'color' => 'red',
            'time' => '5 minutes ago',
            'is_read' => false,
            'link' => 'user_alerts.php'
        ),
        array(
            'id' => 2,
            'type' => 'weather',
            'title' => 'Weather Update',
            'message' => 'Heavy rainfall expected in the next 24 hours. Monitor weather conditions.',
            'icon' => 'fa-cloud-showers-heavy',
            'color' => 'blue',
            'time' => '1 hour ago',
            'is_read' => false,
            'link' => 'user_dashboard.php#weather'
        ),
        array(
            'id' => 3,
            'type' => 'safety',
            'title' => 'New Safety Guide Available',
            'message' => 'Check out the latest Typhoon Preparedness Guide to stay informed.',
            'icon' => 'fa-book-open',
            'color' => 'green',
            'time' => '3 hours ago',
            'is_read' => true,
            'link' => 'user_guides.php'
        ),
        array(
            'id' => 4,
            'type' => 'system',
            'title' => 'Profile Updated',
            'message' => 'Your profile information was successfully updated.',
            'icon' => 'fa-user-check',
            'color' => 'purple',
            'time' => '1 day ago',
            'is_read' => true,
            'link' => 'user_profile.php'
        ),
        array(
            'id' => 5,
            'type' => 'alert',
            'title' => 'Alert Resolved',
            'message' => 'The fire incident near Public Market has been contained and resolved.',
            'icon' => 'fa-circle-check',
            'color' => 'green',
            'time' => '2 days ago',
            'is_read' => true,
            'link' => 'user_alerts.php'
        )
    );
    
    $unread_count = count(array_filter($notifications, function($n) { return !$n['is_read']; }));
?>

<style>
    .notification-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .notification-card.unread {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border-left-color: #ef4444;
    }
    
    .notification-card.read {
        background-color: #1f2937;
        opacity: 0.7;
    }
    
    .notification-card:hover {
        transform: translateX(5px);
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
    }
    
    .mark-read-btn {
        transition: all 0.2s ease;
    }
    
    .mark-read-btn:hover {
        transform: scale(1.1);
    }
    
    .filter-tab {
        transition: all 0.3s ease;
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-weight: bold;
    }
</style>

<div class="pt-24 pb-16 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">
        
        <!-- Page Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-extrabold text-white mb-2">
                    <i class="fa-solid fa-bell text-red-500 mr-3"></i>
                    Notifications
                </h1>
                <p class="text-gray-400 text-lg">
                    <span class="text-red-500 font-bold"><?php echo $unread_count; ?></span> unread notification<?php echo $unread_count != 1 ? 's' : ''; ?>
                </p>
            </div>
            
            <?php if ($unread_count > 0): ?>
            <button id="mark-all-read" class="px-6 py-3 bg-gray-800 hover:bg-red-600 text-white rounded-lg font-semibold transition border-2 border-gray-700 hover:border-red-500">
                <i class="fa-solid fa-check-double mr-2"></i>Mark All as Read
            </button>
            <?php endif; ?>
        </div>
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-3 mb-8 p-4 bg-gray-800 rounded-xl border-2 border-gray-700">
            <button class="filter-tab active px-4 py-2 rounded-lg bg-gray-700 text-gray-300" data-filter="all">
                <i class="fa-solid fa-list mr-2"></i>All
            </button>
            <button class="filter-tab px-4 py-2 rounded-lg bg-gray-700 text-gray-300" data-filter="alert">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>Alerts
            </button>
            <button class="filter-tab px-4 py-2 rounded-lg bg-gray-700 text-gray-300" data-filter="weather">
                <i class="fa-solid fa-cloud mr-2"></i>Weather
            </button>
            <button class="filter-tab px-4 py-2 rounded-lg bg-gray-700 text-gray-300" data-filter="safety">
                <i class="fa-solid fa-shield-halved mr-2"></i>Safety
            </button>
            <button class="filter-tab px-4 py-2 rounded-lg bg-gray-700 text-gray-300" data-filter="system">
                <i class="fa-solid fa-gear mr-2"></i>System
            </button>
        </div>
        
        <!-- Notifications List -->
        <div id="notifications-list" class="space-y-4">
            <?php foreach ($notifications as $notification): ?>
            <div class="notification-card <?php echo $notification['is_read'] ? 'read' : 'unread'; ?> p-6 rounded-xl shadow-xl border-2 border-gray-700" 
                 data-type="<?php echo $notification['type']; ?>"
                 data-id="<?php echo $notification['id']; ?>">
                 
                <div class="flex items-start justify-between">
                    <div class="flex items-start flex-grow">
                        <!-- Icon -->
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-<?php echo $notification['color']; ?>-600/20 flex items-center justify-center mr-4">
                            <i class="fa-solid <?php echo $notification['icon']; ?> text-<?php echo $notification['color']; ?>-500 text-xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-grow">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-white"><?php echo htmlspecialchars($notification['title']); ?></h3>
                                <?php if (!$notification['is_read']): ?>
                                <span class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-bold rounded-full">
                                    <span class="w-2 h-2 bg-white rounded-full mr-1 animate-pulse"></span>NEW
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="text-gray-300 mb-3"><?php echo htmlspecialchars($notification['message']); ?></p>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    <i class="fa-solid fa-clock mr-1"></i><?php echo $notification['time']; ?>
                                </span>
                                
                                <div class="flex space-x-2">
                                    <?php if ($notification['link']): ?>
                                    <a href="<?php echo $notification['link']; ?>" 
                                       class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition">
                                        <i class="fa-solid fa-arrow-right mr-1"></i>View
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!$notification['is_read']): ?>
                                    <button class="mark-read-btn px-4 py-2 bg-gray-700 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition"
                                            data-id="<?php echo $notification['id']; ?>">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Empty State -->
        <div id="empty-state" class="hidden text-center py-16">
            <i class="fa-solid fa-bell-slash text-6xl text-gray-600 mb-4"></i>
            <p class="text-xl text-gray-400 font-semibold">No notifications in this category</p>
        </div>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const notificationCards = document.querySelectorAll('.notification-card');
    const emptyState = document.getElementById('empty-state');
    const notificationsList = document.getElementById('notifications-list');
    const markAllReadBtn = document.getElementById('mark-all-read');
    
    // Filter functionality
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter notifications
            let visibleCount = 0;
            notificationCards.forEach(card => {
                const type = card.getAttribute('data-type');
                if (filter === 'all' || type === filter) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show/hide empty state
            if (visibleCount === 0) {
                notificationsList.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                notificationsList.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }
        });
    });
    
    // Mark individual as read
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.notification-card');
            card.classList.remove('unread');
            card.classList.add('read');
            this.remove();
            updateUnreadCount();
            
            // Here you would send AJAX request to mark as read in database
            const notifId = this.getAttribute('data-id');
            console.log('Marking notification ' + notifId + ' as read');
        });
    });
    
    // Mark all as read
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            document.querySelectorAll('.notification-card.unread').forEach(card => {
                card.classList.remove('unread');
                card.classList.add('read');
                const markBtn = card.querySelector('.mark-read-btn');
                if (markBtn) markBtn.remove();
            });
            this.remove();
            updateUnreadCount();
            
            // Here you would send AJAX request to mark all as read
            console.log('Marking all notifications as read');
        });
    }
    
    function updateUnreadCount() {
        const unreadCount = document.querySelectorAll('.notification-card.unread').length;
        // Update the count display
        const countDisplay = document.querySelector('.text-red-500.font-bold');
        if (countDisplay) {
            countDisplay.textContent = unreadCount;
        }
    }
});
</script>

<?php include 'user_footer.php'; ?>
