<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkModel;

class LinkController extends Controller
{
	public function store(Request $request){

		$link = new LinkModel();

		$link->type = $request->type;
		$link->source = $request->source;
		$link->target = $request->target;

		$link->save();

		return response()->json([
			"action"=> "inserted",
			"tid" => $link->id
		]);
	}

	public function update($id, Request $request){
		$link = LinkModel::find($id);

		$link->type = $request->type;
		$link->source = $request->source;
		$link->target = $request->target;

		$link->save();

		return response()->json([
			"action"=> "updated"
		]);
	}

	public function destroy($id){
		$link = LinkModel::find($id);
		$link->delete();

		return response()->json([
			"action"=> "deleted"
		]);
	}
}