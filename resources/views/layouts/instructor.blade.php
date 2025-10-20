@extends('layouts.base')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/instructor.css') }}">
@endpush

@section('body')

    <div class="layout-container">
        <x-instructor.layout.sidebar :user="$user" :notifications="$notifications" />

        <!-- Main Area -->
        <div class="main-area">
            <!-- Enhanced Header -->
            <x-instructor.layout.header :user="$user" />

            <!-- Main Content -->
            <main class="content-area">
                @yield('content')
            </main>
        </div>

    </div>

    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <!-- Floating Action Button -->
    <button class="fab" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>
    @push('scripts')
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // Update current date and time
        function updateDateTime() {
            const now = new Date();
            const dateOptions = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const timeOptions = {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };

            document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', dateOptions);
            document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', timeOptions);
        }

        // Update time every minute
        updateDateTime();
        setInterval(updateDateTime, 60000);

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Show/hide floating action button based on scroll position
        window.addEventListener('scroll', function () {
            const fab = document.querySelector('.fab');
            if (window.scrollY > 300) {
                fab.style.display = 'flex';
            } else {
                fab.style.display = 'none';
            }
        });

        // Initialize FAB visibility
        document.querySelector('.fab').style.display = 'none';

        // Add click animations to buttons
        document.querySelectorAll('.btn-primary, .btn-secondary').forEach(button => {
            button.addEventListener('click', function (e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple effect styles
        const style = document.createElement('style');
        style.textContent = `
                            .ripple {
                                position: absolute;
                                border-radius: 50%;
                                background: rgba(255, 255, 255, 0.6);
                                transform: scale(0);
                                animation: ripple-animation 0.6s linear;
                                pointer-events: none;
                            }

                            @keyframes ripple-animation {
                                to {
                                    transform: scale(4);
                                    opacity: 0;
                                }
                            }
                        `;
        document.head.appendChild(style);

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation for course cards
        window.addEventListener('load', function () {
            const courseCards = document.querySelectorAll('.course-card');
            courseCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Add search functionality
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const courseCards = document.querySelectorAll('.course-card');

                courseCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();

                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = searchTerm ? 'none' : 'block';
                    }
                });
            });
        }

        // Add notification click handlers
        document.querySelectorAll('.notification-badge').forEach(badge => {
            badge.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Create notification popup
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-white rounded-lg shadow-lg border border-gray-200 p-4 z-50 transform translate-x-full transition-transform duration-300';
                notification.innerHTML = `
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-bell text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">New Notifications</p>
                                            <p class="text-xs text-gray-500">You have ${this.textContent} new items</p>
                                        </div>
                                    </div>
                                `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);
            });
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function (e) {
            // Ctrl/Cmd + K for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('.search-input');
                if (searchInput) {
                    searchInput.focus();
                }
            }

            // Escape to close mobile sidebar
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');
                if (sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                }
            }
        });

        console.log('CLSU Instructor Dashboard loaded successfully! 👨‍🏫');
    </script>
    @endpush
@endsection