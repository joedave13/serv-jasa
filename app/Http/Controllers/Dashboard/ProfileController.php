<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\UpdateDetailRequest;
use App\Http\Requests\Dashboard\Profile\UpdateProfileRequest;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $experience = UserExperience::where('user_detail_id', $user->user_detail->id)
            ->orderBy('id', 'asc')
            ->get();

        return view('pages.dashboard.profile', compact('user', 'experience'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request_profile, UpdateDetailRequest $request_detail, User $user)
    {
        // Get all request
        $profile_data = $request_profile->all();
        $detail_data = $request_detail->all();

        // Get old profile photo
        $old_photo = UserDetail::where('id', $user->id)->value('photo');

        // If user upload new photo, delete old photo
        if (isset($detail_data['photo'])) {
            if (File::exists('storage/' . $old_photo)) {
                File::delete('storage/' . $old_photo);
            } else {
                File::delete('storage/app/public/' . $old_photo);
            }
        }

        // Upload new photo to storage
        if (isset($detail_data['photo'])) {
            $detail_data['photo'] = $request_detail->file('photo')->store('assets/photo', 'public');
        }

        // Update user data
        $user->update($profile_data);

        // Get detail user data, update it
        $detail_user = UserDetail::find($user->user_detail->id);
        $detail_user->update($detail_data);

        // Save to experience user
        $experience_user_id = UserExperience::where('user_detail_id', $detail_user->id)->first();
        if (isset($experience_user_id)) {
            foreach ($profile_data['experience'] as $key => $value) {
                $experience_user = UserExperience::find($key);
                $experience_user->user_detail->id = $detail_user->id;
                $experience_user->experience = $value;
                $experience_user->save();
            }
        } else {
            foreach ($profile_data['experience'] as $key => $value) {
                if (isset($value)) {
                    $experience_user = new UserExperience();
                    $experience_user->user_detail->id = $detail_user->id;
                    $experience_user->experience = $value;
                    $experience_user->save();
                }
            }
        }

        toast()->success('Successfully update profile!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }

    public function deletePhoto()
    {
        // Get user photo
        $user_photo = UserDetail::where('user_id', Auth::user()->id)->value('photo');

        // Set photo value to null
        UserDetail::where('user_id', Auth::user()->id)->update([
            'photo' => null
        ]);

        // Delete user photo
        if (File::exists('storage/' . $user_photo)) {
            File::delete('storage/' . $user_photo);
        } else {
            File::delete('storage/app/public/' . $user_photo);
        }

        toast()->success('Successfully delete profile photo!');

        return back();
    }
}
