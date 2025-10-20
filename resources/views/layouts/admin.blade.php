@extends('layouts.base')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('body')
    <!-- Layout Container -->
    <div class="layout-container">
        <!-- Enhanced Sidebar -->
        <x-admin.layout.sidebar :user="$user" />

        <!-- Main Area -->
        <div class="main-area">
            <!-- Enhanced Header -->
            <x-admin.layout.header :user="$user" />

            <!-- Main Content -->
            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <!-- Floating Action Button -->
    <button class="fab" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

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
        document.querySelectorAll('.btn-primary, .btn-secondary, .btn-danger').forEach(button => {
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

        // Simple notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 ${type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                    'bg-blue-500 text-white'
                }`;
            notification.textContent = message;
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Delete confirmation
        function confirmDelete(message = 'Are you sure you want to delete this item?') {
            return confirm(message);
        }

        // Show success messages from Laravel
        // @if(session('success'))
            //     showNotification('{{ session('success') }}', 'success');
        // @endif

        // @if(session('error'))
            //     showNotification('{{ session('error') }}', 'error');
        // @endif

        console.log('CLSU Admin Dashboard loaded successfully! 👨‍💼');
    </script>
    @endpush
@endsection