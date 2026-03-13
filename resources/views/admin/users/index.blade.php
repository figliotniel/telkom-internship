<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-slate-200 leading-tight transition-colors hidden">
            {{ __('Data User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Page Title Area -->
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Data User</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Manage all registered users, roles, and access across the application.</p>
            </div>

            <!-- Main Container -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                <div class="p-8">
                    
                    <!-- Controls Row: Tabs & Actions -->
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 border-b border-slate-100 dark:border-slate-800 pb-6 mb-6 transition-colors">
                        
                        <!-- Premium Tabs -->
                        <nav class="flex space-x-2 overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0" aria-label="Tabs">
                            {{-- Semua --}}
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ !request('role') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Semua
                                <span class="ml-2 {{ !request('role') ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalAll }}</span>
                            </a>

                            {{-- Intern --}}
                            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ request('role') == 'student' ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Intern
                                <span class="ml-2 {{ request('role') == 'student' ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalStudents }}</span>
                            </a>

                            {{-- Mentor --}}
                            <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ request('role') == 'mentor' ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Mentor
                                <span class="ml-2 {{ request('role') == 'mentor' ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalMentors }}</span>
                            </a>
                        </nav>
                        
                        <!-- Actions & Filters -->
                        <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                            {{-- Sub Filter for Interns --}}
                            @if(request('role') == 'student')
                                <div class="inline-flex bg-slate-50 dark:bg-slate-950 rounded-lg shadow-inner border border-slate-200 dark:border-slate-800 p-0.5 shrink-0" role="group">
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['student_type' => null, 'page' => null])) }}"
                                        class="px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-md transition-all flex items-center gap-1
                                        {{ !request('student_type')
                                            ? 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-700' 
                                            : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border border-transparent' }}">
                                            Semua
                                            <span class="bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-1 py-0.5 rounded text-[8px]">{{ $totalStudents }}</span>
                                    </a>
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['student_type' => 'mahasiswa', 'page' => null])) }}"
                                        class="px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-md transition-all flex items-center gap-1
                                        {{ request('student_type') == 'mahasiswa' 
                                            ? 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-700' 
                                            : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border border-transparent' }}">
                                            MHS
                                            <span class="bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-1 py-0.5 rounded text-[8px]">{{ $studentMahasiswaCount }}</span>
                                    </a>
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['student_type' => 'smk', 'page' => null])) }}" 
                                        class="px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-md transition-all flex items-center gap-1
                                        {{ request('student_type') == 'smk' 
                                            ? 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-700' 
                                            : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border border-transparent' }}">
                                            SMK
                                            <span class="bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-1 py-0.5 rounded text-[8px]">{{ $studentSmkCount }}</span>
                                    </a>
                                </div>
                            @endif

                            <!-- Search -->
                            <form action="{{ route('admin.users.index') }}" method="GET" class="relative w-full sm:w-64" x-data x-ref="form">
                                @if(request('role'))
                                    <input type="hidden" name="role" value="{{ request('role') }}">
                                @endif
                                @if(request('student_type'))
                                    <input type="hidden" name="student_type" value="{{ request('student_type') }}">
                                @endif
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Search..." 
                                    @input.debounce.500ms="$refs.form.submit()"
                                    x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length);"
                                    class="pl-9 pr-4 py-2.5 w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all placeholder-slate-400 font-medium text-slate-700 dark:text-slate-300">
                            </form>
                        </div>
                    </div>


                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                            <thead class="bg-slate-50/50 dark:bg-slate-950/50">
                                <tr>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest sm:rounded-tl-xl sm:rounded-bl-xl">User Detail</th>
                                    @if(request('role') !== 'mentor')
                                        <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pendidikan</th>
                                        <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Role</th>
                                        <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest sm:rounded-tr-xl sm:rounded-br-xl">Registered</th>
                                    @else
                                        <th scope="col" class="px-6 py-5 text-left text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest sm:rounded-tr-xl sm:rounded-br-xl">Intern Diampuh</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/80 dark:divide-slate-800/80">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors group {{ $loop->last ? 'border-b-0' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4 group">
                                                <div class="relative">
                                                    @php
                                                        $avatarColors = [
                                                            'admin' => 'from-purple-500/20 to-indigo-500/20 text-purple-600 dark:text-purple-400 border-purple-100 dark:border-purple-500/20',
                                                            'mentor' => 'from-blue-500/20 to-cyan-500/20 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-500/20',
                                                            'student' => 'from-emerald-400/20 to-teal-500/20 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-500/20',
                                                        ];
                                                        $isSmk = optional($user->studentProfile)->student_type === 'siswa' || optional($user->studentProfile)->education_level === 'SMK';
                                                        if ($user->role === 'student' && $isSmk) {
                                                            $avatarColors['student'] = 'from-amber-400/20 to-orange-500/20 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-500/20';
                                                        }
                                                        $colorStyles = $avatarColors[$user->role] ?? 'from-slate-400/20 to-slate-500/20 text-slate-600 dark:text-slate-400 border-slate-100 dark:border-slate-800';
                                                    @endphp
                                                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr {{ $colorStyles }} flex items-center justify-center font-black text-xl shadow-sm border transition-transform group-hover:scale-110">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="flex flex-col min-w-0 pr-4">
                                                    <div class="flex items-center gap-2 group-hover:translate-x-1 transition-transform">
                                                        <div class="text-sm font-black text-slate-800 dark:text-white truncate" title="{{ $user->name }}">{{ $user->name }}</div>
                                                        @if($user->role === 'mentor')
                                                            @php $count = $user->mentoredInternships->count(); @endphp
                                                            <span class="flex-shrink-0 inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-black {{ $count > 0 ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }} border border-transparent transition-colors">
                                                                {{ $count }} Intern
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider truncate mt-1 group-hover:translate-x-1 transition-transform delay-75" title="{{ $user->email }}">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        @if(request('role') !== 'mentor')
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($user->role === 'student')
                                                    @php
                                                        $eduLevel = optional($user->studentProfile)->education_level ?? '-';
                                                        $eduClasses = $eduLevel === 'SMK' 
                                                            ? 'bg-purple-100/50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-200 dark:border-purple-500/20' 
                                                            : 'bg-indigo-100/50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/20';
                                                    @endphp
                                                    <span class="px-2.5 py-1 inline-flex text-[9px] uppercase tracking-widest font-black rounded-lg border {{ $eduClasses }}">
                                                        {{ $eduLevel }}
                                                    </span>
                                                @else
                                                    <span class="text-[10px] font-black text-slate-300 dark:text-slate-700 uppercase tracking-widest">-</span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $roleConfig = [
                                                        'admin' => ['bg' => 'bg-red-50 dark:bg-red-500/10', 'text' => 'text-red-700 dark:text-red-400', 'border' => 'border-red-100 dark:border-red-500/20'],
                                                        'mentor' => ['bg' => 'bg-blue-50 dark:bg-blue-500/10', 'text' => 'text-blue-700 dark:text-blue-400', 'border' => 'border-blue-100 dark:border-blue-500/20'],
                                                        'student' => ['bg' => 'bg-slate-50 dark:bg-slate-800/50', 'text' => 'text-slate-700 dark:text-slate-300', 'border' => 'border-slate-200 dark:border-slate-700/50'],
                                                    ];
                                                    $config = $roleConfig[$user->role] ?? $roleConfig['student'];
                                                @endphp
                                                <span class="px-2.5 py-1 inline-flex text-[9px] uppercase tracking-widest font-black rounded-lg border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                    {{ $user->role }}
                                                </span>
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 tracking-tight">{{ $user->created_at->format('d M Y') }}</div>
                                                    <div class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">{{ $user->created_at->diffForHumans() }}</div>
                                                </div>
                                            </td>
                                        @else
                                            <td class="px-6 py-4 bg-slate-50/30 dark:bg-slate-950/20">
                                                <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-3">
                                                    @forelse($user->mentoredInternships as $internship)
                                                        @if($internship->student)
                                                            <div class="relative flex items-center gap-3 bg-white dark:bg-slate-900 p-2.5 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-blue-200 dark:hover:border-blue-500/30 transition-all group/intern overflow-hidden">
                                                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover/intern:opacity-100 transition-opacity"></div>
                                                                <div class="relative h-9 w-9 rounded-xl bg-gradient-to-tr from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-black text-xs border border-slate-200 dark:border-slate-700 group-hover/intern:scale-110 group-hover/intern:text-blue-600 dark:group-hover/intern:text-blue-400 transition-all">
                                                                    {{ substr($internship->student->name, 0, 1) }}
                                                                </div>
                                                                <div class="relative flex flex-col min-w-0">
                                                                    <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 truncate leading-tight transition-colors group-hover/intern:text-blue-600 dark:group-hover/intern:text-blue-400">
                                                                        {{ $internship->student->name }}
                                                                    </div>
                                                                    <div class="flex items-center gap-1.5 mt-1.5">
                                                                        @php
                                                                            $statusConfig = $internship->status === 'active' 
                                                                                ? ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600 dark:text-emerald-400', 'label' => 'Active']
                                                                                : ['bg' => 'bg-amber-500', 'text' => 'text-amber-600 dark:text-amber-400', 'label' => 'Onboarding'];
                                                                        @endphp
                                                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['bg'] }} {{ $internship->status === 'active' ? 'animate-pulse' : '' }}"></span>
                                                                        <span class="text-[8px] font-black uppercase tracking-widest {{ $statusConfig['text'] }} opacity-80">{{ $statusConfig['label'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        <div class="col-span-full py-6 flex flex-col items-center justify-center bg-white dark:bg-slate-900 border border-dashed border-slate-200 dark:border-slate-800 rounded-3xl transition-colors opacity-60">
                                                            <div class="p-2.5 bg-slate-50 dark:bg-slate-800 rounded-2xl mb-2 grayscale">
                                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                            </div>
                                                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Belum Ada Intern</span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </td>
                                        @endif


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ request('role') === 'mentor' ? 2 : 4 }}" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400 min-h-[160px]">
                                            <div class="flex flex-col items-center justify-center h-full gap-2">
                                                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                                <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">No users found for this category.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $users->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
