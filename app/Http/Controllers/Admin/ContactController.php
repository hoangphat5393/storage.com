<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backend\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public $data = [];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if (Auth::guard('admin')->user()->admin_level == 99999) {
        //     $db = Contact::select('*');

        //     if (request('search_name') != '') {
        //         $db->where('name', 'like', '%' . request('search_name') . '%');
        //     }
        //     $count_item = $db->count();
        //     $data_post = $db->orderByDesc('id')->paginate(20)->appends($appends);
        // } else {
        //     $data_post = Contact::where('admin_id', '=', Auth::guard('admin')->user()->id)
        //         ->orderByDesc('id')
        //         ->paginate(20)
        //         ->appends($appends);
        //     $count_item = Contact::where('admin_id', '=', Auth::guard('admin')->user()->id)
        //         ->count();
        // }

        $data = Contact::filter($request)->orderByDesc('id')->paginate(20)->appends($request->all());

        $count_item = $data->count();

        return view('backend.contact.index')->with(['data' => $data, 'total_item' => $count_item]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.contact.single', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact, $id)
    {
        $contact = $contact->find($id);
        return view('backend.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact, $id)
    {
        $contact = $contact->findorfail($id);
        if ($contact) {
            return view('backend.contact.single', compact('contact'));
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact, $id)
    {
        $contact->find($id)->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Contact deleted successfully.');
    }
}
