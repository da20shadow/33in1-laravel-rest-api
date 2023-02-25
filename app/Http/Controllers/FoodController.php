<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Constants\Health\StatusCategoryConst;
use App\Http\Requests\Food\AddFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Food;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10); // Set the number of records per page, default to 10.
            $query = $request->input('query', ''); // Get the search query parameter.
            $category = $request->input('category', ''); // Get the category parameter.

            $foods = Food::where('name', 'like', "%$query%") // Filter foods by name if query parameter is present.
            ->where('status','Published')
            ->when($category, function ($query) use ($category) {
                return $query->where('category', $category);}) // Filter food by category if type parameter is present.
            ->paginate($perPage); // Paginate the results.

            if ($foods->isNotEmpty()) {
                return response()->json($foods);
            }
            return response()->json(['message' => Messages::FOOD_NOT_FOUND],400);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => Messages::FOOD_NOT_FOUND,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    //For Admins
    public function getAll(Request $request): JsonResponse
    {
        //TODO: Return All Foods Published and Waiting Approval! if admin
        $user = auth()->user();
        //Check if the user is admin
        if ($user['role'] != 'ROLE_ADMIN'){
            return response()->json([
                'message' => Messages::NO_RIGHTS,
            ], 400);
        }
        try {
            $perPage = $request->input('per_page', 10); // Set the number of records per page, default to 10.
            $query = $request->input('query', ''); // Get the search query parameter.
            $category = $request->input('category', ''); // Get the category parameter.
            $status = $request->input('status', 'Published'); // Get the status parameter.

            $foods = Food::where('name', 'like', "%$query%") // Filter foods by name if query parameter is present.
            ->where('status','Published')
                ->when($category, function ($query) use ($category) {
                    return $query->where('category', $category);}) // Filter food by category if type parameter is present.
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);})
                ->paginate($perPage); // Paginate the results.

            if ($foods->isNotEmpty()) {
                return response()->json($foods);
            }
            return response()->json(['message' => Messages::FOOD_NOT_FOUND],400);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => Messages::FOOD_NOT_FOUND,
                'error' => $exception->getMessage()
            ],400);
        }

    }

    public function store(AddFoodRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $status = StatusCategoryConst::FOOD_STATUS_PUBLISHED;
            //Check if the user is admin
            if ($user['role'] != 'ROLE_ADMIN'){
                $status = StatusCategoryConst::FOOD_STATUS_PENDING;
            }
            $validatedData = $request->validated();
            //Check if food with name already added
            if ($this->foodExistByName($validatedData['name'])) {
                return response()->json([
                    'message' => Messages::FOOD_EXIST,
                ], 400);
            }

            //Set the status to pending if is not admin
            $validatedData['status'] = $status;

            $result = DB::table('food')->insert([$validatedData]);
            if ($result) {
                return response()->json(['message' => Messages::ADD_FOOD_SUCCESS], 201);
            }
            return response()->json(['message' => Messages::ADD_FOOD_FAILURE], 400);

        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $exercise = DB::table('food')
                ->where(['id' => $id])
                ->first();
            if ($exercise) {
                return response()->json($exercise);
            }
            return response()->json([
                'message' => Messages::FOOD_NOT_FOUND,
            ], 400);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(UpdateFoodRequest $request, string $id): JsonResponse
    {
        try {
            $user = auth()->user();
            //Check if user is admin
            if ($user['role'] != 'ROLE_ADMIN'){
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $validatedData = $request->validated();
            //Check if food exist
            if (!$this->foodExistById($id)) {
                return response()->json([
                    'message' => Messages::FOOD_NOT_FOUND,
                ], 400);
            }
            $result = DB::table('food')
                ->where(['id' => $id])
                ->update($validatedData);
            if ($result) {
                return response()->json(['message' => Messages::UPDATE_FOOD_SUCCESS]);
            }
            return response()->json(['message' => Messages::UPDATE_FOOD_FAILURE], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $user = auth()->user();
            //Check if user is admin
            if ($user['role'] != 'ROLE_ADMIN'){
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $result = Food::where('id',$id)->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETE_FOOD_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETE_FOOD_FAILURE],400);
        }catch (QueryException $exception){
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    private function foodExistByName(string $name): bool
    {
        try {
            $food = Food::where(['name' => $name])->first();
            if ($food){ return true; }
        } catch (QueryException $exception) {
            response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
            return true;
        }
        return false;
    }

    private function foodExistById(string $id)
    {
        try {
            return Food::where(['id' => $id])->first();
        } catch (QueryException $exception) {
            response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
            return null;
        }
    }
}
