@extends('layouts.app')
@section('content')
<div class="p-6">
    @if($hasSales)
        <div class="alert alert-warning mb-4">Peringatan: Event ini sudah memiliki penjualan. Beberapa field tidak dapat diubah.</div>
    @endif
    
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
@include('pages.admin.events.ticket-js')
@endsection