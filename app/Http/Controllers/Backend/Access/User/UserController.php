<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Http\Requests\Backend\Access\User\CreateUserRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Http\Requests\Backend\Access\User\EditUserRequest;
use App\Http\Requests\Backend\Access\User\MarkUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Http\Requests\Backend\Access\User\DeleteUserRequest;
use App\Http\Requests\Backend\Access\User\RestoreUserRequest;
use App\Http\Requests\Backend\Access\User\ChangeUserPasswordRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Http\Requests\Backend\Access\User\PermanentlyDeleteUserRequest;
use App\Repositories\Frontend\User\UserContract as FrontendUserContract;
use App\Http\Requests\Backend\Access\User\ResendConfirmationEmailRequest;
use App\Models\Access\User\User as userr;
use Illuminate\Http\Request;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * @var UserContract
     */
    protected $users;

    /**
     * @var RoleRepositoryContract
     */
    protected $roles;

    /**
     * @var PermissionRepositoryContract
     */
    protected $permissions;

    /**
     * @param UserContract                 $users
     * @param RoleRepositoryContract       $roles
     * @param PermissionRepositoryContract $permissions
     */
    public function __construct(
        UserContract $users,
        RoleRepositoryContract $roles,
        PermissionRepositoryContract $permissions
    )
    {
        $this->users       = $users;
        $this->roles       = $roles;
        $this->permissions = $permissions;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('backend.access.index')
            ->withUsers($this->users->getUsersPaginated(config('access.users.default_per_page'), 1));
    }

    /**
     * @param  CreateUserRequest $request
     * @return mixed
     */
    public function create(CreateUserRequest $request)
    {
        return view('backend.access.create')
            ->withRoles($this->roles->getAllRoles('sort', 'asc', true))
            ->withPermissions($this->permissions->getAllPermissions());
    }

    /**
     * @param  StoreUserRequest $request
     * @return mixed
     */
    public function store(StoreUserRequest $request)
    {
        $email = $request->email;
        $this->users->create(
            $request->except('assignees_roles', 'permission_user'),
            $request->only('assignees_roles'),
            $request->only('permission_user')
        );
        $updat = userr::where('email',$email)->update(array('user_id' => access()->user()->id ,'locatario_id' => access()->user()->locatario_id));
        return redirect()->route('admin.access.users.index')->withFlashSuccess(trans('alerts.backend.users.created'));
    }

    /**
     * @param  $id
     * @param  EditUserRequest $request
     * @return mixed
     */
    public function edit($id, EditUserRequest $request)
    {
        $user = $this->users->findOrThrowException($id, true);
        return view('backend.access.edit')
            ->withUser($user)
            ->withUserRoles($user->roles->lists('id')->all())
            ->withRoles($this->roles->getAllRoles('sort', 'asc', true))
            ->withUserPermissions($user->permissions->lists('id')->all())
            ->withPermissions($this->permissions->getAllPermissions());
    }

    /**
     * @param  $id
     * @param  UpdateUserRequest $request
     * @return mixed
     */
    public function update($id, UpdateUserRequest $request)
    {
        $this->users->update($id,
            $request->except('assignees_roles', 'permission_user'),
            $request->only('assignees_roles'),
            $request->only('permission_user')
        );
        return redirect()->route('admin.access.users.index')->withFlashSuccess(trans('alerts.backend.users.updated'));
    }

    /**
     * @param  $id
     * @param  DeleteUserRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteUserRequest $request)
    {
        $this->users->destroy($id);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.deleted'));
    }

    /**
     * @param  $id
     * @param  PermanentlyDeleteUserRequest $request
     * @return mixed
     */
    public function delete($id, PermanentlyDeleteUserRequest $request)
    {
        $this->users->delete($id);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.deleted_permanently'));
    }

    /**
     * @param  $id
     * @param  RestoreUserRequest $request
     * @return mixed
     */
    public function restore($id, RestoreUserRequest $request)
    {
        $this->users->restore($id);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.restored'));
    }

    /**
     * @param  $id
     * @param  $status
     * @param  MarkUserRequest $request
     * @return mixed
     */
    public function mark($id, $status, MarkUserRequest $request)
    {
        $this->users->mark($id, $status);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.updated'));
    }

    /**
     * @return mixed
     */
    public function deactivated()
    {
        return view('backend.access.deactivated')
            ->withUsers($this->users->getUsersPaginated(25, 0));
    }

    /**
     * @return mixed
     */
    public function deleted()
    {
        return view('backend.access.deleted')
            ->withUsers($this->users->getDeletedUsersPaginated(25));
    }

    /**
     * @param  $id
     * @param  ChangeUserPasswordRequest $request
     * @return mixed
     */
    public function changePassword($id, ChangeUserPasswordRequest $request)
    {
        return view('backend.access.change-password')
            ->withUser($this->users->findOrThrowException($id));
    }

    /**
     * @param  $id
     * @param  UpdateUserPasswordRequest $request
     * @return mixed
     */
    public function updatePassword($id, UpdateUserPasswordRequest $request)
    {
        $this->users->updatePassword($id, $request->all());
        return redirect()->route('admin.access.users.index')->withFlashSuccess(trans('alerts.backend.users.updated_password'));
    }

    /**
     * @param  $user_id
     * @param  FrontendUserContract $user
     * @param  ResendConfirmationEmailRequest $request
     * @return mixed
     */
    public function resendConfirmationEmail($user_id, FrontendUserContract $user, ResendConfirmationEmailRequest $request)
    {
        $user->sendConfirmationEmail($user_id);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.confirmation_email'));
    }

    public function avatar(){
        $user = access()->user();
      return view('backend.modals.avatar', compact('user'));
    }

    public function avatarStore(request $request){
        $dados = $request->all();
        $user = access()->user();
        $image = $dados['icon'];
         $exts = array('jpg', 'jpeg', 'png', 'gif', 'jpe', 'jif', 'jfif', 'jfi');
            $extension = $image->getClientOriginalExtension();
            if(!in_array($extension, $exts)){
               $response['msg'] = 'Extensão Invalida';
               $response['status'] = 'error';
               return $response;
            }
        $name = $user->id.'.'.$extension;
        $path = 'public/img/avatar/';
        $request->file('icon')->move($path, $name);
        if(file_exists($path.$name)){
            $toUp = array('avatar' => $name);
            $user->update($toUp);
            if($user){
                $response['msg'] = 'Avatar Atualizado com Sucesso';
                $response['status'] = 'success';
                $response['img'] =  asset('img/avatar/'.$name);
            }
        }else{
            $response['msg'] = 'Error ao salvar avatar';
            $response['status'] = 'error';
        }
        return $response;
    }
}