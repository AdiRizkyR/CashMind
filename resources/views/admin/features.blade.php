@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER -->
    <div>
        <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Manajemen Fitur & Modul Platform</h1>
        <p class="text-[#667085] text-xs font-medium mt-1">Aktifkan atau nonaktifkan fitur tertentu di seluruh platform secara terpusat.</p>
    </div>

    <!-- FEATURES LIST TABLE -->
    <div class="cm-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-[#E4E7EC] bg-[#F8FAFB] text-[11px] font-semibold text-[#475467]">
                        <th class="py-3 px-4">Fitur Modul</th>
                        <th class="py-3 px-4">Key ID</th>
                        <th class="py-3 px-4">Deskripsi Fungsi</th>
                        <th class="py-3 px-4 text-center">Status Feature Flag</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAECF0]">
                    @foreach($features as $f)
                        <tr class="hover:bg-[#F8FAFB]">
                            <td class="py-3.5 px-4 font-bold text-[#0F172A]">
                                {{ $f->name }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-[#667085]">
                                {{ $f->key }}
                            </td>
                            <td class="py-3.5 px-4 text-[#475467]">
                                {{ $f->description }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form method="POST" action="{{ route('admin.features.toggle', $f->id) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-bold transition border {{ $f->enabled ? 'bg-[#F0FDF4] text-[#15803D] border-[#DCFCE7] hover:bg-[#DCFCE7]' : 'bg-[#F8FAFB] text-[#667085] border-[#E4E7EC] hover:bg-[#EAECF0]' }}">
                                        <span class="w-2 h-2 rounded-full {{ $f->enabled ? 'bg-[#15803D]' : 'bg-[#98A2B3]' }}"></span>
                                        <span>{{ $f->enabled ? 'AKTIF' : 'NONAKTIF' }}</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
