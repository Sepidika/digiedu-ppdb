<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        // Ambil log terbaru, urutkan dari yang paling baru
        $logs = Activity::with('causer')->latest()->paginate(20);
        return view('admin.log.index', compact('logs'));
    }

    public function export()
    {
        // Fitur tambahan jika ingin export log ke Excel nantinya
        return back()->with('info', 'Fitur export log sedang dikembangkan.');
    }
}