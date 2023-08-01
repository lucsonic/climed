<?php

namespace App\Repositories;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
abstract class BaseRepository
{
    const LOWER = 'LOWER';
    const LIKE = 'LIKE';
    const FOREIGN_KEY  = 'foreign_key';
    const LOCAL_KEY = 'local_key';
    const OWNER_KEY = 'owner_key';
    const COUNT_AS_QTD = 'count(*) as qtd';
    const QTD = 'qtd';
    const COUNT = 'count';
    const AS_TOTAL = 'as total';
}
