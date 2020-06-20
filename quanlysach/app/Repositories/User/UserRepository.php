<?php

namespace App\Repositories\User;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories\User;
 */
interface UserRepository extends RepositoryInterface
{
    //
    public function getData();

    public function kiemTraMuon();

    public function muonSach($idSach);

    public function khachMuonSach($idb, $dayfrom, $dayto);

    public function traSach();

    public function khachTra($id);

    public function xemChiTiet($id);

    public function CheckTime();

    public function getUser();

    public function deleteUser($user_id);
}
