<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
{
    // Task 3.4: Authorize Method
    public function authorize()
    {
        // Sesuaikan dengan logic pengecekan role di project kamu
        return auth()->check() && auth()->user()->role === 'admin';
    }

    // Task 3.2: Define Validation Rules
    public function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'tanggal_waktu' => 'required|date|after:now',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tikets' => 'required|array|min:1',
            'tikets.*.tipe' => 'required|in:reguler,premium',
            'tikets.*.harga' => 'required|numeric|min:0',
            'tikets.*.stok' => 'required|integer|min:0',
            'tikets.*.id' => 'nullable|exists:tikets,id',
        ];
    }

    // Task 3.3: Define Custom Messages
    public function messages()
    {
        return [
            'judul.required' => 'Judul event wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tanggal_waktu.after' => 'Tanggal event harus di masa depan.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'tikets.required' => 'Minimal harus ada satu tiket.',
            'tikets.*.tipe.in' => 'Tipe tiket hanya boleh reguler atau premium.',
            'tikets.*.harga.min' => 'Harga tiket tidak boleh negatif.',
        ];
    }
}