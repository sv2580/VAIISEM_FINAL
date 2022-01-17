<?php

namespace App\Controllers;

use App\Auth;
use App\Core\AControllerBase;
use App\Models\Login;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Review;
use http\Client\Curl\User;


/**
 * Class HomeController
 * Example of simple controller
 * @package App\Controllers
 */
class HomeController extends AControllerRedirect
{

    public function index()
    {
        $offers = Offer::getAll();
        $logins = login::getAll();
        $reviews = Review::getAll();

        return $this->html(
            [
                'offers' => $offers,
                'logins' => $logins,
                'reviews' => $reviews
            ]);
    }




    public function categoryTutor()
    {
        $offers = Offer::getAll();
        $logins = Login::getAll();


        return $this->html(
            [
                'offers' => $offers,
                'logins' => $logins

            ]);
    }

    public function categoryTutoree()
    {
        $offers = Offer::getAll();
        $logins = Login::getAll();

        return $this->html(
            [
                'offers' => $offers,
                'logins' => $logins

            ]);
    }

    public function about()
    {
        return $this->html(
            []
        );
    }

}