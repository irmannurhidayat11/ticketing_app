@extends('layouts.app')
@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold">{{ $event->judul }}</h1>
    <img src="{{ $event->imageUrl }}" class="w-full h-64 object-cover rounded my-4">
    <p>{{ $event->deskripsi }}</p>

    <h3 class="text-xl font-bold mt-8">Event Terkait</h3>
    <div class="grid grid-cols-4 gap-4 mt-4">
        @foreach($related as $r)
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ $r->judul }}</h2>
                    <a href="{{ route('events.show', $r->id) }}" class="btn btn-sm btn-primary">Detail</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection