<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceAdvantage;
use App\Models\ServiceThumbnail;
use App\Models\Tagline;
use App\Models\UserAdvantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::take(5)
            ->latest()
            ->get();

        return view('pages.landing.index', compact('services'));
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
    public function update(Request $request, $id)
    {
        return abort(404);
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

    public function explore()
    {
        $services = Service::latest()->get();

        return view('pages.landing.explore', compact('services'));
    }

    public function detail($id)
    {
        $service = Service::findOrFail($id);
        $service_advantages = ServiceAdvantage::where('service_id', $service->id)->get();
        $user_advantages = UserAdvantage::where('service_id', $service->id)->get();
        $service_thumbnails = ServiceThumbnail::where('service_id', $service->id)->get();
        $taglines = Tagline::where('service_id', $service->id)->get();

        return view('pages.landing.detail', compact('service', 'service_advantages', 'user_advantages', 'service_thumbnails', 'taglines'));
    }

    public function booking($id)
    {
        $service = Service::findOrFail($id);
        $buyer = Auth::user()->id;

        if ($service->user_id == $buyer) {
            toast()->warning('Sorry, You cannot book your own service!');
            return back();
        }

        $order = Order::create([
            'service_id' => $service->id,
            'freelancer_id' => $service->user_id,
            'buyer_id' => $buyer,
            'expired' => date('y-m-d', strtotime('+3 days')),
            'order_status_id' => 4
        ]);

        return redirect()->route('detail.booking.landing', $order->id);
    }

    public function detail_booking($id)
    {
        $order = Order::findOrFail($id);

        return view('pages.landing.booking', compact('order'));
    }
}
