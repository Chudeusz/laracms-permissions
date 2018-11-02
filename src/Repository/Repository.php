<?php

namespace Chudeusz\Permissions\Repository;

use Chudeusz\Permissions\Interfaces\RepositoryInferface;

/**
 * Class Repository
 * @package Chudeusz\Permissions\Repository
 */
class Repository implements RepositoryInferface
{
    /**
     * @var $_queryBuilder
     */
    protected $_queryBuilder;

    /**
     * Repository constructor.
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
        return $this->_queryBuilder;
    }

    /**
     *
     */
    public static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param $id
     */
    public static function getById($id)
    {
        // TODO: Implement getById() method.
    }

    /**
     * @param $id
     */
    public static function getByPostId($id)
    {

    }

    /**
     * @param $data
     */
    public static function insert($data)
    {
        // TODO: Implement insert() method.
    }

    /**
     * @param $id
     * @param $data
     */
    public static function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $id
     */
    public static function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     *
     */
    public static function count()
    {
        // TODO: Implement count() method.
    }

}