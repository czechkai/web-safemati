<?php 
    include 'user_header.php';
    require_once 'db_connect.php';
    
    $user_id = $_SESSION['user_id'];
    $success_message = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $feedback_type = $_POST['feedback_type'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $rating = $_POST['rating'] ?? 0;
        
        // Here you would insert into database
        // For now, just show success message
        $success_message = "Thank you for your feedback! We appreciate your input.";
    }
?>

<style>
    .feedback-card {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border: 2px solid #374151;
        transition: all 0.3s ease;
    }
    
    .feedback-card:hover {
        border-color: #ef4444;
    }
    
    .rating-star {
        font-size: 2rem;
        color: #4b5563;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .rating-star:hover,
    .rating-star.active {
        color: #fbbf24;
        transform: scale(1.2);
    }
    
    .feedback-type-card {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .feedback-type-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 25px rgba(239, 68, 68, 0.3);
    }
    
    .feedback-type-card.selected {
        border-color: #ef4444;
        background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
    }
</style>

<div class="pt-24 pb-16 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-white mb-2">
                <i class="fa-solid fa-comment-dots text-red-500 mr-3"></i>
                Give Feedback
            </h1>
            <p class="text-gray-400 text-lg">Help us improve SafeMati by sharing your thoughts and suggestions</p>
        </div>
        
        <?php if ($success_message): ?>
        <div class="bg-green-900/30 border-2 border-green-500 text-green-300 p-6 rounded-xl mb-8 flex items-center">
            <i class="fa-solid fa-circle-check text-3xl mr-4"></i>
            <div>
                <p class="font-bold text-lg"><?php echo $success_message; ?></p>
                <p class="text-sm mt-1">Your feedback helps us make SafeMati better for everyone.</p>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Feedback Type Selection -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-4">What type of feedback do you have?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="feedback-type-card feedback-card p-6 rounded-xl text-center border-2 border-gray-700" 
                     data-type="suggestion" onclick="selectFeedbackType(this)">
                    <i class="fa-solid fa-lightbulb text-5xl text-yellow-500 mb-3"></i>
                    <h3 class="text-lg font-bold text-white">Suggestion</h3>
                    <p class="text-sm text-gray-400 mt-2">Share ideas for new features</p>
                </div>
                
                <div class="feedback-type-card feedback-card p-6 rounded-xl text-center border-2 border-gray-700" 
                     data-type="bug" onclick="selectFeedbackType(this)">
                    <i class="fa-solid fa-bug text-5xl text-red-500 mb-3"></i>
                    <h3 class="text-lg font-bold text-white">Bug Report</h3>
                    <p class="text-sm text-gray-400 mt-2">Report technical issues</p>
                </div>
                
                <div class="feedback-type-card feedback-card p-6 rounded-xl text-center border-2 border-gray-700" 
                     data-type="general" onclick="selectFeedbackType(this)">
                    <i class="fa-solid fa-message text-5xl text-blue-500 mb-3"></i>
                    <h3 class="text-lg font-bold text-white">General Feedback</h3>
                    <p class="text-sm text-gray-400 mt-2">Share your experience</p>
                </div>
            </div>
        </div>
        
        <!-- Feedback Form -->
        <div class="feedback-card p-8 rounded-xl shadow-2xl">
            <form method="POST" class="space-y-6">
                <input type="hidden" name="feedback_type" id="feedback_type" value="general">
                
                <!-- Rating -->
                <div>
                    <label class="block text-lg font-semibold text-white mb-3">How would you rate SafeMati?</label>
                    <div class="flex justify-center space-x-2" id="rating-stars">
                        <i class="rating-star fa-solid fa-star" data-rating="1"></i>
                        <i class="rating-star fa-solid fa-star" data-rating="2"></i>
                        <i class="rating-star fa-solid fa-star" data-rating="3"></i>
                        <i class="rating-star fa-solid fa-star" data-rating="4"></i>
                        <i class="rating-star fa-solid fa-star" data-rating="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="rating" value="0">
                </div>
                
                <!-- Subject -->
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">
                        <i class="fa-solid fa-heading text-red-500 mr-2"></i>Subject
                    </label>
                    <input type="text" name="subject" class="w-full px-4 py-3 bg-gray-800 border-2 border-gray-700 focus:border-red-500 text-white rounded-lg" 
                           placeholder="Brief summary of your feedback" required>
                </div>
                
                <!-- Message -->
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">
                        <i class="fa-solid fa-pen text-red-500 mr-2"></i>Your Feedback
                    </label>
                    <textarea name="message" rows="6" class="w-full px-4 py-3 bg-gray-800 border-2 border-gray-700 focus:border-red-500 text-white rounded-lg" 
                              placeholder="Tell us more about your experience, suggestion, or issue..." required></textarea>
                </div>
                
                <!-- Contact Permission -->
                <div class="flex items-center p-4 bg-gray-800 rounded-lg">
                    <input type="checkbox" name="allow_contact" id="allow_contact" class="w-5 h-5 text-red-600 rounded mr-3">
                    <label for="allow_contact" class="text-gray-300">
                        You can contact me if you need more information about this feedback
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg font-bold text-lg transition shadow-xl">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Submit Feedback
                </button>
            </form>
        </div>
        
        <!-- Why Feedback Matters -->
        <div class="mt-8 p-6 bg-gray-800/50 rounded-xl border-2 border-gray-700">
            <h3 class="text-xl font-bold text-white mb-3">
                <i class="fa-solid fa-heart text-red-500 mr-2"></i>
                Why Your Feedback Matters
            </h3>
            <p class="text-gray-300">
                SafeMati is continuously evolving to better serve the community of Mati City. Your feedback helps us identify areas for improvement, 
                prioritize new features, and ensure the platform meets your needs during critical situations. Every piece of feedback is reviewed by 
                our team and contributes to making SafeMati a more effective disaster preparedness tool.
            </p>
        </div>
        
    </div>
</div>

<script>
// Rating stars functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            // Update star appearance
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = this.getAttribute('data-rating');
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = '#fbbf24';
                }
            });
        });
    });
    
    document.getElementById('rating-stars').addEventListener('mouseleave', function() {
        const currentRating = ratingInput.value;
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.style.color = '#fbbf24';
            } else {
                s.style.color = '#4b5563';
            }
        });
    });
});

function selectFeedbackType(card) {
    // Remove selected class from all cards
    document.querySelectorAll('.feedback-type-card').forEach(c => {
        c.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    card.classList.add('selected');
    
    // Update hidden input
    const type = card.getAttribute('data-type');
    document.getElementById('feedback_type').value = type;
}
</script>

<?php include 'user_footer.php'; ?>
