<?php

namespace App\Repositories\Book;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BookRepository.
 *
 * @package namespace App\Repositories\Book;
 */
interface BookRepository extends RepositoryInterface
{
    //
    public function createSach($name, $namebook);

    public function getBook();

    public function quanLySach();

    public function dangMuonSach();

    public function dangXemSach();

    public function updateSach($id, $name, $authors);

    public function deleteSach($sach_id);

    public function destroySach($sach_id);

    public function deleteAllSach();

    public function phucHoiSach($sachId);

    public function findByID($id);

    public function trash();
}
