<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QueueController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Queue/Index', [
            'queue' => [
                'name' => 'Queue'
            ]
        ]);
    }

}
