<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Models\Packages;
use App\Http\Controllers\Controller;

class TraceabilityController extends Controller
{
    public function index($package_id)
    {
        $package = Packages::with('market')->find($package_id);
        return view('roles.consumerPackage', compact('package'));
    }
}
