<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    private $tokenModel;
    public function __construct()
    {
        $this->tokenModel = new Token();
    }
    public function index(Request $request)
    {
        if ($request->search != null) {
            $datas = auth()->user()->role->name == 'admin' ? $this->tokenModel->where('name', 'like', '%' . $request->search . '%')->paginate(50) : $this->tokenModel->where('user_id', auth()->user()->id)->where('name', 'like', '%' . $request->search . '%')->paginate(50);
            return view('pages.token', compact('datas'));
        } else {
            $datas = auth()->user()->role->name == 'admin' ? $this->tokenModel->paginate(50) : $this->tokenModel->where('user_id', auth()->user()->id)->paginate(50);
        }

        return view('pages.token', compact('datas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        if ($token = $this->tokenModel->create([
            'name' => $request->name,
            'token' => Hash::make(Str::random(10)),
            'user_id' => auth()->user()->id,
        ])) {
            return redirect()->route('token.index')->with('success', 'Token berhasil ditambahkan');
        }

        return redirect()->route('token.index')->withErrors('failed', 'Token gagal ditambahkan');
    }

    public function destroy($id)
    {
        if ($this->tokenModel->find($id)->delete()) {
            return redirect()->route('token.index')->with('success', 'Token berhasil dihapus');
        }

        return redirect()->route('token.index')->withErrors('failed', 'Token gagal dihapus');
    }
}
