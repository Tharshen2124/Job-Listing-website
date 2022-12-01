<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // All Listings
    // from listing.php this function allows us to filter the tags that we want specifically when we click on them
    // Example, if i click on vue, only lists that have vue will show up
    //it actually filters based on the URL
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter
            (request(['tag', 'search']))->simplePaginate(6)//we can also use get() instead of paginate() but just use paginate() lol.
        ]);
    }//if we put a number inside of paginate like 2, it will show 2 listings max for each page
    //we can also use simplePaginate which uses previous and next buttons

    // Single Listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing'=> $listing
        ]);
    }

    // Show Create Form
    public function create() {
        return view('listings.create');
    }

    // Store Listing Data 
    public function store(Request $request) {
        $formFields = $request->validate([
            'title'       => 'required',
            'company'     => ['required', Rule::unique('listings', 'company')],
            'location'    => 'required',
            'website'     => 'required',
            'email'       => ['required', 'email'],
            'tags'        => 'required',
            'description' => 'required'
        ]);

        //store will form a folder called logos

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();


        //this contains all of the data from the form
        Listing::create($formFields);

        
        return redirect('/')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing) {
        
        //Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorised Action');
        }

        $formFields = $request->validate([
            'title'       => 'required',
            'company'     => ['required'],//the company thingy will fire off which prevents us from submitting it
            'location'    => 'required',
            'website'     => 'required',
            'email'       => ['required', 'email'],
            'tags'        => 'required',
            'description' => 'required'
        ]);

        //store will form a folder called logos

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

       
        //this contains all of the data from the form
        $listing->update($formFields);

        
        return back()->with('message', 'Listing updated successfully!');
    }

    //Delete Listing
    public function destroy(Listing $listing) {

         //Make sure logged in user is owner
         if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorised Action');
        }
        
        $listing->delete();
        return redirect ('/')->with('message', 'Listing deleted successfully');
    }

    //manage Listing
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
