<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $admin = $this->admin($request);

        $breadcrumb = [
            ['text' => 'Profile', 'url' => null],
        ];

        return view('admin.admins.profile', [
            'title' => 'Update Profile',
            'sub_title' => 'Manage your admin account information and profile photo.',
            'breadcrumb' => $breadcrumb,
            'breadcrumbs' => $breadcrumb,
            'admin' => $admin,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $admin = $this->admin($request);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('admins', 'username')->ignore($admin->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('admins', 'phone')->ignore($admin->id),
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],

            'photo_media_id' => [
                'nullable',
                'integer',
                'exists:media,id',
            ],
        ]);

        $admin->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $admin->phone,
        ]);

        $this->syncPhoto(
            $request,
            $admin,
            $validated['photo_media_id'] ?? null
        );

        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }

    public function password()
    {
        $breadcrumb = [
            ['text' => 'Change Password', 'url' => null],
        ];

        return view('admin.admins.password', [
            'title' => 'Change Password',
            'sub_title' => 'Update your password to keep your admin account secure.',
            'breadcrumb' => $breadcrumb,
            'breadcrumbs' => $breadcrumb,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $admin = $this->admin($request);

        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        if (
            ! Hash::check(
                $validated['current_password'],
                $admin->password
            )
        ) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $admin->update([
            'password' => $validated['password'],
        ]);

        return back()->with(
            'success',
            'Password updated successfully.'
        );
    }

    private function admin(Request $request): Admin
    {
        $admin = $request->user('admin');

        abort_unless($admin instanceof Admin, 401);

        return $admin;
    }

    private function syncPhoto(
        Request $request,
        Admin $admin,
        ?int $mediaId
    ): void {
        if (! $request->hasFile('photo') && ! $mediaId) {
            return;
        }

        if ($admin->photo) {
            Storage::disk('public')->delete($admin->photo);
        }

        if ($request->hasFile('photo')) {
            $admin->update([
                'photo' => $request->file('photo')
                    ->store('admins', 'public'),
            ]);

            return;
        }

        $media = Media::findOrFail($mediaId);

        $filename = Str::uuid()
            . '-'
            . basename($media->file_name);

        $path = Storage::disk('public')->putFileAs(
            'admins',
            new File($media->getPath()),
            $filename
        );

        abort_if(
            $path === false,
            500,
            'Unable to save selected media file.'
        );

        $admin->update([
            'photo' => $path,
        ]);
    }
}