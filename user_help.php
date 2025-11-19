<?php 
    include 'user_header.php';
?>

<style>
    .help-card {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border: 2px solid #374151;
        transition: all 0.3s ease;
    }
    
    .help-card:hover {
        border-color: #ef4444;
        box-shadow: 0 0 25px rgba(239, 68, 68, 0.3);
    }
    
    .faq-item {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .faq-item:hover {
        background-color: #1f2937;
    }
    
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .faq-item.active .faq-answer {
        max-height: 500px;
    }
    
    .faq-item.active .fa-chevron-down {
        transform: rotate(180deg);
    }
</style>

<div class="pt-24 pb-16 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">
        
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-white mb-2">
                <i class="fa-solid fa-circle-question text-red-500 mr-3"></i>
                Help & Support
            </h1>
            <p class="text-gray-400 text-lg">Find answers to common questions or contact our support team</p>
        </div>
        
        <!-- Quick Help Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="help-card p-6 rounded-xl shadow-xl text-center">
                <i class="fa-solid fa-book text-5xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-bold text-white mb-2">User Guide</h3>
                <p class="text-gray-400 text-sm mb-4">Learn how to use SafeMati features</p>
                <a href="#" class="inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                    Read Guide
                </a>
            </div>
            
            <div class="help-card p-6 rounded-xl shadow-xl text-center">
                <i class="fa-solid fa-video text-5xl text-blue-500 mb-4"></i>
                <h3 class="text-xl font-bold text-white mb-2">Video Tutorials</h3>
                <p class="text-gray-400 text-sm mb-4">Watch step-by-step tutorials</p>
                <a href="#" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                    Watch Videos
                </a>
            </div>
            
            <div class="help-card p-6 rounded-xl shadow-xl text-center">
                <i class="fa-solid fa-headset text-5xl text-green-500 mb-4"></i>
                <h3 class="text-xl font-bold text-white mb-2">Contact Support</h3>
                <p class="text-gray-400 text-sm mb-4">Get help from our team</p>
                <a href="#contact-form" class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                    Contact Us
                </a>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="help-card p-8 rounded-xl shadow-2xl mb-12">
            <h2 class="text-3xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                <i class="fa-solid fa-question-circle text-red-500 mr-2"></i>
                Frequently Asked Questions
            </h2>
            
            <div class="space-y-4">
                <div class="faq-item p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">How do I update my profile information?</h3>
                        <i class="fa-solid fa-chevron-down text-red-500 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-answer mt-4 text-gray-300">
                        <p>To update your profile, go to the Profile menu from the navigation or click your profile icon and select "My Profile". You can edit your name, email, phone number, and barangay information.</p>
                    </div>
                </div>
                
                <div class="faq-item p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">How do I receive emergency alerts?</h3>
                        <i class="fa-solid fa-chevron-down text-red-500 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-answer mt-4 text-gray-300">
                        <p>Emergency alerts are automatically sent to all registered users based on their barangay. Make sure your location settings are enabled and your contact information is up to date in your profile.</p>
                    </div>
                </div>
                
                <div class="faq-item p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">What should I do during a disaster?</h3>
                        <i class="fa-solid fa-chevron-down text-red-500 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-answer mt-4 text-gray-300">
                        <p>Visit our Disaster Guides section for detailed information on how to prepare for and respond to different types of disasters. You can also check the Emergency Hotlines page for immediate assistance contacts.</p>
                    </div>
                </div>
                
                <div class="faq-item p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">How can I mark myself as safe during an alert?</h3>
                        <i class="fa-solid fa-chevron-down text-red-500 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-answer mt-4 text-gray-300">
                        <p>When viewing an active alert, you'll see a "Mark as Safe" button. Click this to let others know you're safe. You can also undo this action if needed by clicking the button again.</p>
                    </div>
                </div>
                
                <div class="faq-item p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">Can I save favorite hotlines?</h3>
                        <i class="fa-solid fa-chevron-down text-red-500 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-answer mt-4 text-gray-300">
                        <p>Yes! In the Emergency Hotlines page, click the star icon on any hotline to add it to your favorites. Your favorite hotlines will appear at the top for quick access.</p>
                    </div>
                </div>
                
                <div class="faq-item p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">How do I change my password?</h3>
                        <i class="fa-solid fa-chevron-down text-red-500 transition-transform duration-300"></i>
                    </div>
                    <div class="faq-answer mt-4 text-gray-300">
                        <p>Navigate to your Profile page and scroll to the Security Settings section. Enter your current password, then your new password twice to confirm the change.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div id="contact-form" class="help-card p-8 rounded-xl shadow-2xl">
            <h2 class="text-3xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
                <i class="fa-solid fa-envelope text-red-500 mr-2"></i>
                Contact Support
            </h2>
            
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Subject</label>
                    <input type="text" class="w-full px-4 py-3 bg-gray-800 border-2 border-gray-700 focus:border-red-500 text-white rounded-lg" 
                           placeholder="What do you need help with?" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Category</label>
                    <select class="w-full px-4 py-3 bg-gray-800 border-2 border-gray-700 focus:border-red-500 text-white rounded-lg" required>
                        <option>Technical Issue</option>
                        <option>Account Problem</option>
                        <option>Feature Request</option>
                        <option>General Inquiry</option>
                        <option>Report a Bug</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Message</label>
                    <textarea rows="5" class="w-full px-4 py-3 bg-gray-800 border-2 border-gray-700 focus:border-red-500 text-white rounded-lg" 
                              placeholder="Describe your issue or question in detail..." required></textarea>
                </div>
                
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg font-bold transition">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Send Message
                </button>
            </form>
        </div>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', function() {
            // Close all other items
            document.querySelectorAll('.faq-item').forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
            // Toggle current item
            this.classList.toggle('active');
        });
    });
});
</script>

<?php include 'user_footer.php'; ?>
