@php
    $internship = auth()->user()->internship;
    $hasJoined = $internship->has_joined_telegram ?? false;
    $inviteLink = $internship->telegram_invite_link ?? '#';
@endphp

<div x-data="telegramOnboarding({{ $hasJoined ? 'true' : 'false' }}, '{{ $inviteLink }}')" class="relative z-50">

    {{-- Overlay Blocking Modal if Haven't Joined --}}
    <template x-if="!hasJoined && showModal">
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity">
            <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all p-8 border border-slate-200 dark:border-slate-800 text-center mx-4">
                
                {{-- Icon Header --}}
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-blue-100 dark:bg-blue-900/40 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#0088cc] dark:text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21.198 2.433a2.242 2.242 0 0 0-1.022.215l-19.49 10.3c-.93.486-1.026 1.761-.157 2.22l4.982 2.656 12.871-12.247c.214-.202.534-.038.358.196L7.228 17.15l-.26 3.652c.074.808 1.011 1.096 1.488.463l3.228-4.29 5.378 2.877c.854.457 1.874-.033 2.05-1.002l3.411-14.773c.12-.519-.176-1.028-.711-1.065a2.261 2.261 0 0 0-.616.021Z"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">
                    Langkah Terakhir!
                </h3>
                
                <p class="text-slate-600 dark:text-slate-400 mb-8">
                    Akun magangmu telah <strong>AKTIF</strong>. Silakan bergabung dengan Grup Telegram Komunikasi Tim Intern Telkom sekarang agar tidak ketinggalan informasi penting.
                </p>

                <div class="flex justify-center">
                    <button @click="joinTelegram(true)" class="relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-[#0088cc] border border-transparent rounded-xl hover:bg-[#007AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0088cc] w-full shadow-lg shadow-blue-500/30">
                        Gabung Grup Telegram
                    </button>
                </div>
                
                <p class="text-xs text-slate-500 dark:text-slate-500 mt-6">
                    Akses menu dashboard akan terbuka otomatis setelah Anda menekan tombol di atas.
                </p>
            </div>
        </div>
    </template>

    {{-- Floating Icon (Selalu ada untuk referensi) --}}
    <div x-cloak x-show="showFloatingIcon" class="fixed bottom-6 right-6 z-40 group">
        <a :href="inviteLink" target="_blank" @click="if(!hasJoined) joinTelegram(false)" class="flex items-center justify-center w-14 h-14 bg-[#0088cc] text-white rounded-full shadow-lg shadow-blue-500/40 hover:bg-[#007AB8] transition-transform hover:scale-110 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 transform -translate-x-[1px] translate-y-[1px]" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/>
            </svg>
        </a>
        <!-- Tooltip -->
        <span class="absolute right-full mr-4 top-1/2 -translate-y-1/2 w-max px-3 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-md">
            Grup Telegram Tim
        </span>
        
        <!-- Ripple effect if not joined -->
        <template x-if="!hasJoined">
            <span class="absolute top-0 right-0 flex h-3 w-3 -mt-1 -mr-1">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
        </template>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('telegramOnboarding', (initialHasJoined, inviteLink) => ({
            hasJoined: initialHasJoined,
            inviteLink: inviteLink,
            showModal: true,
            showFloatingIcon: true,
            
            joinTelegram(openLink = true) {
                // Open link in new tab if from modal button
                if (openLink) window.open(this.inviteLink, '_blank');
                
                // If already joined previously, just do nothing more.
                if (this.hasJoined) return;

                // Call backend to mark as joined
                fetch('{{ route('intern.joinedTelegram') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        this.hasJoined = true;
                        this.showModal = false; // Hide overlay
                    }
                })
                .catch(err => console.error('Error updating telegram status:', err));
            }
        }));
    });
</script>
@endpush
