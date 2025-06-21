<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    function getRandomMenu() : JsonResponse {
        $menu = Menu::with("merchants")->inRandomOrder()->get();

        return (MenuResource::collection($menu))->response()->setStatusCode(200);
    }

    public function index()
    {
        // Retrieve all menu items
        $user = Auth::user();
        $merchant = Merchant::firstWhere("user_id", $user->id);
        $menu = Menu::with("merchants")->where("merchant_id", $merchant->id)->get();

        // Return the menu items as a JSON response
        return (MenuResource::collection($menu))
            -> response()
            ->setStatusCode(200);
    }

    public function store(MenuRequest $request)
    {

        $payload = $request->validated();
        $user = Auth::user();
        $merchant = Merchant::firstWhere("user_id", $user->id);

        // Create a new menu item
        $menu = \App\Models\Menu::create($payload);
        $menu->merchant_id = $merchant->id;
        $menu->save();

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
