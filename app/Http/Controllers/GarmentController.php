<?php

namespace App\Http\Controllers;

use App\BasePattern;
use App\BaseSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GarmentController extends Controller
{
    public function index(){
        $garments = DB::select('SELECT * FROM garments');

        $baseSizes = DB::select('SELECT base_sizes.base_size_id , base_sizes.base_size , base_sizes.garment_id ,
        garments.garment_name FROM base_sizes INNER JOIN garments
        ON base_sizes.garment_id = garments.garment_id');

        $basePatterns = DB::select('SELECT base_patterns.base_pattern_id , base_patterns.base_pattern , base_patterns.garment_id ,
        garments.garment_name FROM base_patterns INNER JOIN garments
        ON base_patterns.garment_id = garments.garment_id');

        $results = array(
            'garments' => $garments,
            'baseSizes' => $baseSizes,
            'basePatterns' => $basePatterns,
        );
        return view('garment')->with($results);
    }

    public function changeCosumption(Request $request){

        $update = DB::update("UPDATE garments SET fabric_consumption = '".$request->gFabric."' , lining_consumption = '".$request->gLining."'
           where garment_id = ?", [$request->gId]);
    }

    public function addBaseSize(Request $request){

        $bS =new BaseSize;
        $bS->base_size = $request->bSize;
        $bS->garment_id = $request->bGarment;
        $saved = $bS->save();

        if($saved) {
            $msg = 'Base Size added';
        } else{
            $msg = 'Data not saved';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function changeBaseSize(Request $request){

        $update = DB::update("UPDATE base_sizes SET base_size = '".$request->bs."' , garment_id = '".$request->bsGarment."'
           where base_size_id = ?", [$request->bsId]);
    }

    public function deleteBaseSize($id){
        $delete = DB::delete("DELETE FROM base_sizes WHERE base_size_id=?",[$id]);
    }

    public function addBasePattern(Request $request){

        $bP =new BasePattern;
        $bP->base_pattern = $request->bPattern;
        $bP->garment_id = $request->bPGarment;
        $saved = $bP->save();

        if($saved) {
            $msg = 'Base Pattern added';
        } else{
            $msg = 'Data not saved';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function changeBasePattern(Request $request){

        $update = DB::update("UPDATE base_patterns SET base_pattern = '".$request->bp."' , garment_id = '".$request->bpGarment."'
           where base_pattern_id = ?", [$request->bpId]);
    }

    public function deleteBasePattern($id){
        $delete = DB::delete("DELETE FROM base_patterns WHERE base_pattern_id=?",[$id]);
    }
}
