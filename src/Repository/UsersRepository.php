<?php

namespace Chudeusz\Permissions\Repository;

use Chudeusz\Permissions\Repository\Repository;
use Chudeusz\Permissions\Interfaces\RepositoryInferface;
use Chudeusz\Permissions\User;

/**
 * Class UserRepository
 * @package Chudeusz\Permissions\UsersRepository
 */
class UsersRepository extends Repository implements RepositoryInferface
{

    /**
     * @var $_queryBuilder
     */
    protected $_queryBuilder;

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQueryBuilder()
    {
        return $this -> _queryBuilder = User::getQuery();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getAll()
    {
        return (new static())
            -> getQueryBuilder()
            -> select([
                'u.id as user_id',
                'u.name as user_name',
                'u.username as user_username',
                'r.id as role_id',
                'r.name as role_name',
                'u.avatar as user_avatar'
            ])
            -> from('users as u')
            -> join('user_role as ur', 'u.id', '=','ur.user_id')
            -> join('roles as r', 'r.id', '=','ur.role_id')
            -> get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
     */
    public static function getById($id)
    {
        return (new static())
            -> getQueryBuilder()
            -> select([
                'u.id as user_id',
                'u.name as user_name',
                'u.username as user_username',
                'u.avatar as user_avatar',
                'r.id as role_id',
                'r.name as role_name',
                'u.permissions as user_permissions'
            ])
            -> where('u.id', '=', $id)
            -> from('users as u')
            -> join('user_role as ur', 'u.id', '=','ur.user_id')
            -> join('roles as r', 'r.id', '=','ur.role_id')
            -> first();
    }

    public static function getAllForMessenger($userId)
    {
        return (new static())
            -> getQueryBuilder()
            -> distinct()
            -> select([
                'u.id as user_id',
                'u.name as user_name',
                'u.username as user_username',
                'r.id as role_id',
                'r.name as role_name',
                'u.avatar as user_avatar'
            ])
            -> from('users as u')
            -> where('u.id', '!=', $userId)
            -> join('user_role as ur', 'u.id', '=','ur.user_id')
            -> join('roles as r', 'r.id', '=','ur.role_id')
            -> leftJoin('messengers as m', 'm.from', '=', 'u.id')
            -> orderBy('m.content', 'desc')
            -> get();
    }

    public static function getLastMessageForUser($userId)
    {
//        return (new static())
//            -> getQueryBuilder()
//            -> select(['m.content as last_message'])
//            -> from('messengers as m')
//            -> where('')
//            ;
    }

    /**
     * @return int
     */
    public static function count(){
        return (new static())
            -> getQueryBuilder()
            ->select()
            -> from('users as u')
            -> count();
    }

    /**
     * @param $where
     * @param array $data
     * @return int
     */
    public static function update($where, $data = [])
    {
        return (new static())
            -> getQueryBuilder()
            -> where(['id' => $where])
            -> update($data);
    }

    /**
     * @param $id
     */
    public static function delete($id)
    {
        // TODO: Implement delete() method
    }

    /**
     * @param $data
     */
    public static function insert($data)
    {
        // TODO: Implement insert() method.
    }


}