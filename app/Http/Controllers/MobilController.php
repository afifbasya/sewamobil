<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class MobilController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->get('query');
        $availability = $request->get('availability');

        $mobils = Mobil::query();
        if ($query) {
            $mobils->where(function ($q) use ($query) {
                $q->where('merek', 'like', '%' . $query . '%')
                    ->orWhere('model', 'like', '%' . $query . '%');
            });
        }

        $today = Carbon::now()->toDateString();


        $mobils = $mobils->with(['pinjams' => function ($query) use ($today) {
            $query->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->where('status', 'Dipinjam');
        }])->paginate(6);

        // if ($availability === 'Tersedia') {
        //     $mobils->whereDoesntHave('pinjams');
        // } elseif ($availability === 'Tidak Tersedia') {
        //     $mobils->has('pinjams');
        // }

        // $mobils = $mobils->paginate(6);

        return view('manage.index', [
            'mobils' => $mobils,
        ]);
    }

    public function create(): View
    {
        return view('manage.create');
    }

    public function edit($id): View
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return Redirect::route('mobil.index')->with('status', 'Mobil Tidak Ditemukan');
        }

        return view('manage.edit', [
            'mobil' => $mobil,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'merek' => ['required'],
            'model' => ['required'],
            'nomor_plat' => ['required'],
            'tarif' => ['required', 'numeric'],
        ]);

        Mobil::create([
            'merek' => $request->merek,
            'model' => $request->model,
            'nomor_plat' => $request->nomor_plat,
            'tarif' => $request->tarif,
        ]);

        return Redirect::route('mobil.index')->with('status', 'Mobil Sukses Terbuat');
    }


    public function update(Request $request, Mobil $mobil): RedirectResponse
    {
        $request->validate([
            'merek' => ['required'],
            'model' => ['required'],
            'nomor_plat' => ['required'],
            'tarif' => ['required', 'numeric'],
        ]);

        $mobil->update([
            'merek' => $request->merek,
            'model' => $request->model,
            'nomor_plat' => $request->nomor_plat,
            'tarif' => $request->tarif,
        ]);

        return Redirect::route('mobil.index')->with('status', 'Mobil Sukses Diperbarui');
    }

    /**
     * Delete the user's account.
     */
    public function destroy($id): RedirectResponse
    {
        // Cari mobil berdasarkan ID
        $mobil = Mobil::find($id);

        // Pastikan mobil ditemukan
        if (!$mobil) {
            return Redirect::route('mobil.index')->with('status', 'Mobil Tidak Ditemukan');
        }

        // Hapus mobil
        $mobil->delete();

        return Redirect::route('mobil.index')->with('status', 'Mobil Sukses Dihapus');
    }
}
