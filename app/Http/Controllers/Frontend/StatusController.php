<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function form(Request $request)
    {
        $application = null;

        $code = $request->query('code');
        if (is_string($code) && $code !== '') {
            $application = Application::query()->where('registration_code', $code)->first();
        }

        return view('public.status', [
            'application' => $application,
            'code' => $code,
        ]);
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:40'],
        ]);

        return redirect()->route('status.form', ['code' => $validated['code']]);
    }
}
