<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary px-5 py-2.5 bg-[#0F172A] hover:bg-[#1E293B] text-white font-semibold text-sm rounded-xl transition-all inline-flex items-center justify-center gap-2']) }}>
    {{ $slot }}
</button>
