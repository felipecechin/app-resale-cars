<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller {

    public function __construct(Action $action) {
        $this->action = $action;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $numItemsPage = 5;
        if ($request->get('page')) {
            $page = $request->get('page');
            $offset = ($page - 1) * $numItemsPage;
        } else {
            $offset = 0;
        }

        $query = $this->action->with('user:id,name')->with('car:id,brand,model');
        if ($request->get('user')) {
            $query->where('user_id', $request->get('user'));
        }

        if ($request->get('type')) {
            $query->where('type', $request->get('type'));
        }

        $total = $query->count();
        $actions = $query->skip($offset)->take($numItemsPage)->orderByDesc('occurrence')->get();

        return response()->json(['total' => $total, 'actions' => $actions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard() {
        $userActions = Action::select(DB::raw('count(*) as count'), 'users.name')
            ->join('users', 'actions.user_id', '=', 'users.id')
            ->groupBy('users.id')
            ->get();
        $typeActions = Action::select(DB::raw('count(*) as count'), 'type')
            ->groupBy('type')
            ->get();
        $totalCars = Car::count();
        return response()->json(['userActions' => $userActions, 'typeActions' => $typeActions, 'totalCars' => $totalCars]);
    }
}
