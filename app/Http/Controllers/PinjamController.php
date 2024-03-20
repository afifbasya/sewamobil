<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Pinjam;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

class PinjamController extends Controller
{
    public function index(): View
    {
        $mobils = Mobil::get();
        $pinjams = Pinjam::where('user_id', Auth::user()->id)->with('mobil')->paginate(6);

        return view('pinjam.index', [
            'pinjams' => $pinjams,
            'mobils' => $mobils,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'mobil' => ['required'],
            'tanggal_mulai' => ['required'],
            'tanggal_selesai' => ['required'],
        ]);

        // Validasi apakah mobil sudah disewa pada rentang tanggal yang diminta
        $mobilDisewa = Pinjam::where('mobil_id', $request->mobil)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('tanggal_mulai', '>=', $request->tanggal_mulai)
                        ->where('tanggal_mulai', '<', $request->tanggal_selesai);
                })
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_selesai', '>', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '<=', $request->tanggal_selesai);
                    });
            })
            ->where('status', 'Dipinjam')
            ->exists();

        if ($mobilDisewa) {
            return Redirect::route('pinjam.index')->with('status', 'Mobil tersebut sudah disewa pada rentang tanggal yang diminta.');
        }

        Pinjam::create([
            'mobil_id' => $request->mobil,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'user_id' => Auth::user()->id,
            'status' => 'Dipinjam',
        ]);

        return Redirect::route('pinjam.index')->with('status', 'Pinjam Mobil Sukses Terbuat');
    }

    public function kembali($id): RedirectResponse
    {
        $pinjam = Pinjam::find($id);

        if (!$pinjam) {
            return Redirect::route('pinjam.index')->with('status', 'Mobil Tidak Ditemukan');
        }

        $pinjam->status = "Dikembalikan";
        $pinjam->save();

        return Redirect::route('pinjam.index')->with('status', 'Mobil Sukses Dikembalikan');
    }
}
