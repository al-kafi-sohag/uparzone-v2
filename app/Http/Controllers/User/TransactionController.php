<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function index()
    {
        $data['transactions'] = UserTransaction::where(function($query) {
            $query->where('receiver_id', user()->id)
                  ->orWhere('sender_id', user()->id);
        })->latest()->paginate(10);
        
        return view('user.transaction.index', $data);
    }
}
