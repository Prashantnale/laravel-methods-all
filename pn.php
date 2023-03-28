<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\tbl_lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodolistController extends Controller
{
    public function index()
    {
        $data = [];
        $admin = false;
        $todos = [];
        if (Auth::user()->user_type == 1) {
            $usersList = User::where('status', 0)->where('user_type', 2)->get();
            // getting tasks for that particular user
            foreach ($usersList as $key => $user) {
                $userData = [];
                $tasks = tbl_lead::where('tbl_user_id', $user->id)->get();
                $userData[] = array("user_data" => $user, "tasks" => $tasks);
                $data[] = $userData;
            }
            $admin = true;
        } else {
            $todos = tbl_lead::where('tbl_user_id', Auth::id())->get();
        }
        return view('/admin/todulist/index', compact('data', 'admin', 'todos'));
    }
    
//     how to jion one table two jion select use in laravel
//         return $data =  DB::table('tbl_leads')
//             ->join('tbl_customers', 'tbl_customers.customer_id', 'tbl_leads.tbl_cust_id')
//             ->join('tbl_shift_tasks', 'tbl_shift_tasks.task_lead_id', 'tbl_leads.lead_id')
//             ->join('users', 'users.id', 'tbl_shift_tasks.shift_user_id')
//             ->join('users as get_user', 'get_user.id', 'tbl_shift_tasks.task_get_user_id')
//             ->select('users.*', 'get_user.name as get_user_name', 'get_user.id as get_user_id', "tbl_customers.*")
//             ->latest('tbl_leads.created_at')
//             ->get();
}
