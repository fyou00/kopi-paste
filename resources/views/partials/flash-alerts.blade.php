@if(session('success'))
    <div class="flex items-start justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl mb-5 shadow-sm" role="alert">
        <div class="flex items-center gap-3 text-sm font-medium">
            <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <i class="fas fa-check-circle"></i>
            </span>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.closest('[role=alert]').remove()" class="text-emerald-600 hover:text-emerald-900 p-1 rounded-lg transition" aria-label="Tutup notifikasi">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="flex items-start justify-between gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl mb-5 shadow-sm" role="alert">
        <div class="flex items-center gap-3 text-sm font-medium">
            <span class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                <i class="fas fa-exclamation-circle"></i>
            </span>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.closest('[role=alert]').remove()" class="text-rose-600 hover:text-rose-900 p-1 rounded-lg transition" aria-label="Tutup notifikasi">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="flex items-start justify-between gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl mb-5 shadow-sm" role="alert">
        <div class="flex items-start gap-3 text-sm">
            <span class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fas fa-exclamation-triangle"></i>
            </span>
            <div>
                <p class="font-semibold mb-1">Periksa kembali data yang dimasukkan:</p>
                <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" onclick="this.closest('[role=alert]').remove()" class="text-rose-600 hover:text-rose-900 p-1 rounded-lg transition" aria-label="Tutup notifikasi">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif
