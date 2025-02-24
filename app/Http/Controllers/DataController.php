<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;

class DataController extends Controller
{
    public function index()
    {
        $data = Data::all();
        return view('dashboard', compact('data'));
    }

    public function create()
    {
        return view('data.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supervisor' => 'required',
            'target_do' => 'required',
            'act_do' => 'required',
            'gap' => 'required',
            'ach' => 'required',
            'target_spk' => 'required',
            'act_spk' => 'required',
            'gap_spk' => 'required',
            'ach_spk' => 'required',
            'status' => 'required',
        ]);

        Data::create($request->all());

        return redirect()->route('data.index')->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $data = Data::find($id);
        return view('data.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Data::find($id);
        if (!$data) {
            return redirect()->route('data.index')->withErrors(['error' => 'Data not found.']);
        }

        $request->validate([
            'nama_supervisor' => 'required',
            'target_do' => 'required',
            'act_do' => 'required',
            'gap' => 'required',
            'ach' => 'required',
            'target_spk' => 'required',
            'act_spk' => 'required',
            'gap_spk' => 'required',
            'ach_spk' => 'required',
            'status' => 'required',
        ]);

        $data->update($request->all());

        return redirect()->route('data.index')->with('success', 'Data Berhasil Diubah!');
    }

    public function destroy($id)
    {
        $data = Data::find($id);
        if ($data) {
            $data->delete();
        }

        return redirect()->route('data.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
