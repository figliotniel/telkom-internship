<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Dashboard</h1>
                    <p class="text-gray-500 mt-1">Welcome back, <span class="font-bold text-red-600">{{ Auth::user()->name }}</span>. Here's your daily overview.</p>
                </div>
                
                <div class="flex gap-3">
                     <a href="{{ route('admin.users.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card 1: Total Mahasiswa --}}
                <div class="bg-[#ce0024] rounded-3xl p-6 text-white relative overflow-hidden shadow-lg group hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-sm">Total Mahasiswa</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="bg-white/20 p-2 rounded-full cursor-pointer hover:bg-white/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-5xl font-bold mb-1">{{ $totalStudents }}</h2>
                        <p class="text-xs opacity-80 font-medium">Terdaftar dalam sistem</p>
                    </div>

                    <div class="pt-4 border-t border-white/20 flex items-center justify-between">
                         <span class="bg-black/20 text-[10px] font-bold px-3 py-1 rounded-md uppercase tracking-wider">REGULAR</span>
                         <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="flex items-center text-xs font-bold hover:underline cursor-pointer">
                             Lihat Detail
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                         </a>
                    </div>
                </div>

                {{-- Card 2: Magang Aktif --}}
                <div class="bg-[#ce0024] rounded-3xl p-6 text-white relative overflow-hidden shadow-lg group hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-sm">Magang Aktif</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="bg-white/20 p-2 rounded-full cursor-pointer hover:bg-white/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-5xl font-bold mb-1">{{ $activeInternships }}</h2>
                        <p class="text-xs opacity-80 font-medium">Sedang Berjalan</p>
                    </div>

                    <div class="pt-4 border-t border-white/20 flex items-center justify-between">
                         <span class="bg-black/20 text-[10px] font-bold px-3 py-1 rounded-md uppercase tracking-wider">REPORT</span>
                         <a href="{{ route('admin.internships.index') }}" class="flex items-center text-xs font-bold hover:underline cursor-pointer">
                             Monitoring
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                         </a>
                    </div>
                </div>

                {{-- Card 3: Total Mentor --}}
                <div class="bg-[#ce0024] rounded-3xl p-6 text-white relative overflow-hidden shadow-lg group hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-sm">Total Mentor</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="bg-white/20 p-2 rounded-full cursor-pointer hover:bg-white/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-5xl font-bold mb-1">{{ $totalMentors }}</h2>
                        <p class="text-xs opacity-80 font-medium">Mentor Aktif</p>
                    </div>

                    <div class="pt-4 border-t border-white/20 flex items-center justify-between">
                         <span class="bg-black/20 text-[10px] font-bold px-3 py-1 rounded-md uppercase tracking-wider">ACCESS</span>
                         <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" class="flex items-center text-xs font-bold hover:underline cursor-pointer">
                             Kelola Mentor
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                         </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Column: Recent Internships --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-800">Recent Activity</h3>
                            <a href="{{ route('admin.internships.index') }}" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors">View All &rarr;</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($recentInternships as $internship)
                                <div class="px-6 py-4 hover:bg-gray-50 transition-colors group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">
                                                {{ substr($internship->student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-800 group-hover:text-red-600 transition-colors">{{ $internship->student->name }}</h4>
                                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                                     <span>{{ $internship->division->name ?? 'No Division' }}</span>
                                                     <span>&bull;</span>
                                                     <span>{{ $internship->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @php
                                            $statusConfig = [
                                                'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                                'finished' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                            ];
                                            $config = $statusConfig[$internship->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                                        @endphp
                                        
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                                            {{ ucfirst($internship->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 flex flex-col items-center justify-center text-center opacity-60">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-sm font-medium text-gray-500">No recent activity found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right Column: Pending Actions --}}
                <div class="space-y-6">
                     {{-- Pending Extensions Card --}}
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-red-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-red-800">Pending Extensions</h3>
                            @if($pendingExtensions->count() > 0)
                                <span class="bg-red-200 text-red-800 text-xs font-bold px-2 py-0.5 rounded-full border border-red-300">
                                    {{ $pendingExtensions->count() }}
                                </span>
                            @endif
                        </div>
                        <div class="divide-y divide-gray-100">
                             @forelse($pendingExtensions as $extension)
                                <div class="p-5 hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xs">
                                                {{ substr($extension->internship->student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h5 class="text-sm font-bold text-gray-800">{{ $extension->internship->student->name }}</h5>
                                                <span class="text-xs text-gray-500">{{ $extension->created_at->shortAbsoluteDiffForHumans() }} ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 p-3 rounded-md text-xs text-gray-600 italic mb-3 border border-gray-100">
                                        "{{ Str::limit($extension->reason, 80) }}"
                                    </div>
                                    
                                    <button 
                                        x-data
                                        @click="$dispatch('open-extension-modal', { 
                                            id: '{{ $extension->id }}', 
                                            studentName: '{{ $extension->internship->student->name }}',
                                            currentEndDate: '{{ \Carbon\Carbon::parse($extension->internship->end_date)->format('d M Y') }}',
                                            newEndDate: '{{ \Carbon\Carbon::parse($extension->new_end_date)->format('d M Y') }}',
                                            reason: '{{ $extension->reason }}',
                                            university: '{{ optional($extension->internship->student->studentProfile)->university ?? '-' }}',
                                            major: '{{ optional($extension->internship->student->studentProfile)->major ?? '-' }}'
                                        })"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Review Request
                                    </button>
                                </div>
                            @empty
                                <div class="p-8 text-center opacity-60">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <p class="text-sm font-medium text-gray-500">All caught up!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Quick Links Card --}}
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Quick Actions</h3>
                        </div>
                        <div class="p-4 space-y-2">
                             <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-50 p-1.5 rounded text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">View All Students</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            
                            <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-50 p-1.5 rounded text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">View All Mentors</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('admin.internships.partials.extension-modal')

</x-app-layout>