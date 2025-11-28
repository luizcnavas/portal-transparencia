<?php

namespace App\Http\Controllers;

use App\Models\Pessoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PessoalController extends Controller
{
    public function index(Request $request)
    {
        $pessoal = Pessoal::oldest()->paginate(10);

        // Se a rota atual estiver no prefixo 'admin', retorna a view do admin
        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.pessoal.index', compact('pessoal'));
        }

        return view('pessoal.index', compact('pessoal'));
    }

    public function show(Pessoa $pessoa)
    {
        return view('pessoal.show', compact('pessoal'));
    }

    public function create()
    {
        $isMainAdmin = User::currentUserIsMainAdmin();
        return view('admin.pessoal.create', compact('isMainAdmin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'=> 'required|string|max:255',
            'cargo'=> 'required|string|max:255',
            'foto' => 'nullable|file|mimes:png,jpg,jpeg|max:10240',
        ]);
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pessoal', 'public');
        } else {
            // Insere uma foto padrão no caso da ausência de uma.
            $path = null;
        }

        $userId = null;
        if (User::currentUserIsMainAdmin() && $request->filled('email') && $request->filled('password')) {
             $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $userId = $user->id;
        }

        Pessoal::create([
            'nome' => $request->nome,
            'cargo' => $request->cargo,
            'foto' => $path,
            'user_id' => $userId,
        ]);

        return redirect()->route('admin.pessoal.index')->with('success', 'Pessoa adicionada com sucesso.');
    }

    public function edit(Pessoal $pessoal)
    {
        $isMainAdmin = User::currentUserIsMainAdmin();
        return view('admin.pessoal.edit', compact('pessoal', 'isMainAdmin'));
    }

    public function update(Request $request, Pessoal $pessoal)
    {
        $request->validate([
            'nome'=> 'required|string|max:255',
            'cargo'=> 'required|string|max:255',
            'foto' => 'nullable|file|mimes:png,jpg,jpeg|max:10240',
        ]);

        $pessoal->update($request->only(['nome','cargo','foto']));

        if (User::currentUserIsMainAdmin()) {
            if ($request->filled('email')) {
                 $request->validate([
                    'email' => 'required|email|unique:users,email,' . ($pessoal->user_id ?? 'NULL'),
                ]);
            }
            
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'min:6',
                ]);
            }

            if ($request->filled('email') || $request->filled('password')) {
                if ($pessoal->user) {
                    $pessoal->user->update([
                        'name' => $request->nome,
                        'email' => $request->filled('email') ? $request->email : $pessoal->user->email,
                        'password' => $request->filled('password') ? Hash::make($request->password) : $pessoal->user->password,
                    ]);
                } else {
                    // Cria usuário se não existir mas os campos foram preenchidos
                    if ($request->filled('email') && $request->filled('password')) {
                         $user = User::create([
                            'name' => $request->nome,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                        ]);
                        $pessoal->update(['user_id' => $user->id]);
                    }
                }
            }
        }

        return redirect()->route('admin.pessoal.index')->with('success', 'Pessoa atualizada com sucesso.');
    }

    public function destroy(Pessoal $pessoal)
    {
    // Remove o arquivo do storage
        Storage::disk('public')->delete($pessoal->foto);
        
        $pessoal->delete();

        return redirect()->route('admin.pessoal.index')->with('success', 'Pessoa excluída com sucesso.');
    }

}