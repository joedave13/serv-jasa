<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Service\StoreRequest;
use App\Http\Requests\Dashboard\Service\UpdateRequest;
use App\Models\Service;
use App\Models\ServiceAdvantage;
use App\Models\ServiceThumbnail;
use App\Models\Tagline;
use App\Models\UserAdvantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('user_id', Auth::user()->id)
            ->latest()
            ->get();

        return view('pages.dashboard.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        // Add to services
        $service = Service::create($data);


        // Add to service advantages
        foreach ($data['service_advantage'] as $key => $value) {
            ServiceAdvantage::create([
                'service_id' => $service->id,
                'advantage' => $value
            ]);
        }
        // Add to user advantages
        foreach ($data['user_advantage'] as $key => $value) {
            UserAdvantage::create([
                'service_id' => $service->id,
                'advantage' => $value
            ]);
        }

        // Add to taglines
        foreach ($data['tagline'] as $key => $value) {
            Tagline::create([
                'service_id' => $service->id,
                'tagline' => $value
            ]);
        }

        // Add to service thumbnails
        if ($request->hasFile('service-thumbnail')) {
            foreach ($request->file('service-thumbnail') as $file) {
                $path = $file->store('assets/service/thumbnail', 'public');
                ServiceThumbnail::create([
                    'service_id' => $service->id,
                    'thumbnail' => $path
                ]);
            }
        }

        toast()->success('Service created successfully!');
        return redirect()->route('member.service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        $service_advantages = ServiceAdvantage::where('service_id', $service->id)->get();
        $user_advantages = UserAdvantage::where('service_id', $service->id)->get();
        $taglines = Tagline::where('service_id', $service->id)->get();
        $service_thumbnails = ServiceThumbnail::where('service_id', $service->id)->get();

        return view('pages.dashboard.service.detail', compact('service', 'service_advantages', 'user_advantages', 'taglines', 'service_thumbnails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $service_advantages = ServiceAdvantage::where('service_id', $service->id)->get();
        $user_advantages = UserAdvantage::where('service_id', $service->id)->get();
        $taglines = Tagline::where('service_id', $service->id)->get();
        $service_thumbnails = ServiceThumbnail::where('service_id', $service->id)->get();

        return view('pages.dashboard.service.edit', compact('service', 'service_advantages', 'user_advantages', 'taglines', 'service_thumbnails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Service $service)
    {
        $data = $request->all();

        // Update service data
        $service->update($data);

        // Update service advantage
        foreach ($data['service_advantage'] as $key => $value) {
            $service_advantage = ServiceAdvantage::find($key);
            $service_advantage->advantage = $value;
            $service_advantage->save();
        }

        // Add new service advantage
        if (isset($data['service_advantage'])) {
            foreach ($data['service_advantage'] as $key => $value) {
                ServiceAdvantage::create([
                    'service_id' => $service->id,
                    'advantage' => $value
                ]);
            }
        }

        // Update user advantage
        foreach ($data['user_advantage'] as $key => $value) {
            $user_advantage = UserAdvantage::find($key);
            $user_advantage->advantage = $value;
            $user_advantage->save();
        }

        // Add new user advantage
        if (isset($data['user_advantage'])) {
            foreach ($data['user_advantage'] as $key => $value) {
                UserAdvantage::create([
                    'service_id' => $service->id,
                    'advantage' => $value
                ]);
            }
        }

        // Update tagline
        foreach ($data['tagline'] as $key => $value) {
            $tagline = Tagline::find($key);
            $tagline->advantage = $value;
            $tagline->save();
        }

        // Add new tagline
        if (isset($data['tagline'])) {
            foreach ($data['tagline'] as $key => $value) {
                Tagline::create([
                    'service_id' => $service->id,
                    'tagline' => $value
                ]);
            }
        }

        // Update thumbnail service
        if ($request->hasFile('service-thumbnails')) {
            foreach ($request->file('service-thumbnails') as $key => $value) {
                // Get old thumbnail
                $old_thumbnail = ServiceThumbnail::where('id', $key)->first();

                $path = $value->store(
                    'assets/service/thumbnail',
                    'public'
                );

                // Update thumbnail
                $service_thumbnail = ServiceThumbnail::find($key);
                $service_thumbnail->thumbnail = $path;
                $service_thumbnail->save();

                // Delete old thumbnail
                if (File::exists('storage/' . $old_thumbnail->thumbnail)) {
                    File::delete('storage/' . $old_thumbnail->thumbnail);
                } else {
                    File::delete('storage/app/public/' . $old_thumbnail->thumbnail);
                }
            }
        }

        // Add new service thumbnail
        if ($request->hasFile('service-thumbnail')) {
            foreach ($request->file('service-thumbnail') as $key => $value) {
                foreach ($request->file('service-thumbnail') as $file) {
                    $path = $file->store(
                        'assets/service/thumbnail',
                        'public'
                    );

                    $service_thumbnail = new ServiceThumbnail();
                    $service_thumbnail->service_id = $service->id;
                    $service_thumbnail->thumbnail = $path;
                    $service_thumbnail->save();
                }
            }
        }

        toast()->success('Service updated successfully!');
        return redirect()->route('member.service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
