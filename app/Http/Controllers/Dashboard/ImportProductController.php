<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportProductController extends Controller
{
    //
    public function create()
    {
        return view('dashboard.products.import');
    }

    public function store(Request $request)
    {
        //to call job and run 
        $job = new ImportProducts($request->post('count'));
        $job->onQueue('import')->delay(now()->addSeconds(5));
        $this->dispatch($job);

        return redirect()
            ->route('dashboard.products.index')
            ->flush('success', 'Import is Running Now...');
    }
}