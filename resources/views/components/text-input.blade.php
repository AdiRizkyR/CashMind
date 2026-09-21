@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'cm-input border-[#D0D5DD] focus:border-[#0F766E] focus:ring-[#0F766E]/10 rounded-xl transition-all']) }}>
