<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProspectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prospect::orderBy('id', 'desc');

        if ($request->has('code') && !empty($request->code)) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->has('first_name') && !empty($request->first_name)) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }

        if ($request->has('last_name') && !empty($request->last_name)) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }

        if ($request->has('date_from') && !empty($request->date_from) && 
            $request->has('date_to') && !empty($request->date_to)) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to)->endOfDay()
            ]);
        }

        $allPropects = $query->get();

        $product = Product::all();
        $villes = TblVille::select('libelleVillle')->get();
        $professions = Profession::select('MonLibelle')->get();
        $secteurActivites = TblSecteurActivite::select('MonLibelle')->get();

        if ($request->has('print')) {
            $pdf = PDF::loadView('prospects.print', compact('allPropects'));
            return $pdf->download('rapport_prospection_'.date('Y-m-d').'.pdf');
        }

        return view('prospects.index', compact('allPropects', 'villes', 'professions', 'secteurActivites', 'product'));
    }
}
