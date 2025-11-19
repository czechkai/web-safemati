<?php 
    include 'user_header.php';
    require_once 'db_connect.php';
    
    $user_id = $_SESSION['user_id'];
    $success_message = '';
    $error_message = '';
    
    // Handle settings update
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process form submission here
        $success_message = "Settings saved successfully!";
    }
?>

<style>
    .settings-card {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border: 2px solid #374151;
        transition: all 0.3s ease;
    }
    
    .settings-card:hover {
        border-color: #ef4444;
    }
    
    .toggle-switch {
        width: 48px;
        height: 24px;
        background-color: #374151;
        border-radius: 12px;
        position: relative;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .toggle-switch.active {
        background-color: #ef4444;
    }
    
    .toggle-slider {
        width: 20px;
        height: 20px;
        background-color: white;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        left: 2px;
        transition: transform 0.3s;
    }
    
    .toggle-switch.active .toggle-slider {
        transform: translateX(24px);
    }
</style>

<div class="pt-24 pb-16 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-white mb-2">
                <i class="fa-solid fa-gear text-red-500 mr-3"></i>
                Settings & Privacy
            </h1>
            <p class="text-gray-400 text-lg">Manage your account settings and preferences</p>
        </div>
        
        <?php if ($success_message): ?>
        <div class="bg-green-900/30 border-2 border-green-500 text-green-300 p-4 rounded-xl mb-6 flex items-center">
            <i class="fa-solid fa-circle-check text-2xl mr-3"></i>
            <span class="font-semibold"><?php echo $success_message; ?></span>
        </div>
        <?php endif; ?>
        
        <div class="space-y-6">
            
            <!-- Account Settings -->
            <div class="settings-card p-6 rounded-xl shadow-2xl">
                <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                    <i class="fa-solid fa-user-gear text-red-500 mr-2"></i>
                    Account Settings
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Public Profile</p>
                            <p class="text-sm text-gray-400">Make your profile visible to other users</p>
                        </div>
                        <div class="toggle-switch" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Show Location</p>
                            <p class="text-sm text-gray-400">Display your barangay on your profile</p>
                        </div>
                        <div class="toggle-switch active" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Activity Status</p>
                            <p class="text-sm text-gray-400">Show when you're online</p>
                        </div>
                        <div class="toggle-switch active" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Privacy Settings -->
            <div class="settings-card p-6 rounded-xl shadow-2xl">
                <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                    <i class="fa-solid fa-shield-halved text-red-500 mr-2"></i>
                    Privacy & Security
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Two-Factor Authentication</p>
                            <p class="text-sm text-gray-400">Add an extra layer of security</p>
                        </div>
                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                            Enable
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Login History</p>
                            <p class="text-sm text-gray-400">View your recent login activity</p>
                        </div>
                        <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition">
                            View
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Data Download</p>
                            <p class="text-sm text-gray-400">Download a copy of your data</p>
                        </div>
                        <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition">
                            <i class="fa-solid fa-download mr-2"></i>Download
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Notification Preferences -->
            <div class="settings-card p-6 rounded-xl shadow-2xl">
                <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                    <i class="fa-solid fa-bell text-red-500 mr-2"></i>
                    Notification Preferences
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Push Notifications</p>
                            <p class="text-sm text-gray-400">Receive alerts on your device</p>
                        </div>
                        <div class="toggle-switch active" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Email Notifications</p>
                            <p class="text-sm text-gray-400">Receive updates via email</p>
                        </div>
                        <div class="toggle-switch active" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">SMS Alerts</p>
                            <p class="text-sm text-gray-400">Receive critical alerts via SMS</p>
                        </div>
                        <div class="toggle-switch" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Danger Zone -->
            <div class="settings-card p-6 rounded-xl shadow-2xl border-red-900">
                <h3 class="text-2xl font-bold text-red-500 mb-6 border-b border-red-900 pb-3">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    Danger Zone
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-red-900/20 border border-red-900 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Deactivate Account</p>
                            <p class="text-sm text-gray-400">Temporarily disable your account</p>
                        </div>
                        <button class="px-4 py-2 bg-red-900 hover:bg-red-800 text-white rounded-lg font-semibold transition">
                            Deactivate
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-red-900/20 border border-red-900 rounded-lg">
                        <div>
                            <p class="font-semibold text-white">Delete Account</p>
                            <p class="text-sm text-gray-400">Permanently delete your account and data</p>
                        </div>
                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
function toggleSwitch(element) {
    element.classList.toggle('active');
    // Here you would send AJAX request to save the setting
    console.log('Toggle setting:', element.classList.contains('active'));
}
</script>

<?php include 'user_footer.php'; ?>
