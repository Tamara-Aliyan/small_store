<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Images;
use App\Contracts\Responses;
use App\Models\API\V1\{User,Role};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Auth};
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\{
    StoreUserRequest,
    UpdateUserRequest
};

class UsersController extends Controller
{
    use Images,Responses;

    public function index(Request $request)
    {
        // $this->authorize('viewAny', User::class);
        if ($request->hasAny(['sort_by_date', 'sort_by_name', 'sort_by_products_number'])) {
            return (new FilterController())->filterUsers($request);
        }
        return $this->indexOrShowResponse('users', User::all());
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        return DB::transaction(function() use ($request) {
            $request_image = $request->image;
            $image = $this->setImagesName([$request_image])[0];
            $user = User::create($request->all());
            $user->images()->create(['image_name' => $image]);
            $this->saveImages([$request_image], [$image], 'User');
            // Get the role ID based on the role name
            $role = Role::where('name', $request->role)->first();

            // Assign the role to the user
            if ($role) {
                $user->roles()->attach($role->id);
            } else {
                // Handle if the role is not found
                return response()->json(['message' => 'Role not found'], 404);
            }

            return $this->sudResponse('User Created Successfully', 201);
        });
    }

    public function show(User $user)
    {
        $this->authorize('view', User::class);
        return $this->indexOrShowResponse('user', $user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', User::class);
        return DB::transaction(function() use ($request, $user) {

            $user->update($request->except('password'));

            if($request->hasFile('image')) {
                $request_image = $request->image;
                $current_images = $user->images()->pluck('image_name')->toArray();
                $image = $this->setImagesName([$request_image])[0];
                $user->images()->update(['image_name' => $image]);
                $this->saveImages([$request_image], [$image], 'User');
                $this->deleteImages('User', $current_images);

            }

            return $this->sudResponse('User Updated Successfully');
        });
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);
        return DB::transaction(function() use ($user) {
            $current_images = $user->images()->pluck('image_name')->toArray();
            $user->images()->delete();
            $user->delete();
            $this->deleteImages('User', $current_images);
            return $this->sudResponse('User Deleted Successfully');
        });
    }

}
