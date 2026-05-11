<x-app-layout>
    {{-- Dashboard Main Area (New Layout Structure Matching HTML Reference) --}}
    <div class="p-6 lg:p-10 max-w-7xl mx-auto space-y-10 w-full flex-1">
        
        {{-- Welcome Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Berikut ringkasan hari ini, {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="openAddMentorModal()" class="px-5 py-2.5 bg-red-600 dark:bg-red-600 text-white rounded-xl hover:bg-red-700 dark:hover:bg-red-700 transition-all font-semibold text-sm shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Mentor
                </button>
            </div>
        </div>

        {{-- 1. Stats Grid --}}
        <x-admin.dashboard-stats 
            :totalStudents="$totalStudents"
            :studentGrowth="$studentGrowth"
            :activeInternships="$activeInternships"
            :totalMentors="$totalMentors"
            :mentorGrowth="$mentorGrowth"
        />

        {{-- 2. Content Sections Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left: Recent Activities (2 columns wide) --}}
            <x-admin.dashboard-recent-interns :recentInternships="$recentInternships" />

            <!-- Right: Quick Actions / Need Attention -->
            <x-admin.dashboard-quick-actions 
                :pendingApplicants="$pendingApplicants"
                :finishedInternsCount="$finishedInternsCount"
            />

        </div>
    </div>

    <!-- Add Mentor Modal (Premium Glassmorphism Design) -->
    <x-admin.add-mentor-modal :mentorsList="$mentorsList" />

    @push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        /* PREMIUM GLINT & ANIMATION EFFECTS */
        .glass-card-light {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        }
        
        .hover-glint {
            position: relative;
            overflow: hidden;
        }
        
        .hover-glint::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0) 40%,
                rgba(255, 255, 255, 0.4) 50%,
                rgba(255, 255, 255, 0) 60%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(45deg);
            transition: all 0.7s;
            opacity: 0;
            pointer-events: none;
        }
        
        .hover-glint:hover::after {
            left: 100%;
            top: 100%;
            opacity: 1;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: floating 3s ease-in-out infinite; }
    </style>
    @endpush

    @push('scripts')
    <script>
        const addMentorModal = document.getElementById('addMentorModal');
        const addMentorModalContent = document.getElementById('addMentorModalContent');

        function openAddMentorModal() {
            addMentorModal.classList.remove('opacity-0', 'pointer-events-none');
            addMentorModalContent.classList.remove('scale-95');
            addMentorModalContent.classList.add('scale-100');
        }

        function closeAddMentorModal() {
            addMentorModal.classList.add('opacity-0', 'pointer-events-none');
            addMentorModalContent.classList.remove('scale-100');
            addMentorModalContent.classList.add('scale-95');
        }

        function showInfoModal(title, text) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'info',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        }
    </script>
    @endpush
</x-app-layout>