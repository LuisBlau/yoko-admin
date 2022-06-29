<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Failedjob;

class TroubleshootingController extends Controller
{
    public function failedjobs()
    {
        $failedjobs = Failedjob::all();
        return view('troubleshooting.failedjobs')
            ->with('failedjobs', $failedjobs);
    }
}