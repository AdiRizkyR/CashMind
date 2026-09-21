<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-secondary px-5 py-2.5 bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] text-[#344054] font-semibold text-sm rounded-xl transition-all inline-flex items-center justify-center gap-2']) }}>
    {{ $slot }}
</button>
