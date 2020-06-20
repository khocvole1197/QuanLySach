<?php

namespace App\Repositories\Author;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AuthorRepository.
 *
 * @package namespace App\Repositories\Author;
 */
interface AuthorRepository extends RepositoryInterface
{
    //
    public function trash();

    public function quanLyTacGia();

    public function createTacGia($name);

    public function onlyAuthor($name);

    public function deleteTacGia($author_id);

    public function updateTacGia($name, $id);

    public function deleteAllTacGia();

    public function destroyTacGia($tacGiaId);

    public function phucHoiTacGia($tacGiaId);


}
