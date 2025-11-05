@props([
    'university' => 'Central Luzon State University',
    'year' => date('Y'),
    'email' => 'lms@clsu.edu.ph',
    'phone' => '(044) 456-0707',
    'address' => 'Science City of Muñoz, Nueva Ecija'
])

<footer class="bg-gray-50 border-t border-gray-200 py-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-university text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">CLSU LMS</h3>
                        <p class="text-xs text-gray-500">Learning Management System</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    Empowering students with modern learning tools and resources for academic excellence.
                </p>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-800 mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('student.courses') }}" class="text-gray-600 hover:text-green-600 transition">My Courses</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-800 mb-4">Resources</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition">Study Materials</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition">Tutorials</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition">Help Center</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-800 mb-4">Contact</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-green-600"></i>
                        {{ $email }}
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-phone mr-2 text-green-600"></i>
                        {{ $phone }}
                    </p>
                    <p class="flex items-start">
                        <i class="fas fa-map-marker-alt mr-2 text-green-600 mt-1"></i>
                        {{ $address }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-500">
                © {{ $year }} {{ $university }}. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-sm text-gray-500 hover:text-green-600 transition">Privacy Policy</a>
                <a href="#" class="text-sm text-gray-500 hover:text-green-600 transition">Terms of Service</a>
                <a href="#" class="text-sm text-gray-500 hover:text-green-600 transition">Support</a>
            </div>
        </div>
    </div>
</footer>
