<?php

namespace Chudeusz\Permissions;

use Illuminate\Database\Eloquent\Model;


/**
 * App\UserRole
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUserId($value)
 * @mixin \Eloquent
 */
class UserRole extends Model
{
    protected $table = 'user_role';
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param int $role_id
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
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
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
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
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }


    public static function getAll()
    {
        return (new static())
            ->select(['r.id as role_id', 'r.name as role_name', 'u.*'])
            ->join('roles as r', 'r.id', '=','user_role.role_id')
            ->join('users as u', 'u.id', '=','user_role.user_id')
            ->newQuery()
            ->get();
    }

    public static function getById(User $user)
    {
        return (new static())
            ->select(['r.id as role_id', 'r.name as role_name', 'u.*'])
            ->join('roles as r', 'r.id', '=','user_role.role_id')
            ->join('users as u', 'u.id', '=','user_role.user_id')
            ->where(['user_role.user_id' => ':userId'])
            ->setBindings([$userId = $user->getId()])
            ->newQuery()
            ->get();
    }

    public static function getRoleName(User $user)
    {
        return (new static())
            ->select(['r.name as role_name'])
            ->join('roles as r', 'r.id', '=','user_role.role_id')
            ->join('users as u', 'u.id', '=','user_role.user_id')
            ->where(['user_role.user_id' => ':userId'])
            ->setBindings([$userId = $user->getId()])
            ->newQuery()
            ->get();
    }

}
