<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('freelancer.profile.edit', [
            'user' => $user,
            'profile' => $user->freelancer,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'profile_photo' => [
                'nullable', 
                'mimes:jpg,jpeg', 
                'dimensions:min_with=200,min_height=200,max_height=1000,max_width=1000',
            ],
        ]);

        $user = Auth::user();
        $old_photo = $user->freelancer->profile_photo_path;

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filepath = $file->store('profile-photos', [
                'disk' => 'public'
            ]);

            $request->merge([
                'profile_photo_path' => $filepath,
            ]);

        }
        
        $user->freelancer()->updateOrCreate([], $request->all());

        $user->forceFill([
            'name' => $request->first_name . ' ' . $request->last_name,
        ])->save();

        if ($old_photo && $request->profile_photo_path) {
            Storage::disk('public')->delete($old_photo);
        }

        return redirect()->route('freelancer.profile.edit')
            ->with('success', 'Profile updated');

    }
}
