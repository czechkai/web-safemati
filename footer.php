<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Design</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
</head>
<body class="bg-gray-900 min-h-screen text-white">



<!-- Footer Section -->
<footer class="bg-[#101010] text-gray-300 border-t border-red-700/50 pt-12 pb-8 shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Column 1: Branding and Mission -->
            <div>
                <h3 class="text-xl font-bold text-red-500 mb-4">SafeMati</h3>
                <p class="text-sm">Empowering Mati City with real-time alerts and comprehensive disaster preparedness guides for a resilient community.</p>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-red-500 transition duration-200">Home</a></li>
                    <li><a href="#" class="hover:text-red-500 transition duration-200">About Us</a></li>
                    <li><a href="#" class="hover:text-red-500 transition duration-200">Disaster Guides</a></li>
                    <li><a href="#" class="hover:text-red-500 transition duration-200">Emergency Hotlines</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Information -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Contact</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start">
                        <i class="fa-solid fa-map-marker-alt text-red-500 mt-1 mr-3"></i>
                        <span>Mati City Hall Compound, Dahican, Mati City, Davao Oriental 8200</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-solid fa-envelope text-red-500 mr-3"></i>
                        <a href="mailto:info@safemati.gov" class="hover:text-red-500">info@safemati.gov</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-solid fa-phone text-red-500 mr-3"></i>
                        <span class="text-white font-medium">(087) 388-0000</span>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Social Media -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Stay Connected</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-red-500 hover:text-white transition duration-200 text-2xl" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <!-- Discord Icon Added -->
                    <a href="#" class="text-red-500 hover:text-white transition duration-200 text-2xl" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="text-red-500 hover:text-white transition duration-200 text-2xl" aria-label="Discord"><i class="fa-brands fa-discord"></i></a>
                </div>
            </div>
        </div>

        <!-- Copyright and Separator -->
        <div class="mt-12 border-t border-gray-700/50 pt-6 text-center text-xs">
            &copy; <?php echo date("Y"); ?> SafeMati. All rights reserved. 
        </div>
    </div>
</footer>


</body>
</html>