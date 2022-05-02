<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QueueJob;
class QueueController extends Controller
{
    public function index()
    {
        return response()->json([
            'error' => false,
            'queues' => QueueJob::all(),
        ], 200);

    }
}
