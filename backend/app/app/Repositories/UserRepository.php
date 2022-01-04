<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Traits\UpdateTraitRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * @property User $model
 */
class UserRepository extends BaseRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    use UpdateTraitRepository;

    /**
     * @param \Illuminate\Http\UploadedFile $avatarFile
     * @return string
     */
    public function setAvatar($avatarFile)
    {
        $path = $this->createAvatarFile($avatarFile);

        $user = $this->find(Auth::user()->id);

        $this->removeOldAvatar($user);

        $user->avatar = $path;
        $user->save();

        return asset($path);
    }

    /**
     * @param User $user
     */
    private function removeOldAvatar($user)
    {
        if (empty($user->avatar)) {
            return;
        }
        Storage::delete($user->avatar);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $avatarFile
     * @return string
     */
    private function createAvatarFile($avatarFile)
    {
        return Storage::putFile('avatar', $avatarFile);
    }
}
