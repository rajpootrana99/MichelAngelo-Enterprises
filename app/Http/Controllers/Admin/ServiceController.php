<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('service.index');
    }

    public function fetchServices(){
        $services = Service::all();
        return response()->json([
            'status' => true,
            'services' => $services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|max:3096',
        ]);
        if (!$validator->passes()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        $service = Service::create($request->all());
        $this->storeImage($service);
        if ($service){
            return response()->json(['status' => 1, 'message' => 'Service added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($service)
    {
        $service = Service::find($service);
        if ($service){
            return response()->json([
                'status' => 200,
                'service' => $service,
            ]);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => 'Service not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $service)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);
        if (!$validator->passes()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        $service = Service::find($service);
        $service->update($request->all());
        $this->storeImage($service);
        return response()->json(['status' => 1, 'message' => 'Service updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($service)
    {
        $service = Service::find($service);
        if (!$service){
            return response()->json([
                'status' => 0,
                'message' => 'Service not exist',
            ]);
        }
        $service->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Service Deleted Successfully',
        ]);
    }

    public function storeImage($service){
        $service->update([
            'image' => $this->imagePath('image', 'service', $service),
        ]);
    }
}
