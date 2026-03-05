<x-guest-layout>
    <h1 class="font-serif text-[120px] font-normal text-center text-black dark:text-white leading-none block h-[300px] overflow-hidden m-[0_0_-60px_0] pt-0 z-10 relative transition-colors duration-300" x-data="{
        text1: '',
        text2: '',
        cursor1: true,
        cursor2: false,
        type(text, target, callback) {
            let i = 0;
            let speed = 100; 
            let interval = setInterval(() => {
                this[target] += text.charAt(i);
                i++;
                if (i >= text.length) {
                    clearInterval(interval);
                    if (callback) callback();
                }
            }, speed);
        },
        delete(target, callback) {
            let speed = 50; 
            let interval = setInterval(() => {
                this[target] = this[target].slice(0, -1);
                if (this[target].length === 0) {
                    clearInterval(interval);
                    if (callback) callback();
                }
            }, speed);
        },
        startLoop() {
            this.text1 = '';
            this.text2 = '';
            this.cursor1 = true;
            this.cursor2 = false;
            
            this.type('Telkom Witel', 'text1', () => {
                this.cursor1 = false;
                this.cursor2 = true;
                this.type('Semarang Jateng Utara', 'text2', () => {
                   // Wait 3 seconds, then delete
                   setTimeout(() => {
                       this.delete('text2', () => {
                           this.cursor2 = false;
                           this.cursor1 = true;
                           this.delete('text1', () => {
                               // Loop again after short pause
                               setTimeout(() => { this.startLoop(); }, 500);
                           });
                       });
                   }, 3000);
                });
            });
        },
        init() {
            setTimeout(() => {
                this.startLoop();
            }, 300);
        }
    }">
        <span x-text="text1" style="min-height: 1em; display: inline-block;"></span><span x-show="cursor1" class="animate-pulse">|</span>
        <br>
        <span x-text="text2" style="min-height: 1em; display: inline-block;"></span><span x-show="cursor2" class="animate-pulse">|</span>
    </h1>

    <div class="relative w-full flex justify-center items-center pb-5">
        <div class="absolute bg-[#EE0000] h-[420px] w-full z-10 top-1/2 -translate-y-1/2 shadow-[inset_0_0_100px_rgba(0,0,0,0.1)]"></div>

        <div class="relative z-20 flex items-center justify-center gap-10 w-full max-w-[1200px]">
            <img src="{{ asset('images/char-female.png') }}" alt="Intern Wanita" class="h-[470px] w-auto object-contain mb-[30px] drop-shadow-[0_20px_30px_rgba(0,0,0,0.2)]">

            <div class="w-[345px] shrink-0 px-5 flex flex-col">
                <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-[15px]">
                        <label for="email" class="block text-white font-semibold text-sm mb-[5px] text-left">Username / Email</label>
                        <input type="email" id="email" name="email"
                               class="w-full py-3 px-[18px] rounded-xl border-2 border-transparent bg-[#FEF2D5] text-sm outline-none box-border transition-all duration-300 text-gray-800 focus:border-white focus:shadow-[0_0_15px_rgba(255,255,255,0.3)] focus:ring-0"
                               value="{{ old('email') }}"
                               required autofocus autocomplete="username">
                        
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-yellow-300 text-xs" />
                    </div>

                    <div class="mb-[15px]">
                        <label for="password" class="block text-white font-semibold text-sm mb-[5px] text-left">Password</label>
                        <input type="password" id="password" name="password"
                               class="w-full py-3 px-[18px] rounded-xl border-2 border-transparent bg-[#FEF2D5] text-sm outline-none box-border transition-all duration-300 text-gray-800 focus:border-white focus:shadow-[0_0_15px_rgba(255,255,255,0.3)] focus:ring-0"
                               required autocomplete="current-password">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-yellow-300 text-xs" />
                    </div>

                    <div class="text-right mt-[-10px] mb-5 flex justify-between items-center">
                        <label for="remember_me" class="inline-flex items-center m-0">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-xs text-white">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-white text-xs no-underline opacity-80 transition-opacity duration-300 hover:opacity-100 hover:underline">Lupa password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full p-[14px] bg-gradient-to-br from-[#ff4d4d] to-[#b30000] border-2 border-white/20 text-white font-extrabold rounded-full cursor-pointer shadow-[0_8px_20px_rgba(179,0,0,0.3)] text-base uppercase tracking-[1px] transition-all duration-300 hover:-translate-y-[2px] hover:shadow-[0_12px_25px_rgba(179,0,0,0.4)] hover:border-white/40 active:translate-y-0">
                        LOGIN
                    </button>
                </form>
            </div>

            <img src="{{ asset('images/char-male.png') }}" alt="Intern Pria" class="h-[470px] w-auto object-contain mb-[30px] drop-shadow-[0_20px_30px_rgba(0,0,0,0.2)]">
        </div>
    </div>
</x-guest-layout>