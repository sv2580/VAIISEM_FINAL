<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\Login;
use App\Models\Offer;
use App\Core\AControllerBase;
use App\Models\Review;

class OfferController extends AControllerRedirect
{


    public function index()
    {

    }

    public function myoffers()
    {
        $offers = Offer::getAll();
        $reviews = Review::getAll();

        return $this->html(
            [
                'reviews' => $reviews,
                'offers' => $offers,
                'error' => $this->request()->getValue('error'),
                'note' => $this->request()->getValue('note')
            ]);
    }

    public function offerForm()
    {
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    public function singleOffer()
    {
        $offers = Offer::getAll();
        $logins = Login::getAll();
        $reviews = Review::getAll();
        $parid = $this->request()->getValue('parid') * 1;
        return $this->html(
            [
                'offers' => $offers,
                'logins' => $logins,
                'reviews' => $reviews,
                'parid' => $parid,
                'error' => $this->request()->getValue('error'),
                'note' => $this->request()->getValue('note')
            ]);
    }


    public function editForm()
    {
        $offers = Offer::getAll();
        return $this->html(
            [
                'offers' => $offers,
                'postid' => $this->request()->getValue('postid') * 1,
                'error' => $this->request()->getValue('error')

            ]);
    }

    public function editOffer()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }

        $offers = Offer::getAll();
        $logins = Login::getAll();
        foreach ($offers as $offer) {
            if ($offer->getId() == $this->request()->getValue('parid') * 1) {
                foreach ($offers as $o) {
                    if ($o->getTitle() == $this->request()->getValue('title')
                        && $o->getLoginfk() == Auth::getName() &&
                        $o->getId() != $this->request()->getValue('parid')) {
                        $parid = $this->request()->getValue('parid');
                        $this->redirect('offer', 'myoffers', ['error' => 'Inzerát s rovnakým názvom ste už zverejnili!']);
                        return;
                    }
                }
                if (strlen($this->request()->getValue('title')) == 0 || strlen($this->request()->getValue('title')) > 100) {
                    $this->redirect('offer', 'myoffers', ['error' => 'Názov inzerátu musí byť zadaný a menší ako 100 znakov.']);
                    return;
                }
                $offer->setTitle($this->request()->getValue('title'));

                if (strlen($this->request()->getValue('info')) == 0 || strlen($this->request()->getValue('info')) > 255) {
                    $this->redirect('offer', 'myoffers', ['error' => 'Základné informácie musia byť zadané a menšie ako 255 znakov.']);
                    return;
                }
                $offer->setInfo($this->request()->getValue('info'));

                if (strlen($this->request()->getValue('place')) == 0 || strlen($this->request()->getValue('place')) > 50) {
                    $this->redirect('offer', 'myoffers', ['error' => 'Miesto musí byť zadané a menšie ako 50 znakov.']);
                    return;
                }
                $offer->setPlace($this->request()->getValue('place'));


                if (!filter_var(($this->request()->getValue('contact')), FILTER_VALIDATE_EMAIL) || strlen(($this->request()->getValue('contact'))) < 5 || strlen($this->request()->getValue('contact')) > 50) {
                    $this->redirect('auth', 'registerForm', ['error' => 'E-mail nie je platný']);
                    return;
                }
                foreach ($logins as $l) {
                    if (Login::getAll('email=?', [$this->request()->getValue('contact')]) && $offer->getContact() != Auth::getName()) {
                        $this->redirect('offer', 'myoffers', ['error' => 'Mail, ktorý ste uviedli pre kontakt používa iný užívateľ ako login!']);
                        return;
                    }
                }
                $offer->setContact($this->request()->getValue('contact'));

                if (strlen($this->request()->getValue('moreinfo')) == 0) {
                    $this->redirect('offer', 'myoffers', ['error' => 'Informácie musia byť zadané.']);
                    return;
                }
                $offer->setMoreinfo($this->request()->getValue('moreinfo'));

                if (strlen($this->request()->getValue('education')) == 0 || strlen($this->request()->getValue('education')) > 255) {
                    $this->redirect('offer', 'myoffers', ['error' => 'Vzdelanie musí byť zadané a menšie ako 255 znakov.']);
                    return;
                }
                $offer->setEducation($this->request()->getValue('education'));

                if (strlen($this->request()->getValue('courses')) > 100) {
                    $this->redirect('offer', 'myoffers', ['error' => 'Kurzy musia mať menej ako 100 znakov.']);
                    return;
                }
                $offer->setCourses($this->request()->getValue('courses'));

                if (strlen($this->request()->getValue('pay')) == 0 || strlen($this->request()->getValue('pay')) > 100) {
                    $this->redirect('offer', 'myoffers', ['error' => 'Popis platu musí byť zadaný a menší ako 100 znakov.']);
                    return;
                }
                $offer->setPay($this->request()->getValue('pay'));
                $offer->save();

            }
        }

        $this->redirect('offer', 'myoffers');

    }

    public function shareOffer()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
            $offers = Offer::getAll();
            $logins = Login::getAll();
            $newOffer = new Offer();
            if ($this->request()->getValue('type') == "one") {
                $newOffer->setTutor(1);
                $title = "Doučím: " . $this->request()->getValue('title');
                $newOffer->setTitle($title);
            } else {
                $newOffer->setTutor(0);
                $title = "Hľadám doučenie: " . $this->request()->getValue('title');
                $newOffer->setTitle($title);
            }
            if (strlen($this->request()->getValue('title')) == 0 || strlen($this->request()->getValue('title')) > 100) {
                $this->redirect('offer', 'offerForm', ['error' => 'Názov inzerátu musí byť zadaný a menší ako 100 znakov.']);
                return;
            }
            foreach ($offers as $o) {
                if ($o->getTitle() == $title && $o->getLoginfk() == Auth::getName()) {
                    $this->redirect('offer', 'offerForm', ['error' => 'Inzerát s rovnakým názvom ste už zverejnili!']);
                    return;
                }
            }

            if (strlen($this->request()->getValue('info')) == 0 || strlen($this->request()->getValue('info')) > 255) {
                $this->redirect('offer', 'myoffers', ['error' => 'Základné informácie musia byť zadané a menšie ako 255 znakov.']);
                return;
            }
            $newOffer->setInfo($this->request()->getValue('info'));


            if (strlen($this->request()->getValue('place')) == 0 || strlen($this->request()->getValue('place')) > 50) {
                $this->redirect('offer', 'myoffers', ['error' => 'Miesto musí byť zadané a menšie ako 50 znakov.']);
                return;
            }
            $newOffer->setPlace($this->request()->getValue('place'));

            if (!filter_var(($this->request()->getValue('contact')), FILTER_VALIDATE_EMAIL) || strlen(($this->request()->getValue('contact'))) < 5 || strlen($this->request()->getValue('contact')) > 50) {
                $this->redirect('auth', 'registerForm', ['error' => 'E-mail nie je platný']);
                return;
            }
            $newOffer->setContact($this->request()->getValue('contact'));

            foreach ($logins as $l) {
                if ($l->getEmail() == $newOffer->getContact() && $newOffer->getContact() != Auth::getName()) {
                    $this->redirect('offer', 'offerForm', ['error' => 'Mail, ktorý ste uviedli pre kontakt používa iný užívateľ ako login!']);
                    return;
                }
            }

            if (strlen($this->request()->getValue('moreinfo')) == 0) {
                $this->redirect('offer', 'myoffers', ['error' => 'Informácie musia byť zadané.']);
                return;
            }
            $newOffer->setMoreinfo($this->request()->getValue('moreinfo'));


            if (strlen($this->request()->getValue('education')) == 0 || strlen($this->request()->getValue('education')) > 255) {
                $this->redirect('offer', 'myoffers', ['error' => 'Vzdelanie musí byť zadané a menšie ako 255 znakov.']);
                return;
            }
            $newOffer->setEducation($this->request()->getValue('education'));

            if (strlen($this->request()->getValue('courses')) > 100) {
                $this->redirect('offer', 'myoffers', ['error' => 'Kurzy musia mať menej ako 100 znakov.']);
                return;
            }
            $newOffer->setCourses($this->request()->getValue('courses'));

            if (strlen($this->request()->getValue('pay')) == 0 || strlen($this->request()->getValue('pay')) > 100) {
                $this->redirect('offer', 'myoffers', ['error' => 'Popis platu musí byť zadaný a menší ako 100 znakov.']);
                return;
            }
            $newOffer->setPay($this->request()->getValue('pay'));


            $newOffer->setLoginfk($_SESSION["name"]);
            $newOffer->save();
            $this->redirect('offer', 'myoffers');

    }

    public function deleteOffer()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $parid = $this->request()->getValue('postid') * 1;
        $offers = Offer::getAll();
        foreach ($offers as $o) {
            if ($parid == $o->getId()) {
                $o->delete();
            }
        }
        $this->redirect('offer', 'myoffers');
    }
}