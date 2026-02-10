<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Magang') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: '{{ $status }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tabs Navigation --}}
                    <div class="flex border-b border-gray-200 mb-6">
                        <a href="{{ route('admin.internships.index', ['status' => 'pending']) }}" 
                           class="mr-8 py-4 text-sm font-medium border-b-2 transition-colors duration-200 {{ $status === 'pending' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Applicants 
                            <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-semibold">{{ $pendingCount }}</span>
                        </a>
                        <a href="{{ route('admin.internships.index', ['status' => 'onboarding']) }}" 
                           class="mr-8 py-4 text-sm font-medium border-b-2 transition-colors duration-200 {{ $status === 'onboarding' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Onboarding
                             <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-semibold">{{ $onboardingCount }}</span>
                        </a>
                        <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" 
                           class="mr-8 py-4 text-sm font-medium border-b-2 transition-colors duration-200 {{ $status === 'active' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Active
                             <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-semibold">{{ $activeCount }}</span>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    
                                    @if($status === 'active')
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Division</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentor</th>
                                    @endif

                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($internships as $internship)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-0">
                                                    <div class="text-sm font-medium text-gray-900">{{ $internship->student->name }}</div>
                                                    <div class="text-xs text-gray-400">{{ $internship->student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        @if($status === 'active')
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $internship->division?->name ?? 'Unassigned' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $internship->mentor?->name ?? 'Unassigned' }}</div>
                                            </td>
                                        @endif

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $internship->status == 'active' ? 'bg-green-100 text-green-800' : 
                                                  ($internship->status == 'finished' ? 'bg-blue-100 text-blue-800' : 
                                                  ($internship->status == 'onboarding' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ ucfirst($internship->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($status === 'pending')
                                                <button @click="$dispatch('open-review-modal', { id: {{ $internship->id }}, name: '{{ $internship->student->name }}', docs: {{ json_encode($internship->documents) }} })" 
                                                    class="text-indigo-600 hover:text-indigo-900 font-bold">
                                                    Review
                                                </button>
                                            @elseif($status === 'onboarding')
                                                <form action="{{ route('admin.internships.activate', $internship->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Verifikasi Pakta Integritas & Aktifkan Magang?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 font-bold">
                                                        Verifikasi & Activate
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('admin.internships.edit', $internship->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Assign</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No data found for this status.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $internships->links() }}
                    </div>
                </div>
            </div>
        </div>
        
        @include('admin.internships.partials.review-modal')

    </div>
</x-app-layout>
