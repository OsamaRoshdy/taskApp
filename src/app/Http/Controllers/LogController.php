<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __invoke()
    {
        $logs = Log::with(['subject', 'user'])->paginate(10);
        return view('logs.index', compact('logs'));
    }
}
