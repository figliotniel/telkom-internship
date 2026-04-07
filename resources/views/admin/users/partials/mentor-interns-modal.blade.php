<div x-data="{ 
    show: false, 
    mentorName: '', 
    interns: [] 
}" 
     x-show="show"
     @open-mentor-interns.window="mentorName = $event.detail.name; interns = $event.detail.interns; show = true"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
     style="display: none;">
    
    <div @click.away="show = false" 
         class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden shadow-black/20 transform transition-all"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="scale-95 translate-y-4"
         x-transition:enter-end="scale-100 translate-y-0">
        
        <!-- MODAL HEADER -->
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/30">
            <div class="space-y-1">
                <h3 class="text-xl font-black text-slate-900 dark:text-white font-jakarta uppercase tracking-tight" x-text="mentorName"></h3>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 tracking-[0.2em] uppercase">Nodes Under Command</p>
            </div>
            <button @click="show = false" class="w-10 h-10 flex items-center justify-center rounded-2xl bg-white dark:bg-slate-800 text-slate-400 hover:text-red-500 transition-colors shadow-sm border border-slate-200 dark:border-slate-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- INTERN LIST -->
        <div class="max-h-[60vh] overflow-y-auto p-4 space-y-3 no-scrollbar bg-slate-50/20 dark:bg-slate-950/20">
            <template x-for="intern in interns" :key="intern.id">
                <div class="flex items-center justify-between p-5 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-[#ed1e28]/30 hover:shadow-lg transition-all group group-hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-sm font-black text-[#ed1e28] shadow-inner group-hover:scale-110 transition-transform">
                            <span x-text="intern.student.name.charAt(0)"></span>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 dark:text-slate-200" x-text="intern.student.name"></h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500" x-text="intern.division ? intern.division.code : 'No Div'"></span>
                                <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded"
                                      :class="intern.student.student_profile && intern.student.student_profile.student_type === 'siswa' ? 'bg-orange-50 text-orange-600' : 'bg-emerald-50 text-emerald-600'"
                                      x-text="intern.student.student_profile && intern.student.student_profile.student_type === 'siswa' ? 'SMK' : 'MHS'"></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-[9px] font-black uppercase tracking-[0.1em] px-3 py-1 rounded-full"
                              :class="{
                                  'bg-amber-100 text-amber-600': intern.status === 'onboarding',
                                  'bg-emerald-100 text-emerald-600': intern.status === 'active',
                                  'bg-blue-100 text-blue-600': intern.status === 'finished'
                              }"
                              x-text="intern.status"></span>
                        <p class="text-[10px] font-bold text-slate-400" x-text="'Terminating: ' + intern.end_date"></p>
                    </div>
                </div>
            </template>

            <!-- EMPTY STATE -->
            <template x-if="interns.length === 0">
                <div class="py-16 text-center">
                    <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-[2rem] flex items-center justify-center mx-auto mb-4 opacity-50">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-3.876m5.94-2.285A6.707 6.707 0 0121 8.252"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest italic">No active link detected</p>
                </div>
            </template>
        </div>

        <!-- MODAL FOOTER -->
        <div class="px-8 py-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex justify-end">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] italic">Authorized Personnel Only</p>
        </div>
    </div>
</div>
