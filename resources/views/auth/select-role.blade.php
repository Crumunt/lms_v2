<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome, {{ Auth::user()->detail?->full_name }}!</h1>
        <p class="text-gray-600">Please select your role to continue</p>
    </div>

    <form action="{{ route('role.store') }}" method="POST">
        @csrf

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Student Card -->
            <label class="cursor-pointer">
                <input type="radio" name="role" value="student" class="peer hidden" required>
                <div
                    class="border-2 border-gray-300 rounded-xl p-6 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">I'm a Student</h3>
                        <p class="text-gray-600 text-sm">
                            Learn from expert instructors and take courses to improve your skills
                        </p>
                        <ul class="mt-4 space-y-2 text-left w-full">
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Browse courses
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Track progress
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Earn certificates
                            </li>
                        </ul>
                    </div>
                </div>
            </label>

            <!-- Instructor Card -->
            <label class="cursor-pointer">
                <input type="radio" name="role" value="instructor" class="peer hidden" required>
                <div
                    class="border-2 border-gray-300 rounded-xl p-6 hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">I'm an Instructor</h3>
                        <p class="text-gray-600 text-sm">
                            Share your knowledge and teach students around the world
                        </p>
                        <ul class="mt-4 space-y-2 text-left w-full">
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Create courses
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Manage students
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Earn revenue
                            </li>
                        </ul>
                    </div>
                </div>
            </label>
        </div>

        @error('role')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

        <button type="submit"
            class="w-full mt-8 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 font-medium transition text-lg">
            Continue
        </button>
    </form>

    <p class="text-center text-gray-500 text-xs mt-6">
        You can change your role later in account settings
    </p>
    </div>
</x-guest-layout>