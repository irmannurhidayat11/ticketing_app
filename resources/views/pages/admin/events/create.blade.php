@extends('layouts.app')
@section('content')
<div class="p-6">
    <a href="{{ route('admin.events.index') }}" class="btn btn-ghost mb-4">← Kembali</a>
    <div class="card bg-base-100 shadow-xl p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Event Baru</h2>
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label>Judul Event <span class="text-error">*</span></label>
                    <input type="text" name="judul" class="input input-bordered w-full" required>
                </div>
                <div class="space-y-2">
                    <label>Kategori <span class="text-error">*</span></label>
                    <select name="kategori_id" class="select select-bordered w-full" required>
                        @foreach($kategoris as $k) <option value="{{ $k->id }}">{{ $k->nama }}</option> @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label>Lokasi <span class="text-error">*</span></label>
                    <input type="text" name="lokasi" class="input input-bordered w-full" required>
                </div>
                <div class="space-y-2">
                    <label>Tanggal & Waktu <span class="text-error">*</span></label>
                    <input type="datetime-local" name="tanggal_waktu" class="input input-bordered w-full" required>
                </div>
                <div class="col-span-2 space-y-2">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="file-input file-input-bordered w-full" accept="image/*">
                </div>
                <div class="col-span-2 space-y-2">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="textarea textarea-bordered w-full" required></textarea>
                </div>
            </div>

            <h3 class="font-bold mt-6 mb-2">Tiket</h3>
            <div id="ticket-container"></div>
            <button type="button" onclick="addTicket()" class="btn btn-outline btn-sm mt-2">+ Tambah Tiket</button>
            
            <button type="submit" class="btn btn-primary w-full mt-6">Simpan Event</button>
        </form>
    </div>
</div>
@include('pages.admin.events.ticket-js')
@endsection