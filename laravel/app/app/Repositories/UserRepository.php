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
    use UpdateTraitRepository;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function update(User $model, array $data): User
    {
        $model->fill($data);
        $model->name = isset($data['name']) ? trim($data['name']) : $model->name;
        $model->email = isset($data['email']) ? trim($data['email']) : $model->email;
        $model->save();
        return $model;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $avatarFile
     * @return string
     */
    public function setAvatar($avatarFile): string
    {
        $path = $this->createAvatarFile($avatarFile);

        $user = $this->find(Auth::user()->id);

        self::removeOldAvatar($user);

        $user->avatar = $path;
        $user->save();

        return asset($path);
    }

    public static function removeOldAvatar(User $user): void
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
    private function createAvatarFile($avatarFile): string
    {
        return Storage::putFile('avatar', $avatarFile);
    }
}
