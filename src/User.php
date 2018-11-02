<?php

namespace Chudeusz\Permissions;

use Chudeusz\Permissions\Repository\UsersRepository;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Support\Facades\Cache;

/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property mixed permissions
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @mixin \Eloquent
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Like[] $likes
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isOnline()
    {
        return Cache::has('user-is-online-'.$this->id);
    }

    public static function isOnlineForId($id)
    {
        return Cache::has('user-is-online-'.$id);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function hasAccess(array $permissions)
    {
        foreach($permissions as $permission) {
            if($this->hasPermission($permission)) {
                return true;
            }
            return false;
        }
    }

    protected function hasPermission(string $permission)
    {
        $permissions = json_decode($this->permissions, true);
        return (isset($permissions[$permission])) ? $permissions[$permission] : false;
    }

    /**
     * Send the password reset notification
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    public function posts()
    {
        $this->hasMany(Post::class);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->first()->name;
    }

    /**
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->roles()->where('name',$role)->first()) {
            return true;
        }
        return false;
    }

    public static function isAdmin($id)
    {
        if (UsersRepository::getById($id)->role_name == 'Admin')
        {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return  int $id
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     *
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     * @return  string $username
     */
    public function setUsername($username)
    {
        return $this->username = $username;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return  string $name
     */
    public function setName($name)
    {
        return $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return  string $email
     */
    public function setEmail($email)
    {
        return $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return  string $password
     */
    public function setPassword($password)
    {
        return $this->password = bcrypt($password);
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param $avatar
     * @return  string $avatar
     */
    public function setAvatar($avatar = null)
    {
        if(is_null($avatar)) {
            return $this->avatar = 'assets/images/avatars/default-avatar.png';
        } else {
            return $this->avatar = $avatar;
        }
    }

    /**
     * @return null|string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * @param null|string $remember_token
     * @return string $remember_token
     */
    public function setRememberToken($remember_token)
    {
        return $this->remember_token = $remember_token;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \Carbon\Carbon|null $created_at
     * @return string $created_at
     */
    public function setCreatedAt($created_at)
    {
        return $this->created_at = $created_at;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \Carbon\Carbon|null $updated_at
     * @return string $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        return $this->updated_at = $updated_at;
    }

    /**
     * @return \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return Role[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Role[]|\Illuminate\Database\Eloquent\Collection $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param mixed $permissions
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }



}