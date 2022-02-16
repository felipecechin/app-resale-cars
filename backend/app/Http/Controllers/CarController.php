<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;
use Tymon\JWTAuth\Facades\JWTAuth;

class CarController extends Controller {

    public function __construct(Car $car) {
        $this->car = $car;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $numItemsPage = 10;
        if ($request->get('page')) {
            $page = $request->get('page');
            $offset = ($page - 1) * $numItemsPage;
        } else {
            $offset = 0;
        }

        if ($request->get('search')) {
            $search = '%' . $request->get('search') . '%';
        } else {
            $search = '%%';
        }
        $query = $this->car->where('brand', 'like', $search)->orWhere('model', 'like', $search);
        $total_cars = $query->count();
        $cars = $query->skip($offset)->take($numItemsPage)->get();

        return response()->json(['total' => $total_cars, 'cars' => $cars]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate($this->car->rules());

        $car = $this->car->create([
            'brand' => $request->get('brand'),
            'model' => $request->get('model'),
            'km' => $request->get('km'),
            'color' => $request->get('color'),
            'transmission' => $request->get('transmission')
        ]);
        if ($car->id) {
            Action::create([
                'user_id' => auth()->id(),
                'car_id' => $car->id,
                'type' => 'C',
                'occurrence' => now()
            ]);
        }

        return response()->json($car, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $car = $this->car->find($id);
        if ($car === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        return response()->json($car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $car = $this->car->find($id);
        if ($car === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }
        $request->validate($car->rules());
        $car->fill($request->all());
        $car->save();
        Action::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'type' => 'U',
            'occurrence' => now()
        ]);
        return response()->json($car);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $car = $this->car->find($id);
        if ($car === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }
        $car->delete();
        Action::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'type' => 'D',
            'occurrence' => now()
        ]);
        return response()->json(['msg' => 'O carro foi removido com sucesso!']);
    }
}
