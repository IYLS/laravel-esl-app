<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:2048',
        ], [
            'avatar.image' => 'El archivo debe ser una imagen.',
            'avatar.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif, webp o heic.',
            'avatar.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        // Si se sube una nueva imagen
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Guardar referencia al avatar anterior antes de actualizar
            $oldAvatar = $user->avatar;

            // Sanitizar nombre del archivo
            $originalName = $request->file('avatar')->getClientOriginalName();
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $sanitizedName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nameWithoutExtension);
            $avatarName = time() . '_' . $sanitizedName . '.' . $extension;
            
            // Guardar nueva imagen
            $avatarPath = $request->file('avatar')->storeAs('avatars', $avatarName, 'public');
            
            // Actualizar el avatar del usuario en la base de datos
            $user->avatar = $avatarName;
            $user->save();
            
            // Eliminar avatar anterior solo después de guardar exitosamente el nuevo
            if ($oldAvatar && $oldAvatar !== $avatarName && Storage::disk('public')->exists('avatars/' . $oldAvatar)) {
                Storage::disk('public')->delete('avatars/' . $oldAvatar);
            }
        }

        return redirect()->route('profile.show')->with('success', 'Perfil actualizado exitosamente.');
    }
}
