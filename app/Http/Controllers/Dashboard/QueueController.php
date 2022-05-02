<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\QueueJob;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Artisan;

class QueueController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Queue/Index', [
            'queues' => QueueJob::all(),
        ]);
    }

    public function runJob(Request $request)
    {
        $job = QueueJob::find($request->input('id'));

        if($job->update(['queue' => 'urgent'])){
            Artisan::call('queue:work', [
                '--queue' => 'urgent',
                '--tries' => 1,
                '--stop-when-empty' => true,
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Job is running, you will receive an email when it is done.',
            ], 200);
    }


}
