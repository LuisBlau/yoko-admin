<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Apicollection;

class ApiController extends Controller
{
    public function index()
    {
        /*$data = Apicollection::orderBy('created_at','desc')->get();
        for($i=0;$i<count($data);$i++) {
            $data[$i]['headers'] = strlen($data[$i]['headers']) > 50 ? substr($data[$i]['headers'],0,50)."..." : $data[$i]['headers'];
            $data[$i]['body'] = strlen($data[$i]['body']) > 50 ? substr($data[$i]['body'],0,50)."..." : $data[$i]['body'];
        }*/
        return view('api.apireview');
    }
    public function collection()
    {
        return view('api.apicollection');
    }
    public function tenstreet()
    {
        return view('api.tenstreetreview');
    }
}