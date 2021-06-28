<?php

namespace App\Http\Controllers\Api;

use App\Models\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class LayoutController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $layouts = Layout::all();

        return $this->sendResponse($layouts, 'layouts retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'layout_filename' => 'required|file|mimes:jpg,png',
                'company_id' => 'required|integer|exists:companies,id'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $layout = Layout::create($input);

        if ($request->hasFile('layout_filename') && $fileName = $this->saveImage($request)) {
            $layout->layout_filename = $fileName;
            $layout->save();
            return $this->sendResponse($layout, 'layouts created successfully.');
        }

        return $this->sendError('something goes wrong.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $layout = Layout::findOrFail($id);

        return $this->sendResponse($layout, 'layout retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Layout $layout
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Layout $layout)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'layout_filename' => 'required|file|mimes:jpg,png',
                'company_id' => 'required|integer|exists:companies,id'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->hasFile('layout_filename') && $fileName = $this->saveImage($request)) {
            $layout->layout_filename = $fileName;
            $layout->save();
            return $this->sendResponse($layout, 'layout updated successfully.');
        }

        return $this->sendError('something goes wrong.');
    }

    /**
     * Remove the specified resource from storage and delete linked image.
     *
     * @param Layout $layout
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Layout $layout)
    {
        if ($layout->delete()) {
            Storage::disk('public')
                ->delete(config('app.path_to_layouts', 'layouts') .'/'. $layout->layout_filename);
            return $this->sendResponse($layout, 'layout deleted successfully.');
        }
    }

    /**
     * Save image to the public disk
     * @param Request $request
     * @return string|null
     */
    protected function saveImage(Request $request)
    {
        $layout = $request->file('layout_filename');
        $fileName = md5(microtime() . $layout->getClientOriginalName()) . '.' . $layout->getClientOriginalExtension();
        if ($request->layout_filename->storeAs('layouts', $fileName, 'public')) {
            return $fileName;
        }
        return null;
    }

}
