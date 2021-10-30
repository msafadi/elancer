<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    public function create()
    {
        
        return view('otp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobile_number' => ['required']
        ]);

        $client = $this->getClient();

        $request = new \Vonage\Verify\Request($request->post('mobile_number'), "Vonage");
        $response = $client->verify()->start($request);

        Session::put('nexmo.verify.requestId', $response->getRequestId());

        return redirect()->route('otp.verify');
    }

    public function verifyForm()
    {
        return view('otp.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $client = $this->getClient();

        try {
            $requestId = Session::get('nexmo.verify.requestId');
            $result = $client->verify()->check($requestId, $request->post('code'));

        } catch (\Vonage\Client\Exception\Request $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        Session::forget('nexmo.verify.requestId');

        return redirect()->route(RouteServiceProvider::HOME);
    }

    protected function getClient()
    {
        $basic  = new \Vonage\Client\Credentials\Basic(config('services.nexmo.key'), config('services.nexmo.secret'));
        $client = new \Vonage\Client(new \Vonage\Client\Credentials\Container($basic));

        return $client;
    }
}
