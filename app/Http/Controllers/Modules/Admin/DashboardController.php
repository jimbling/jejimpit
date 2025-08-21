<?php

namespace App\Http\Controllers\Modules\Admin;


use App\Http\Controllers\Controller;
use App\Helpers\BreadcrumbHelper;

class DashboardController extends Controller
{
    protected $dashboardService;



    public function index()
    {
        return view('modules.admin.adminpanel', [
            'title' => 'Dashboard',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Dashboard']])
        ]);
    }
}
