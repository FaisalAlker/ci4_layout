<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Profile extends BaseController
{
    public function index()
    {
        helper(['form']);
        $email = session()->get('email');
        $userModel = new UsersModel();
        $data['user'] = $userModel->where('email', $email)->first();
        return view('profile', $data);
    }

    public function uploadAvatar(){
        $email = session()->get('email');
        $avatar = $this->request->getFile('avatar');

        // Validasi file
        $allowedTypes = ['image/jpeg', 'image/png']; // no svg
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (
            !$avatar->isValid() ||
            $avatar->hasMoved() ||
            !in_array($avatar->getClientMimeType(), $allowedTypes) ||
            !in_array($avatar->getClientExtension(), $allowedExtensions)
        ) {
            return redirect()->back()->with('message', 'Ekstensi file tidak didukung.');
        }

        // Generate nama file aman dari email
        $safeName = str_replace(['@', '.'], '_', strtolower($email));
        $ext = $avatar->getClientExtension();
        $newName = $safeName . '.' . $ext;

        // Folder path
        $folder = FCPATH . 'uploads/avatars/';

        // Delete all possible previous files with same base name 
        // Hapus jika nama file sama, tidak termasuk extension
        foreach (glob($folder . $safeName . '.*') as $oldFile) {
            unlink($oldFile);
        }

        // Save the new one
        $avatar->move($folder, $newName);

        // Update database
        $userModel = new UsersModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('message', 'User tidak ditemukan.');
        }

        $updated = $userModel->update($user['id'], ['avatar' => $newName]);

        if (!$updated) {
            return redirect()->back()->with('message', 'Tidak ada yang berubah.');
        }

        return redirect()->back()->with('message', 'Avatar berhasil diupload dan disimpan.');
    }
}
