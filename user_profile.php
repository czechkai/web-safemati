<?php 
    include 'user_header.php';
    require_once 'db_connect.php';
    
    $user_id = $_SESSION['user_id'];
    $success_message = '';
    $error_message = '';
    
    // Fetch current user data
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    
    // Handle profile update
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $barangay = $_POST['barangay'];
        
        $update_query = "UPDATE users SET name = ?, email = ?, phone_number = ?, barangay = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssssi", $name, $email, $phone_number, $barangay, $user_id);
        
        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully!";
            // Update session variables
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_barangay'] = $barangay;
            // Refresh user data
            $user_data['name'] = $name;
            $user_data['email'] = $email;
            $user_data['phone_number'] = $phone_number;
            $user_data['barangay'] = $barangay;
        } else {
            $error_message = "Error updating profile. Please try again.";
        }
    }
    
    // Handle password change
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        if (password_verify($current_password, $user_data['password'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $password_query = "UPDATE users SET password = ? WHERE user_id = ?";
                $password_stmt = $conn->prepare($password_query);
                $password_stmt->bind_param("si", $hashed_password, $user_id);
                
                if ($password_stmt->execute()) {
                    $success_message = "Password changed successfully!";
                } else {
                    $error_message = "Error changing password.";
                }
            } else {
                $error_message = "New passwords do not match.";
            }
        } else {
            $error_message = "Current password is incorrect.";
        }
    }
    
    // List of barangays in Mati City
    $barangays = array(
        'Badas', 'Bobon', 'Buso', 'Cabuaya', 'Central (Pob.)', 'Culian', 'Dahican',
        'Danao', 'Dawan', 'Don Enrique Lopez', 'Don Martin Marundan', 'Don Salvador Lopez Sr.',
        'Langka', 'Lawigan', 'Libudon', 'Luban', 'Macambol', 'Mamali', 'Matiao',
        'Mayo', 'Sainz', 'Sanghay', 'Tagabakid', 'Tagbinonga', 'Taguibo', 'Tamisan'
    );
    
    // Fetch user's emergency reports (with error handling)
    $user_reports = [];
    try {
        $reports_query = "SELECT * FROM user_reports WHERE user_id = ? ORDER BY created_at DESC";
        $reports_stmt = $conn->prepare($reports_query);
        $reports_stmt->bind_param("i", $user_id);
        $reports_stmt->execute();
        $reports_result = $reports_stmt->get_result();
        while ($row = $reports_result->fetch_assoc()) {
            $user_reports[] = $row;
        }
    } catch (Exception $e) {
        // Table doesn't exist yet - user needs to import database/user_reports_schema.sql
        $user_reports = [];
    }
    
    // Fetch bookmarked guides
    $bookmarked_guides = [];
    try {
        $bookmarks_query = "SELECT dg.guide_id, dg.title, dg.description, ubg.bookmarked_at 
                            FROM user_bookmarked_guides ubg 
                            JOIN disaster_guides dg ON ubg.guide_id = dg.guide_id 
                            WHERE ubg.user_id = ? 
                            ORDER BY ubg.bookmarked_at DESC";
        $bookmarks_stmt = $conn->prepare($bookmarks_query);
        $bookmarks_stmt->bind_param("i", $user_id);
        $bookmarks_stmt->execute();
        $bookmarks_result = $bookmarks_stmt->get_result();
        while ($row = $bookmarks_result->fetch_assoc()) {
            $bookmarked_guides[] = $row;
        }
    } catch (Exception $e) {
        $bookmarked_guides = [];
    }
    
    // Fetch favorite hotlines
    $favorite_hotlines = [];
    try {
        $favorites_query = "SELECT h.hotline_id, h.name, h.number, h.category, ufh.favorited_at 
                            FROM user_favorite_hotlines ufh 
                            JOIN hotlines h ON ufh.hotline_id = h.hotline_id 
                            WHERE ufh.user_id = ? 
                            ORDER BY ufh.favorited_at DESC";
        $favorites_stmt = $conn->prepare($favorites_query);
        $favorites_stmt->bind_param("i", $user_id);
        $favorites_stmt->execute();
        $favorites_result = $favorites_stmt->get_result();
        while ($row = $favorites_result->fetch_assoc()) {
            $favorite_hotlines[] = $row;
        }
    } catch (Exception $e) {
        $favorite_hotlines = [];
    }
    
    // Guide info mapping
    $guide_info = [
        1 => ['url' => 'user_guide_flood.php', 'icon' => 'fa-water', 'color' => 'text-blue-400', 'name' => 'Flood Safety'],
        2 => ['url' => 'user_guide_fire.php', 'icon' => 'fa-fire', 'color' => 'text-orange-500', 'name' => 'Fire Prevention'],
        3 => ['url' => 'user_guide_earthquake.php', 'icon' => 'fa-house-crack', 'color' => 'text-yellow-500', 'name' => 'Earthquake'],
        4 => ['url' => 'user_guide_typhoon.php', 'icon' => 'fa-wind', 'color' => 'text-sky-400', 'name' => 'Typhoon'],
        5 => ['url' => 'user_guide_landslide.php', 'icon' => 'fa-hill-avalanche', 'color' => 'text-gray-500', 'name' => 'Landslide'],
        6 => ['url' => 'user_guide_tsunami.php', 'icon' => 'fa-wave-square', 'color' => 'text-teal-400', 'name' => 'Tsunami']
    ];
?>

<style>
    .profile-card {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border: 2px solid #374151;
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        border-color: #ef4444;
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.3);
    }
    
    .input-field {
        background-color: #1f2937;
        border: 2px solid #374151;
        color: #f3f4f6;
        transition: all 0.3s ease;
    }
    
    .input-field:focus {
        border-color: #ef4444;
        background-color: #111827;
        outline: none;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.5);
    }
    
    .alert-success {
        background-color: #064e3b;
        border: 2px solid #10b981;
        color: #d1fae5;
    }
    
    .alert-error {
        background-color: #7f1d1d;
        border: 2px solid #ef4444;
        color: #fecaca;
    }
</style>

<div class="pt-24 pb-16 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-white mb-2">
                <i class="fa-solid fa-user-circle text-red-500 mr-3"></i>
                My Profile
            </h1>
            <p class="text-gray-400 text-lg">Manage your personal information and account settings</p>
        </div>
        
        <!-- Success/Error Messages -->
        <?php if ($success_message): ?>
        <div class="alert-success p-4 rounded-xl mb-6 flex items-center">
            <i class="fa-solid fa-circle-check text-2xl mr-3"></i>
            <span class="font-semibold"><?php echo $success_message; ?></span>
        </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
        <div class="alert-error p-4 rounded-xl mb-6 flex items-center">
            <i class="fa-solid fa-circle-exclamation text-2xl mr-3"></i>
            <span class="font-semibold"><?php echo $error_message; ?></span>
        </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Sidebar - Profile Summary -->
            <div class="lg:col-span-1">
                <div class="profile-card p-6 rounded-xl shadow-2xl sticky top-28">
                    <div class="text-center mb-6">
                        <!-- Profile Picture -->
                        <div class="relative inline-block">
                            <?php if (!empty($user_data['profile_picture']) && file_exists($user_data['profile_picture'])): ?>
                                <img id="profile-pic-display" src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>" alt="Profile Picture" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-red-500 shadow-lg mb-4">
                            <?php else: ?>
                                <div id="profile-pic-display" class="w-32 h-32 mx-auto bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center text-white text-5xl font-bold mb-4 border-4 border-red-500 shadow-lg">
                                    <?php echo strtoupper(substr($user_data['name'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Upload Button Overlay -->
                            <label for="profile-picture-input" class="absolute bottom-4 right-0 p-2 bg-red-600 hover:bg-red-700 rounded-full cursor-pointer transition shadow-lg">
                                <i class="fa-solid fa-camera text-white"></i>
                            </label>
                            <input type="file" id="profile-picture-input" accept="image/*" class="hidden">
                        </div>
                        
                        <h2 class="text-2xl font-bold text-white mb-1"><?php echo htmlspecialchars($user_data['name']); ?></h2>
                        <p class="text-gray-400 text-sm mb-2"><?php echo htmlspecialchars($user_data['email']); ?></p>
                        <span class="inline-block px-3 py-1 bg-red-600/30 text-red-400 rounded-full text-xs font-semibold border border-red-500/50">
                            <?php echo ucfirst($user_data['role']); ?> Account
                        </span>
                    </div>
                    
                    <div class="border-t border-gray-700 pt-4 space-y-3">
                        <div class="flex items-center text-gray-300">
                            <i class="fa-solid fa-map-marker-alt text-red-500 w-6"></i>
                            <span class="text-sm"><?php echo htmlspecialchars($user_data['barangay']); ?></span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <i class="fa-solid fa-phone text-red-500 w-6"></i>
                            <span class="text-sm"><?php echo htmlspecialchars($user_data['phone_number'] ?? 'Not set'); ?></span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <i class="fa-solid fa-calendar text-red-500 w-6"></i>
                            <span class="text-sm">Joined <?php echo date('M Y', strtotime($user_data['created_at'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Content - Forms -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Personal Information Form -->
                <div class="profile-card p-8 rounded-xl shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                        <i class="fa-solid fa-user-pen text-red-500 mr-2"></i>
                        Personal Information
                    </h3>
                    
                    <form method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-user mr-2 text-red-500"></i>Full Name
                            </label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" 
                                   class="input-field w-full px-4 py-3 rounded-lg" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-envelope mr-2 text-red-500"></i>Email Address
                            </label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" 
                                   class="input-field w-full px-4 py-3 rounded-lg" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-phone mr-2 text-red-500"></i>Phone Number
                            </label>
                            <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($user_data['phone_number'] ?? ''); ?>" 
                                   class="input-field w-full px-4 py-3 rounded-lg" placeholder="+63 XXX XXX XXXX">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-map-marker-alt mr-2 text-red-500"></i>Barangay
                            </label>
                            <select name="barangay" class="input-field w-full px-4 py-3 rounded-lg" required>
                                <?php foreach ($barangays as $brgy): ?>
                                    <option value="<?php echo $brgy; ?>" <?php echo ($user_data['barangay'] == $brgy) ? 'selected' : ''; ?>>
                                        <?php echo $brgy; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <button type="submit" name="update_profile" class="btn-primary w-full px-6 py-3 rounded-lg font-bold text-white">
                            <i class="fa-solid fa-save mr-2"></i>Save Changes
                        </button>
                    </form>
                </div>
                
                <!-- Security Settings Form -->
                <div class="profile-card p-8 rounded-xl shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                        <i class="fa-solid fa-shield-halved text-red-500 mr-2"></i>
                        Security Settings
                    </h3>
                    
                    <form method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-lock mr-2 text-red-500"></i>Current Password
                            </label>
                            <input type="password" name="current_password" 
                                   class="input-field w-full px-4 py-3 rounded-lg" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-key mr-2 text-red-500"></i>New Password
                            </label>
                            <input type="password" name="new_password" 
                                   class="input-field w-full px-4 py-3 rounded-lg" required minlength="6">
                            <p class="text-xs text-gray-500 mt-1">Must be at least 6 characters long</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-check-double mr-2 text-red-500"></i>Confirm New Password
                            </label>
                            <input type="password" name="confirm_password" 
                                   class="input-field w-full px-4 py-3 rounded-lg" required minlength="6">
                        </div>
                        
                        <button type="submit" name="change_password" class="btn-primary w-full px-6 py-3 rounded-lg font-bold text-white">
                            <i class="fa-solid fa-shield-halved mr-2"></i>Change Password
                        </button>
                    </form>
                </div>
                
                <!-- My Emergency Reports -->
                <div class="profile-card p-8 rounded-xl shadow-2xl">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                        <h3 class="text-2xl font-bold text-white">
                            <i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i>
                            My Emergency Reports
                        </h3>
                        <a href="user_report_emergency.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            <i class="fa-solid fa-plus mr-2"></i>New Report
                        </a>
                    </div>
                    
                    <?php if (empty($user_reports)): ?>
                        <div class="text-center py-12">
                            <i class="fa-solid fa-inbox text-6xl text-gray-600 mb-4"></i>
                            <p class="text-gray-400 mb-4">You haven't submitted any emergency reports yet</p>
                            <a href="user_report_emergency.php" class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                Report an Emergency
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($user_reports as $report): 
                                $status_colors = [
                                    'pending' => ['bg' => 'bg-yellow-600/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/50'],
                                    'accepted' => ['bg' => 'bg-green-600/20', 'text' => 'text-green-400', 'border' => 'border-green-500/50'],
                                    'rejected' => ['bg' => 'bg-red-600/20', 'text' => 'text-red-400', 'border' => 'border-red-500/50']
                                ];
                                $status_style = $status_colors[$report['status']];
                            ?>
                            <div id="report-<?php echo $report['report_id']; ?>" class="bg-gray-800 p-5 rounded-lg border-l-4 <?php echo $status_style['border']; ?> hover:bg-gray-700 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-1 text-xs font-bold rounded <?php echo $status_style['bg'] . ' ' . $status_style['text']; ?> border <?php echo $status_style['border']; ?>">
                                                <?php echo strtoupper($report['status']); ?>
                                            </span>
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-700 text-gray-300">
                                                <?php echo ucfirst($report['incident_type']); ?>
                                            </span>
                                        </div>
                                        <h4 class="text-white font-bold text-lg"><?php echo htmlspecialchars($report['title']); ?></h4>
                                        <p class="text-gray-400 text-sm mt-1">
                                            <i class="fa-solid fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($report['location']); ?>, <?php echo htmlspecialchars($report['barangay']); ?>
                                        </p>
                                        <p class="text-gray-500 text-xs mt-2">
                                            <i class="fa-solid fa-clock mr-1"></i>Reported <?php echo date('M d, Y g:i A', strtotime($report['created_at'])); ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-2 ml-4">
                                        <?php if ($report['photo_path']): ?>
                                            <img src="<?php echo htmlspecialchars($report['photo_path']); ?>" alt="Report photo" class="w-20 h-20 object-cover rounded-lg">
                                        <?php endif; ?>
                                        <?php if ($report['status'] === 'pending'): ?>
                                            <button onclick="deleteReport(<?php echo $report['report_id']; ?>)" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-xs font-semibold transition flex items-center justify-center whitespace-nowrap">
                                                <i class="fa-solid fa-trash mr-1"></i>Delete
                                            </button>
                                        <?php else: ?>
                                            <button disabled class="bg-gray-700 text-gray-500 px-3 py-2 rounded text-xs font-semibold cursor-not-allowed flex items-center justify-center whitespace-nowrap" title="Cannot delete <?php echo $report['status']; ?> reports">
                                                <i class="fa-solid fa-lock mr-1"></i>Locked
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($report['admin_notes']): ?>
                                    <div class="mt-3 p-3 bg-gray-900 rounded border border-gray-700">
                                        <p class="text-xs font-semibold text-gray-400 mb-1">Admin Response:</p>
                                        <p class="text-sm text-gray-300"><?php echo htmlspecialchars($report['admin_notes']); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Bookmarked Guides -->
                <div class="profile-card p-8 rounded-xl shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                        <i class="fa-solid fa-bookmark text-red-500 mr-2"></i>
                        Bookmarked Disaster Guides
                    </h3>
                    
                    <?php if (empty($bookmarked_guides)): ?>
                        <div class="text-center py-12">
                            <i class="fa-solid fa-bookmark text-6xl text-gray-600 mb-4"></i>
                            <p class="text-gray-400 mb-4">You haven't bookmarked any guides yet</p>
                            <a href="user_guides.php" class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                Browse Disaster Guides
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($bookmarked_guides as $bookmark): 
                                $info = $guide_info[$bookmark['guide_id']];
                            ?>
                            <a href="<?php echo $info['url']; ?>" class="flex items-start p-4 bg-gray-800 hover:bg-gray-700 rounded-lg transition group border border-gray-700 hover:border-red-500">
                                <i class="fa-solid <?php echo $info['icon']; ?> <?php echo $info['color']; ?> text-2xl mr-4 flex-shrink-0 mt-1"></i>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-bold mb-1 group-hover:text-red-400 transition"><?php echo htmlspecialchars($bookmark['title']); ?></h4>
                                    <p class="text-gray-400 text-sm line-clamp-2 mb-2"><?php echo htmlspecialchars($bookmark['description']); ?></p>
                                    <p class="text-gray-500 text-xs">
                                        <i class="fa-solid fa-clock mr-1"></i>Saved <?php echo date('M d, Y', strtotime($bookmark['bookmarked_at'])); ?>
                                    </p>
                                </div>
                                <i class="fa-solid fa-arrow-right text-red-500 ml-2 flex-shrink-0 mt-2 opacity-0 group-hover:opacity-100 transition"></i>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Favorite Hotlines -->
                <div class="profile-card p-8 rounded-xl shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                        <i class="fa-solid fa-star text-red-500 mr-2"></i>
                        Favorite Emergency Hotlines
                    </h3>
                    
                    <?php if (empty($favorite_hotlines)): ?>
                        <div class="text-center py-12">
                            <i class="fa-solid fa-star text-6xl text-gray-600 mb-4"></i>
                            <p class="text-gray-400 mb-4">You haven't added any favorite hotlines yet</p>
                            <a href="user_hotlines.php" class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                View Emergency Hotlines
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($favorite_hotlines as $hotline): ?>
                            <div class="p-4 bg-gray-800 rounded-lg border border-gray-700 hover:border-red-500 transition">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h4 class="text-white font-bold text-lg"><?php echo htmlspecialchars($hotline['name']); ?></h4>
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-gray-700 text-gray-300 mt-1">
                                            <?php echo ucfirst($hotline['category']); ?>
                                        </span>
                                    </div>
                                    <i class="fa-solid fa-star text-yellow-500 text-xl"></i>
                                </div>
                                <a href="tel:<?php echo $hotline['number']; ?>" class="flex items-center text-red-400 hover:text-red-300 font-semibold mb-2">
                                    <i class="fa-solid fa-phone mr-2"></i><?php echo htmlspecialchars($hotline['number']); ?>
                                </a>
                                <p class="text-gray-500 text-xs">
                                    <i class="fa-solid fa-clock mr-1"></i>Added <?php echo date('M d, Y', strtotime($hotline['favorited_at'])); ?>
                                </p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Notification Preferences -->
                <div class="profile-card p-8 rounded-xl shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                        <i class="fa-solid fa-bell text-red-500 mr-2"></i>
                        Notification Preferences
                    </h3>
                    
                    <div class="space-y-4">
                        <label class="flex items-center justify-between p-4 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700 transition">
                            <div class="flex items-center">
                                <i class="fa-solid fa-triangle-exclamation text-red-500 mr-3 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-white">Emergency Alerts</p>
                                    <p class="text-sm text-gray-400">Receive critical disaster alerts</p>
                                </div>
                            </div>
                            <input type="checkbox" checked class="w-6 h-6 text-red-600 rounded">
                        </label>
                        
                        <label class="flex items-center justify-between p-4 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700 transition">
                            <div class="flex items-center">
                                <i class="fa-solid fa-cloud text-blue-500 mr-3 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-white">Weather Updates</p>
                                    <p class="text-sm text-gray-400">Daily weather forecasts and warnings</p>
                                </div>
                            </div>
                            <input type="checkbox" checked class="w-6 h-6 text-red-600 rounded">
                        </label>
                        
                        <label class="flex items-center justify-between p-4 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700 transition">
                            <div class="flex items-center">
                                <i class="fa-solid fa-envelope text-purple-500 mr-3 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-white">Email Notifications</p>
                                    <p class="text-sm text-gray-400">Receive alerts via email</p>
                                </div>
                            </div>
                            <input type="checkbox" class="w-6 h-6 text-red-600 rounded">
                        </label>
                        
                        <label class="flex items-center justify-between p-4 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700 transition">
                            <div class="flex items-center">
                                <i class="fa-solid fa-mobile-screen text-green-500 mr-3 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-white">SMS Alerts</p>
                                    <p class="text-sm text-gray-400">Receive text messages for urgent alerts</p>
                                </div>
                            </div>
                            <input type="checkbox" class="w-6 h-6 text-red-600 rounded">
                        </label>
                    </div>
                    
                    <button class="btn-primary w-full px-6 py-3 rounded-lg font-bold text-white mt-6">
                        <i class="fa-solid fa-save mr-2"></i>Save Preferences
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const profilePictureInput = document.getElementById('profile-picture-input');
    const profilePicDisplay = document.getElementById('profile-pic-display');
    
    // Handle profile picture upload
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                showToast('Please upload a valid image file (JPG, PNG, or GIF)', 'error');
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showToast('File is too large. Maximum size is 5MB', 'error');
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                if (profilePicDisplay.tagName === 'IMG') {
                    profilePicDisplay.src = e.target.result;
                } else {
                    // Replace div with img
                    const img = document.createElement('img');
                    img.id = 'profile-pic-display';
                    img.src = e.target.result;
                    img.alt = 'Profile Picture';
                    img.className = 'w-32 h-32 mx-auto rounded-full object-cover border-4 border-red-500 shadow-lg mb-4';
                    profilePicDisplay.replaceWith(img);
                }
            };
            reader.readAsDataURL(file);
            
            // Upload to server
            const formData = new FormData();
            formData.append('profile_picture', file);
            
            // Show loading state
            showToast('Uploading profile picture...', 'success');
            
            fetch('ajax/upload_profile_picture.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    // Reload page after 1.5 seconds to update header
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error uploading profile picture', 'error');
            });
        });
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
    
    // Delete report function
    function deleteReport(reportId) {
        if (!confirm('Are you sure you want to delete this emergency report? This action cannot be undone.')) {
            return;
        }
        
        const reportCard = document.getElementById('report-' + reportId);
        
        fetch('ajax/delete_report.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ report_id: reportId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the card with animation
                reportCard.style.opacity = '0';
                reportCard.style.transform = 'translateX(100px)';
                reportCard.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    reportCard.remove();
                    
                    // Check if there are no more reports
                    const reportsContainer = reportCard.parentElement;
                    if (reportsContainer && reportsContainer.children.length === 0) {
                        location.reload();
                    }
                }, 300);
                
                showToast(data.message, 'success');
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error deleting report. Please try again.', 'error');
        });
    }
});
</script>

<?php include 'user_footer.php'; ?>
