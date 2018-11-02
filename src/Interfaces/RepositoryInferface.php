<?php

namespace Chudeusz\Permissions\Interfaces;

use Illuminate\Http\Request;
use PhpParser\Builder\Class_;

interface RepositoryInferface
{
    public static function getAll();

    public static function getById($id);

    public static function insert($data);

    public static function delete($id);

    public static function count();
}