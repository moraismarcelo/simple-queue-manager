<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\QueueJob;

class QueueController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Queue/Index', [
            'queues' => QueueJob::all(),
        ]);
    }

}
