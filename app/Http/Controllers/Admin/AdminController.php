<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreFormRequest;
use App\Http\Requests\AdminUpdateFormRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        // ngan khong luu flash session vao cache
        $this->middleware('preventCache');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rowPerPage = 10;

        if ($request->ajax()) {
            return $this->search($request, $rowPerPage);
        }

        $admins = Admin::paginate($rowPerPage);

        return view('admins.admins.index')
                    ->with(['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreFormRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        try {
            Admin::create($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-manager.index')
                             ->with('error', 'Create failed');
        }

        return redirect()->route('admin.admin-manager.index')
                         ->with('success', 'Create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin_manager)
    {
        return view('admins.admins.show')->with('admin', $admin_manager);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateFormRequest $request, Admin $admin_manager)
    {
        $validated = $request->validated();

        try {
            $admin_manager->update($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-manager.index')
                         ->with('error', 'Update failed');
        }

        return redirect()->route('admin.admin-manager.index')
                         ->with('success', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function search($request, $rowPerPage)
    {
        // query builder
        $query = Admin::select('*');
        $rowPerPage = $request->row ?? $rowPerPage;

        // gender filter
        if ($request->has('gender') && $request->gender !== null) {
            $query->where('gender', $request->gender);
        }

        // search: name, email, address, phone
        if ($request->has('search')) {
            $query->where(function($subQuery) use($request) {
                $search = $request->search;

                $subQuery->where('name', 'LIKE', "%$search%")
                         ->orWhere('email', 'LIKE', "%$search%")
                         ->orWhere('address', 'LIKE', "%$search%")
                         ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        // get list of teachers match with key
        $admins = $query->paginate($rowPerPage);

        $html = view('admins.admins.load_index')
                ->with(['admins' => $admins])
                ->render();

        return response()->json(['html' => $html], 200);
    }
}
