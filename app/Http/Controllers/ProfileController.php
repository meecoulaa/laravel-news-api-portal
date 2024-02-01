<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\OptionsMapper;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\UserLogs;

class ProfileController extends Controller
{
    

     /**
     * @OA\Get(
     *     path="/profile/edit",
     *     summary="Edit user profile",
     *     tags={"Profile"},
     *     @OA\Response(response="200", description="User profile edit view"),
     * )
     */

     /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        if ($request->has('id')) {
            $userId = $request->input('id');
            $user = User::find($userId);

            if (!$user) {
                return redirect()->route('topHeadlines')->with('error', 'User not found.');
            }
        } else {
            $user = Auth::user();

            $options = [ 
                'country' => $user->country,
                'category' => $user->category,
                'language' => $user->language,
            ];
        }
        
        $optionMapper = new OptionsMapper();
        $data = [
            'categories' => $optionMapper->categories,            
            'countries' => $optionMapper->countries,
            'languages' => $optionMapper->languages,
        ];

        return view('profile.edit', [
            'user' => $request->user(),
            'data' => $data,
            'options' => $options,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/profile/update",
     *     summary="Update user profile information",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProfileUpdateRequest"),
     *     ),
     *     @OA\Response(response="302", description="Redirect to profile edit view"),
     * )
     */

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        
        if($request->filled('isAdmin')){
            $request->validate([
                'category' => ['required', 'string'],
                'name' => ['required', 'string'],
            ]);
            $updateData = [
                'category' => $request->input('category'),
                'country'  => $request->input('country'),
                'language' => $request->input('language'),
                'name' => $request->input('name'),
                'is_admin' => $request->input('is_admin'),
            ];
            $user = User::find($request['id']);
            $user->update($updateData);
            
            $log['action']='update';
            $log['description']='Updated user '.$user->name;
            $log['user_id']=auth()->user()->id;
            UserLogs::create($log);

            return redirect()->back()->with('success', 'Profile saved successfully.');
        }
        elseif($request->filled('category')){
            $user=auth()->user();
            $request->validate([
                'category' => ['required', 'string']
            ]);

            $user->fill($request->only(['category','country','language',]));
            $user->save();

            $log['action']='update';
            $log['description']='Updated user '.$user->name;
            $log['user_id']=auth()->user()->id;
            UserLogs::create($log);

            return redirect()->back()->with('success', 'Profile saved successfully.');
        }
        else{
            $user=auth()->user();
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)],
            ]);

            $user->fill($request->only(['name','email']));
            
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
            $user->save();

            $log['action']='update';
            $log['description']='Updated user '.$user->name;
            $log['user_id']=auth()->user()->id;
            UserLogs::create($log);

            return redirect()->back()->with('success', 'Profile saved successfully.');
        }
    }

    /**
     * @OA\Post(
     *     path="/profile/destroy",
     *     summary="Delete user account",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserDeletionRequest"),
     *     ),
     *     @OA\Response(response="302", description="Redirect to home page after account deletion"),
     * )
     */

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $log['action']='delete';
        $log['description']=$user->name. ' - user deleted';
        $log['user_id']=auth()->user()->id;
        UserLogs::create($log);

        Auth::logout();
        $user->delete();

        

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        

        return Redirect::to('/'); 
    }
}
