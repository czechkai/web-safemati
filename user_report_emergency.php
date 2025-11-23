<?php 
    include 'user_header.php';
    require_once 'db_connect.php';
    
    $user_id = $_SESSION['user_id'];
    $success_message = '';
    $error_message = '';
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_report'])) {
        $incident_type = $_POST['incident_type'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $barangay = $_POST['barangay'];
        $latitude = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
        $longitude = !empty($_POST['longitude']) ? $_POST['longitude'] : null;
        
        // Handle photo upload
        $photo_path = null;
        if (isset($_FILES['incident_photo']) && $_FILES['incident_photo']['error'] == 0) {
            $upload_dir = 'uploads/reports/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_extension = pathinfo($_FILES['incident_photo']['name'], PATHINFO_EXTENSION);
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array(strtolower($file_extension), $allowed_extensions)) {
                $filename = 'report_' . $user_id . '_' . time() . '.' . $file_extension;
                $photo_path = $upload_dir . $filename;
                move_uploaded_file($_FILES['incident_photo']['tmp_name'], $photo_path);
            }
        }
        
        // Insert report
        $insert_query = "INSERT INTO user_reports (user_id, incident_type, title, description, location, barangay, latitude, longitude, photo_path, status, priority) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'medium')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("isssssdds", $user_id, $incident_type, $title, $description, $location, $barangay, $latitude, $longitude, $photo_path);
        
        if ($stmt->execute()) {
            $report_id = $conn->insert_id;
            
            // Create admin notification
            $notif_message = "New {$incident_type} report from " . $_SESSION['user_name'] . " in {$barangay}";
            $notif_query = "INSERT INTO admin_notifications (report_id, type, message) VALUES (?, 'new_report', ?)";
            $notif_stmt = $conn->prepare($notif_query);
            $notif_stmt->bind_param("is", $report_id, $notif_message);
            $notif_stmt->execute();
            
            $success_message = "Your emergency report has been submitted successfully! Authorities will be notified.";
        } else {
            $error_message = "Error submitting report. Please try again.";
        }
    }
    
    // Barangays list
    $barangays = array(
        'Badas', 'Bobon', 'Buso', 'Cabuaya', 'Central (Pob.)', 'Culian', 'Dahican',
        'Danao', 'Dawan', 'Don Enrique Lopez', 'Don Martin Marundan', 'Don Salvador Lopez Sr.',
        'Langka', 'Lawigan', 'Libudon', 'Luban', 'Macambol', 'Mamali', 'Matiao',
        'Mayo', 'Sainz', 'Sanghay', 'Tagabakid', 'Tagbinonga', 'Taguibo', 'Tamisan'
    );
?>

<style>
    .report-form {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border: 2px solid #374151;
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
    
    .incident-type-card {
        background: #1f2937;
        border: 2px solid #374151;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .incident-type-card:hover {
        border-color: #ef4444;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(239, 68, 68, 0.3);
    }
    
    .incident-type-card.selected {
        border-color: #ef4444;
        background: #7f1d1d;
    }
</style>

<div class="pt-24 pb-16 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Page Header -->
        <div class="mb-8">
            <a href="user_dashboard.php" class="text-red-500 hover:text-red-400 mb-4 inline-flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
            <h1 class="text-4xl font-extrabold text-white mb-2 mt-4">
                <i class="fa-solid fa-triangle-exclamation text-red-500 mr-3"></i>
                Report Emergency or Incident
            </h1>
            <p class="text-gray-400 text-lg">Help authorities respond faster by reporting emergencies in your area</p>
        </div>
        
        <!-- Success/Error Messages -->
        <?php if ($success_message): ?>
        <div class="bg-green-900/30 border-2 border-green-500 text-green-300 p-4 rounded-xl mb-6 flex items-center">
            <i class="fa-solid fa-circle-check text-2xl mr-3"></i>
            <span class="font-semibold"><?php echo $success_message; ?></span>
        </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
        <div class="bg-red-900/30 border-2 border-red-500 text-red-300 p-4 rounded-xl mb-6 flex items-center">
            <i class="fa-solid fa-circle-exclamation text-2xl mr-3"></i>
            <span class="font-semibold"><?php echo $error_message; ?></span>
        </div>
        <?php endif; ?>
        
        <!-- Emergency Info Banner -->
        <div class="bg-red-900/20 border-l-4 border-red-500 p-6 rounded-lg mb-8">
            <h3 class="text-white font-bold text-lg mb-2 flex items-center">
                <i class="fa-solid fa-info-circle text-red-500 mr-2"></i>
                Important Information
            </h3>
            <ul class="text-gray-300 text-sm space-y-1 ml-8 list-disc">
                <li>For life-threatening emergencies, call 911 immediately</li>
                <li>Provide accurate location details to help responders find you</li>
                <li>Include photos if safe to do so</li>
                <li>Your report will be reviewed by authorities within minutes</li>
            </ul>
        </div>
        
        <!-- Report Form -->
        <form method="POST" enctype="multipart/form-data" class="report-form p-8 rounded-xl shadow-2xl">
            
            <!-- Step 1: Select Incident Type -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-4">
                    <span class="bg-red-600 text-white w-8 h-8 rounded-full inline-flex items-center justify-center mr-2">1</span>
                    Select Incident Type
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="fire" class="hidden incident-radio" required>
                        <i class="fa-solid fa-fire text-4xl text-red-500 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Fire</p>
                    </label>
                    
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="flood" class="hidden incident-radio">
                        <i class="fa-solid fa-water text-4xl text-blue-400 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Flood</p>
                    </label>
                    
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="accident" class="hidden incident-radio">
                        <i class="fa-solid fa-car-burst text-4xl text-yellow-500 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Accident</p>
                    </label>
                    
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="earthquake" class="hidden incident-radio">
                        <i class="fa-solid fa-house-crack text-4xl text-orange-500 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Earthquake</p>
                    </label>
                    
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="landslide" class="hidden incident-radio">
                        <i class="fa-solid fa-mountain text-4xl text-gray-400 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Landslide</p>
                    </label>
                    
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="medical" class="hidden incident-radio">
                        <i class="fa-solid fa-heart-pulse text-4xl text-pink-500 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Medical</p>
                    </label>
                    
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="crime" class="hidden incident-radio">
                        <i class="fa-solid fa-shield-alt text-4xl text-purple-500 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Crime</p>
                    </label>
                    
                    <label class="incident-type-card p-4 rounded-xl text-center">
                        <input type="radio" name="incident_type" value="other" class="hidden incident-radio">
                        <i class="fa-solid fa-ellipsis text-4xl text-gray-500 mb-2 block"></i>
                        <p class="text-white font-semibold text-sm">Other</p>
                    </label>
                </div>
            </div>
            
            <!-- Step 2: Incident Details -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-4">
                    <span class="bg-red-600 text-white w-8 h-8 rounded-full inline-flex items-center justify-center mr-2">2</span>
                    Incident Details
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <i class="fa-solid fa-heading mr-2 text-red-500"></i>Title / Brief Description
                        </label>
                        <input type="text" name="title" class="input-field w-full px-4 py-3 rounded-lg" 
                               placeholder="e.g., House Fire on Main Street" required maxlength="255">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <i class="fa-solid fa-align-left mr-2 text-red-500"></i>Detailed Description
                        </label>
                        <textarea name="description" class="input-field w-full px-4 py-3 rounded-lg" rows="5" 
                                  placeholder="Provide as much detail as possible: What happened? When? Are there injuries? Is it still ongoing?" required></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Step 3: Location -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-4">
                    <span class="bg-red-600 text-white w-8 h-8 rounded-full inline-flex items-center justify-center mr-2">3</span>
                    Location Information
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <i class="fa-solid fa-map-marker-alt mr-2 text-red-500"></i>Specific Location / Address
                        </label>
                        <input type="text" name="location" class="input-field w-full px-4 py-3 rounded-lg" 
                               placeholder="e.g., 123 Main St, near City Hall" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <i class="fa-solid fa-map mr-2 text-red-500"></i>Barangay
                        </label>
                        <select name="barangay" class="input-field w-full px-4 py-3 rounded-lg" required>
                            <option value="">Select Barangay</option>
                            <?php foreach ($barangays as $brgy): ?>
                                <option value="<?php echo $brgy; ?>" <?php echo ($_SESSION['user_barangay'] == $brgy) ? 'selected' : ''; ?>>
                                    <?php echo $brgy; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-location-dot mr-2 text-red-500"></i>Latitude (Optional)
                            </label>
                            <input type="text" name="latitude" id="latitude" class="input-field w-full px-4 py-3 rounded-lg" 
                                   placeholder="Auto-filled by GPS" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <i class="fa-solid fa-location-dot mr-2 text-red-500"></i>Longitude (Optional)
                            </label>
                            <input type="text" name="longitude" id="longitude" class="input-field w-full px-4 py-3 rounded-lg" 
                                   placeholder="Auto-filled by GPS" readonly>
                        </div>
                    </div>
                    
                    <button type="button" id="get-location-btn" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        <i class="fa-solid fa-crosshairs mr-2"></i>Get My Current Location
                    </button>
                </div>
            </div>
            
            <!-- Step 4: Photo Evidence -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-4">
                    <span class="bg-red-600 text-white w-8 h-8 rounded-full inline-flex items-center justify-center mr-2">4</span>
                    Photo Evidence (Optional)
                </h3>
                
                <div class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center hover:border-red-500 transition">
                    <i class="fa-solid fa-camera text-5xl text-gray-500 mb-3"></i>
                    <p class="text-gray-300 mb-2">Upload a photo of the incident (if safe to do so)</p>
                    <p class="text-gray-500 text-sm mb-4">Maximum file size: 5MB | Formats: JPG, PNG, GIF</p>
                    <input type="file" name="incident_photo" id="incident-photo" accept="image/*" class="hidden">
                    <label for="incident-photo" class="inline-block bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg cursor-pointer font-semibold transition">
                        <i class="fa-solid fa-upload mr-2"></i>Choose Photo
                    </label>
                    <div id="photo-preview" class="mt-4 hidden">
                        <img id="preview-image" class="max-w-full h-48 mx-auto rounded-lg border-2 border-gray-600">
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" name="submit_report" class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-8 py-4 rounded-lg font-bold text-lg transition transform hover:scale-[1.02]">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Submit Emergency Report
                </button>
                <a href="user_dashboard.php" class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-4 rounded-lg font-bold text-lg transition text-center">
                    Cancel
                </a>
            </div>
        </form>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Incident type selection
    const incidentRadios = document.querySelectorAll('.incident-radio');
    const incidentCards = document.querySelectorAll('.incident-type-card');
    
    incidentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            incidentCards.forEach(c => c.classList.remove('selected'));
            // Add selected class to clicked card
            this.classList.add('selected');
            // Check the radio button
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
    
    // Photo preview
    const photoInput = document.getElementById('incident-photo');
    const photoPreview = document.getElementById('photo-preview');
    const previewImage = document.getElementById('preview-image');
    
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                photoPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Get current location
    const getLocationBtn = document.getElementById('get-location-btn');
    const latInput = document.getElementById('latitude');
    const lonInput = document.getElementById('longitude');
    
    getLocationBtn.addEventListener('click', function() {
        if (navigator.geolocation) {
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Getting location...';
            this.disabled = true;
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    latInput.value = position.coords.latitude.toFixed(6);
                    lonInput.value = position.coords.longitude.toFixed(6);
                    getLocationBtn.innerHTML = '<i class="fa-solid fa-check mr-2"></i>Location Captured';
                    getLocationBtn.classList.add('bg-green-600');
                    setTimeout(() => {
                        getLocationBtn.disabled = false;
                        getLocationBtn.classList.remove('bg-green-600');
                        getLocationBtn.innerHTML = '<i class="fa-solid fa-crosshairs mr-2"></i>Get My Current Location';
                    }, 2000);
                },
                function(error) {
                    alert('Unable to get your location. Please enter coordinates manually or enable location services.');
                    getLocationBtn.innerHTML = '<i class="fa-solid fa-crosshairs mr-2"></i>Get My Current Location';
                    getLocationBtn.disabled = false;
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    });
});
</script>

<?php include 'user_footer.php'; ?>
