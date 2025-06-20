<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all menu items
        $menu = \App\Models\Menu::all();

        // Return the menu items as a JSON response
        return (MenuResource::collection($menu))
            -> response()
            ->setStatusCode(200);
    }

    public function store(MenuRequest $request)
    {

        $payload = $request->validated();
        $user = 

        // Create a new menu item
        $menu = \App\Models\Menu::create($payload);

        // Return the created menu item as a JSON response
        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $menu = \App\Models\Menu::where('id', $id)->first();

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu item not found',
            ], 404);
        }

        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(200);
    }    

    public function update(MenuRequest $request, $id)
    {
        $menu = \App\Models\Menu::where('id', $id)->first();

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu item not found',
            ], 404);
        }

        $menu->update($request->validated());

        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(200);
    }
    
    public function destroy($id)
    {
        $menu = \App\Models\Menu::where('id', $id)->first();

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu item not found',
            ], 404);
        }

        $menu->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu item deleted successfully',
        ], 200);
    }
}
