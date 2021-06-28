<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Validator;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $companies = Company::all();

        return $this->sendResponse($companies, 'Companies retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
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
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:companies'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $company = Company::create($input);

        return $this->sendResponse($company, 'Company created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);

        return $this->sendResponse($company, 'Company retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Company $company)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'name' => 'required|string|max:255',
                'code' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('companies')->ignore($company),
                ]
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $company->name = $request->input('name');
        $company->code = $request->input('code');
        $company->save();

        return $this->sendResponse($company, 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return $this->sendResponse($company, 'Company deleted successfully.');
    }
}
