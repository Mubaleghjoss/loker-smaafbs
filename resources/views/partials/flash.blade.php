@if (session('success'))
    <div data-auto-dismiss class="animate-fade-in-up flex items-start gap-3 rounded-xl border border-emerald-200/60 bg-gradient-to-r from-emerald-50 to-teal-50 px-5 py-4 shadow-soft">
        <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-500">
            <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="text-sm font-medium text-emerald-900">{{ session('success') }}</div>
    </div>
@endif

@if ($errors->any())
    <div data-auto-dismiss class="animate-fade-in-up flex items-start gap-3 rounded-xl border border-rose-200/60 bg-gradient-to-r from-rose-50 to-pink-50 px-5 py-4 shadow-soft">
        <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-500">
            <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div>
            <div class="text-sm font-semibold text-rose-900">Periksa kembali input Anda:</div>
            <ul class="mt-1.5 list-disc pl-5 text-sm text-rose-800">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
