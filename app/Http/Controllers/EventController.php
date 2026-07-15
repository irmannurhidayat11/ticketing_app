<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Tiket;
use App\Models\Order;
use App\Http\Requests\EventFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request) {
        $query = Event::with(['kategori', 'tikets']);
        if ($request->has('kategori_id')) $query->where('kategori_id', $request->kategori_id);
        if ($request->has('search')) {
            $query->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('lokasi', 'like', "%{$request->search}%");
        }
        $events = $query->orderBy('tanggal_waktu', $request->get('sort', 'asc'))->paginate(10);
        return view('pages.admin.events.index', compact('events'));
    }

    public function create() {
        $kategoris = Kategori::all();
        return view('pages.admin.events.create', compact('kategoris'));
    }

    public function store(EventFormRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('events', 'public');
        } else {
            $data['gambar'] = 'konser.jpg';
        }

        DB::transaction(function() use ($data, $request) {
            $event = Event::create($data);
            foreach ($request->tikets as $t) {
                $event->tikets()->create($t);
            }
        });
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function edit(Event $event) {
        $kategoris = Kategori::all();
        $hasSales = $event->hasSales();
        return view('pages.admin.events.edit', compact('event', 'kategoris', 'hasSales'));
    }

    public function update(EventFormRequest $request, Event $event) {
        if ($event->hasSales() && $request->tanggal_waktu != $event->tanggal_waktu) {
            return back()->withErrors('Tidak bisa mengubah tanggal jika sudah ada penjualan.');
        }
        $data = $request->validated();
        if ($request->hasFile('gambar')) {
            if ($event->gambar && $event->gambar != 'konser.jpg') Storage::disk('public')->delete($event->gambar);
            $data['gambar'] = $request->file('gambar')->store('events', 'public');
        }
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event diupdate.');
    }

    public function destroy(Event $event) {
        if ($event->hasSales()) return back()->withErrors('Tidak bisa hapus event yang sudah terjual.');
        if ($event->gambar && $event->gambar != 'konser.jpg') Storage::disk('public')->delete($event->gambar);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event dihapus.');
    }

    public function show(Event $event) {
        $event->load(['kategori', 'tikets']);
        $related = Event::where('kategori_id', $event->kategori_id)
                        ->where('id', '!=', $event->id)
                        ->where('tanggal_waktu', '>', now())
                        ->limit(4)->get();
        return view('pages.events.show', compact('event', 'related'));
    }
}