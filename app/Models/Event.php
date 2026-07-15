<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'lokasi',
        'gambar',
        'tanggal_waktu',
    ];

    // 2.1.2: Define Relationships
    public function tikets() { return $this->hasMany(Tiket::class); }
    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function orders() { return $this->hasMany(Order::class); }

    // 2.1.3: Add Status Attribute
    public function getStatusAttribute()
    {
        $dt = Carbon::parse($this->tanggal_waktu);
        if ($dt->isFuture()) return "Upcoming";
        if ($dt->diffInHours(now()) <= 3 && $dt->isPast()) return "Ongoing";
        return "Completed";
    }

    // 2.1.4: Add Helper Methods
    public function hasSales()
    {
        return $this->orders()->exists();
    }

    // 2.1.5: Add Query Scopes
    public function scopeUpcoming($query) { return $query->where('tanggal_waktu', '>', now()); }
    public function scopeOngoing($query) { 
        return $query->whereBetween('tanggal_waktu', [now()->subHours(3), now()]); 
    }
    public function scopeCompleted($query) { return $query->where('tanggal_waktu', '<', now()->subHours(3)); }

    // 2.1.6: Add Image URL Accessor
    public function getImageUrlAttribute()
    {
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }
        return Storage::exists($this->gambar) ? Storage::url($this->gambar) : asset('images/konser.jpg');
    }
}