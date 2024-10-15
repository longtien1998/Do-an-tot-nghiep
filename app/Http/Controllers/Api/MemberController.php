<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    public function index(){
        $users = User::All();
        if ($users->isEmpty()) {
            return response()->json([
               'message' => 'No member found',
            ], 404);
        }
        return response()->json([
            'message' => ' susses member',
            'token_type' => 'bearer',
            'user' => $users]);

    }
    public function create(){

    }
    public function store(Request $request){

    }
    public function show($id){
        
    }
    public function edit($id){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id){

    }
    public function search(Request $request){

    }
    public function pagination(Request $request){

    }
    public function filter(Request $request){

    }
    public function sort(Request $request){

    }
    public function import(Request $request){

    }
    public function export(Request $request){

    }
    public function exportToPdf($id){

    }
    public function exportToExcel($id){

    }
    public function exportToCsv($id){

    }
    public function exportToWord($id){

    }
    public function exportToPptx($id){

    }
    public function exportToJpg($id){

    }
    public function exportToTiff($id){

    }
    public function exportToGif($id){

    }
    public function exportToBmp($id){

    }

    public function exportToPng($id){

    }
}
