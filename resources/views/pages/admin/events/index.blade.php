@extends('layouts.app')
@section('content')
<div class="p-6">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Manajemen Event</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">+ Tambah Event</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" class="flex gap-2 mb-6">
        <input name="search" value="{{ request('search') }}" placeholder="Cari judul/lokasi..." class="input input-bordered">
        <select name="kategori_id" class="select select-bordered">
            <option value="">Semua Kategori</option>
            </select>
        <button type="submit" class="btn">Filter</button>
    </form>

    <table class="table w-full">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td><img src="{{ $event->imageUrl }}" class="w-16 h-16 object-cover"></td>
                <td>{{ $event->judul }}</td>
                <td>{{ $event->kategori->nama }}</td>
                <td>{{ $event->tanggal_waktu->format('d M Y, H:i') }}</td>
                <td><span class="badge">{{ $event->status }}</span></td>
                <td>
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm">Edit</a>
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-error">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $events->appends(request()->except('page'))->links() }}
    </div>
</div>
@endsection