<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Recipe as RecipeResource;
use App\Models\Recipe;


class RecipeController extends BaseController
{
        /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
            public function store(Request  $request)
            {
            
                if(Auth::user()->role=="1"){

                    $path = $request->file('image')->store('images');
                    Recipe::create(['title'=>$request->title,'recipe'=>$request->recipe,'time'=>$request->time,'image'=>$path]);

        
                    return response()->json(['message' => 'Image uploaded and recipe info saved successfully.']);
                }else{
                    return response()->json(['message' => 'Unauthenticated user']);
                }
            }


            public function show($id)
            {
            $recipe = Recipe::findOrFail($id);
            
            if ($recipe==null) {
            return $this->sendError('Recipe not found.');
            }

            return $this->sendResponse(new RecipeResource($recipe), 'Recipe retrieved successfully.');
            } 


            /**
                * Update the specified resource in storage.
                *
                * @param  \Illuminate\Http\Request  $request
                * @param  int  $id
                * @return \Illuminate\Http\Response
                */

                public function update(Request $request, $id)
            {

                if(Auth::user()->role=="1"){
                $recipe = Recipe::find($id);
                $recipe->title = $request->input('title');
                $recipe->recipe = $request->input('recipe');
                $recipe->time = $request->input('time');
                $recipe->save();

                return response()->json($recipe, 200);
                }
                else{
                    return response()->json(['message' => 'Recipe updated successfully']);
                }
            }




    public function destroy(Request $request, $id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();
        return response()->json($recipe);
        return $this->sendResponse([], 'Recipe deleted successfully.');
    }



}  