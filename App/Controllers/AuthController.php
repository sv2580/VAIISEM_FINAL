<?php

namespace App\Controllers;

use App\Auth;
use App\Config\Configuration;
use App\Core\Responses\Response;
use App\Models\Login;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Review;

class AuthController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function loginForm()
    {
        return $this->html([
                'error' => $this->request()->getValue('error'),
                'note' => $this->request()->getValue('note')
            ]
        );
    }

    public function registerForm()
    {
        return $this->html([
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    public function login()
    {

        $login = $this->request()->getValue('login');
        if (!filter_var($login, FILTER_VALIDATE_EMAIL) || strlen($login) < 5 || strlen($login) > 50) {
            $this->redirect('auth', 'loginForm', ['error' => 'E-mail nie je platný']);
            return;
        }
        $passw = $this->request()->getValue('password');
        if (strtolower($passw) == $passw || strtoupper($passw) == $passw || strlen($passw) < 8 || strlen($passw) > 30 || !preg_match('~[0-9]+~', $passw)) {
            $this->redirect('auth', 'loginForm', ['error' => 'Heslo musí obsahovať čísla, veľké a malé písmená.']);
            return;
        }
        $logged = Auth::login($login, $passw);

        if ($logged) {
            $this->redirect('home');
        } else {
            $this->redirect('auth', 'loginForm', ['error' => 'Zlé meno alebo heslo!']);
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('home');
    }

    public function register()
    {
        $email = $this->request()->getValue('email');
        $login = Login::getAll();
        $user = Login::getAll('email=?',[$email]);
        if($user == true){
            $this->redirect('auth', 'registerForm', ['error' => 'Email už je v systéme!']);
        }

        if (isset($_FILES['file'])) {
            if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
                $name = date('Y-m-d-H-i-s_') . $_FILES['file']['name'];
                if(substr(strlen($name),-4) != 'jpeg' || substr(strlen($name),-3) != 'png')
                {
                    $this->redirect('auth', 'registerForm', ['error' => 'Podporované sú iba png a jpeg súbory.']);
                    return;
                }
                move_uploaded_file($_FILES['file']['tmp_name'], Configuration::UPLOAD_DIR . "$name");
            }
        }

        $newLogin = new Login();
        $newLogin->setProfilepic($name);
        $email = $this->request()->getValue('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) < 5 || strlen($email) > 50) {
            $this->redirect('auth', 'registerForm', ['error' => 'E-mail nie je platný']);
            return;
        }

        $newLogin->setEmail($email);
        $passw = $this->request()->getValue('password');
        if (strtolower($passw) == $passw || strtoupper($passw) == $passw || strlen($passw) < 8 || strlen($passw) > 30 || !preg_match('~[0-9]+~', $passw)) {
            $this->redirect('auth', 'registerForm', ['error' => 'Heslo musí obsahovať čísla, veľké a malé písmená.']);
            return;
        }

        $hash = password_hash($passw, PASSWORD_DEFAULT);

        $newLogin->setPassword($hash);
        if (strlen($this->request()->getValue('name')) < 1 || strlen($this->request()->getValue('name')) > 100 || !ctype_alpha($this->request()->getValue('name'))) {
            $this->redirect('auth', 'registerForm', ['error' => 'Meno musí byť zadané, kratšie ako 100 znakov a obsahovať iba písmená!']);
            return;
        }
        $newLogin->setName($this->request()->getValue('name'));

        if (strlen($this->request()->getValue('surname')) < 1 || strlen($this->request()->getValue('surname')) > 100 || !ctype_alpha($this->request()->getValue('surname'))) {
            $this->redirect('auth', 'registerForm', ['error' => 'Priezvisko musí byť zadané, kratšie ako 100 znakov a obsahovať iba písmená!']);
            return;
        }
        $newLogin->setSurname($this->request()->getValue('surname'));

        if ($this->request()->getValue('birthyear') * 1 > 2009 || $this->request()->getValue('birthyear') * 1 < 1910) {
            $this->redirect('auth', 'registerForm', ['error' => 'Neplatný rok narodenia']);
            return;
        }
        $newLogin->setBirthyear($this->request()->getValue('birthyear') * 1);
        $newLogin->save();
        $this->redirect('auth', 'loginForm', ['note' => 'Teraz sa môžete prihlásiť.']);


    }

    public function editProfile()
    {
        $logins = Login::getAll();

        return $this->html(
            [
                'logins' => $logins,
                'error' => $this->request()->getValue('error'),
                'note' => $this->request()->getValue('note')
            ]);
    }

    public function changePassword()
    {

        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $login = Login::getAll();
        $passw = $this->request()->getValue('oldpassword');
        if (strtolower($passw) == $passw || strtoupper($passw) == $passw || strlen($passw) < 8 || strlen($passw) > 30 || !preg_match('~[0-9]+~', $passw)) {
            $this->redirect('auth', 'editProfile', ['error' => 'Heslo musí obsahovať čísla, veľké a malé písmená.']);
            return;
        }

        foreach ($login as $l) {
            if ($_SESSION["name"] == $l->getEmail()) {
                if (password_verify($this->request()->getValue('oldpassword'), $l->getPassword())) {
                    $passw = $this->request()->getValue('newpassword');
                    if (strtolower($passw) == $passw || strtoupper($passw) == $passw || strlen($passw) < 8 || strlen($passw) > 30 || !preg_match('~[0-9]+~', $passw)) {
                        $this->redirect('auth', 'editProfile', ['error' => 'Heslo musí obsahovať čísla, veľké a malé písmená a mať od 8 do 30 znakov.']);
                        return;
                    }
                    $hash = password_hash($this->request()->getValue('newpassword'), PASSWORD_DEFAULT);

                    $l->setPassword($hash);
                    $l->save();
                } else {
                    $this->redirect('auth', 'editProfile', ['error' => 'Zlé heslo!']);
                }
            }
        }
        $this->redirect('auth', 'editProfile', ['note' => 'Heslo bolo zmenené.']);

    }

    public function deleteProfile()
    {

        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $login = Login::getAll();
        foreach ($login as $l) {
            if ($_SESSION["name"] == $l->getEmail()) {
                if (password_verify($this->request()->getValue('password'), $l->getPassword())) {
                    $offers = Offer::getAll();
                    $messages = Message::getAll();
                    $reviews = Review::getAll();
                    foreach ($offers as $o) {
                        if ($o->getLoginfk() == $_SESSION["name"]) {
                            $o->delete();
                        }
                    }
                    foreach ($messages as $m) {
                        if ($m->getReceiver() == $_SESSION["name"] || $m->getSender() == $_SESSION["name"]) {
                            $m->delete();
                        }
                    }
                    foreach ($reviews as $r) {
                        if ($r->getReceiver() == $_SESSION["name"] || $r->getSender() == $_SESSION["name"]) {
                            $r->delete();
                        }
                    }
                    $l->delete();
                    Auth::logout();

                } else {
                    $this->redirect('home', 'editProfile', ['error' => 'Zlé heslo!']);
                }
            }
        }
        $this->redirect('home');
    }

    public function deleteUser()
    {
        if (!Auth::isLogged() && !Auth::isAdmin()) {
            $this->redirect('home');
        }
        $login = Login::getAll();
        foreach ($login as $l) {
            if ($this->request()->getValue('userId')*1== $l->getId()) {
                $offers = Offer::getAll();
                $messages = Message::getAll();
                $reviews = Review::getAll();
                foreach ($offers as $o) {
                    if ($o->getLoginfk() == $l->email) {
                        $o->delete();
                    }
                }
                foreach ($messages as $m) {
                    if ($m->getReceiver() == $l->email || $m->getSender() == $l->email) {
                        $m->delete();
                    }
                }
                foreach ($reviews as $r) {
                    if ($r->getReceiver() == $l->email || $r->getSender() == $l->email) {
                        $r->delete();
                    }
                }
                $l->delete();
            }

        }
    }

    public function myMessages()
    {
        $message = Message::getAll();
        return $this->html([
                'message' => $message,
                'note' => $this->request()->getValue('note')
            ]
        );
    }

    public function sendMessage()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $newMessage = new Message();
        $newMessage->setSender($this->request()->getValue('sender'));
        $newMessage->setReceiver($this->request()->getValue('receiver'));
        if (strlen($this->request()->getValue('message')) == 0 || strlen($this->request()->getValue('message')) > 500) {
            $this->redirect('offer', 'singleOffer', ['parid' => $this->request()->getValue('parid'), 'error' => 'Nezadali ste žiadnu správu, alebo správu dlhšiu ako 500 znakov.']);
            return;
        }
        $newMessage->setMessage($this->request()->getValue('message'));
        $newMessage->setDateOfMessage(date('d/m/Y'));
        $newMessage->save();
        $this->redirect('auth', 'myMessages', ['note' => 'Správa bola užívatelovi odoslaná.']);
    }

    public function deleteMessage()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $messages = Message::getAll();
        foreach ($messages as $m) {
            if ($m->getId() == $this->request()->getValue('parid') * 1) {
                $m->delete();
            }
        }
        $this->redirect('auth', 'myMessages', ['note' => 'Správa bola vymazaná.']);
    }

    public function deleteReview()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $reviews = Review::getAll();
        $id = $this->request()->getValue('rewid') * 1;
        foreach ($reviews as $r) {
            if ($r->getId() == $id) {
                $r->delete();
            }
        }

    }


    public function reportReview()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $reviews = Review::getAll();
        foreach ($reviews as $r) {
            if ($r->getId() == $this->request()->getValue('rewid') * 1) {
                $r->setReported(1);
                $r->save();
            }
        }
        $this->redirect('offer', 'myoffers', ['note' => 'Táto recenzia bola nahlásená administrátorovi. V krátkosti ju preveríme.']);
    }


    public function reportOffer()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $offers = Offer::getAll();
        foreach ($offers as $o) {
            if ($o->getId() == $this->request()->getValue('parid') * 1) {
                $o->setReported(1);
                $o->save();
            }
        }
        $parid = $this->request()->getValue('parid');
        $this->redirect('offer', 'singleOffer', ['parid' => $parid, 'note' => 'Inzerát bol nahlásený.']);
    }


    public function reports()
    {
        $reviews = Review::getAll();
        $logins = Login::getAll();
        $offers = Offer::getAll();
        return $this->html(
            [
                'reviews' => $reviews,
                'logins' => $logins,
                'note' => $this->request()->getValue('note'),
                'offers' => $offers
            ]);
    }

    public function logins()
    {
        $logins = Login::getAll();

        return $this->html(
            [
                'logins' => $logins,
                'note' => $this->request()->getValue('note'),
            ]);
    }


    public function deleteReportedReview()
    {
        if (!Auth::isAdmin()) {
            $this->redirect('home');
        }
        $reviews = Review::getAll();
        $logins = Login::getAll();
        $id = $this->request()->getValue('rewid') * 1;
        foreach ($reviews as $r) {
            if ($r->getId() == $id) {
                $receiver = $r->getReceiver();
                $sender = $r->getSender();
                $messRec = new Message();
                $messRec->setSender('ADMIN');
                $messRec->setReceiver($receiver);
                $messRec->setMessage('Vami nahlásená recenzia od použíateľa ' . $receiver . ' bola zmazaná. Tutorly Vám ďakuje za spoluprácu.');
                $messRec->setDateOfMessage(date('d/m/Y'));
                $messRec->save();
                $messSend = new Message();
                $messSend->setSender('ADMIN');
                $messSend->setReceiver($sender);
                $messSend->setMessage('Vami napísaná recenzia pre použíateľa ' . $sender . ' bola zmazaná. Po opätovnom porušení pravidiel bude Váš účet zablokovaný.');
                $messSend->setDateOfMessage(date('d/m/Y'));
                $messSend->save();
                foreach ($logins as $l) {
                    if ($sender == $l->email) {
                        $l->setReports(($l->getReports()) + 1);
                        $l->save();
                    }
                }
                $r->delete();
            }
        }

        $this->redirect('auth', 'reports', ['note' => 'Recenzia bola zmazaná a užívatelia oboznámení.']);

    }

    public function deleteReportedOffer()
    {
        if (!Auth::isAdmin()) {
            $this->redirect('home');
        }
        $offers = Offer::getAll();
        $logins = Login::getAll();

        $id = $this->request()->getValue('parid') * 1;
        foreach ($offers as $o) {
            if ($o->getId() == $id) {
                $receiver = $o->getLoginfk();
                $messRec = new Message();
                $messRec->setSender('ADMIN');
                $messRec->setReceiver($receiver);
                $messRec->setMessage('Váš inzerát ' . $o->getTitle() . ' bol nahlásený a zmazaný. Pri ďalšom porušení pravidiel môže byť Váš účet zmazaný!');
                $messRec->setDateOfMessage(date('d/m/Y'));
                $messRec->save();
                foreach ($logins as $l) {
                    if ($receiver == $l->email) {
                        $l->setReports(($l->getReports()) + 1);
                        $l->save();
                    }
                }
                $o->delete();
            }
        }

        $this->redirect('auth', 'reports', ['note' => 'Inzerát bol zmazaný a užívateľ oboznámený.']);

    }

    public function ignoreReportedReview()
    {
        if (!Auth::isAdmin()) {
            $this->redirect('home');
        }
        $reviews = Review::getAll();
        $id = $this->request()->getValue('rewid') * 1;
        foreach ($reviews as $r) {
            if ($r->getId() == $id) {
                $r->setReported(0);
                $r->save();
                $receiver = $r->getReceiver();
                $sender = $r->getSender();
                $messRec = new Message();
                $messRec->setSender('ADMIN');
                $messRec->setReceiver($receiver);
                $messRec->setMessage('Vami nahlásená recenzia od použíateľa ' . $receiver . ' nebola zmazaná, pretože neporušuje naše pravidlá. Pokiaľ máte viac otázok alebo dôkazov kontaktujte nás.');
                $messRec->setDateOfMessage(date('d/m/Y'));
                $messRec->save();
                $messSend = new Message();
                $messSend->setSender('ADMIN');
                $messSend->setReceiver($sender);
                $messSend->setMessage('Vami napísaná recenzia pre použíateľa ' . $sender . ' bola nahlásená, ale neporušuje pravidlá. Pre viac informácií nás kontaktujte.');
                $messSend->setDateOfMessage(date('d/m/Y'));
                $messSend->save();
            }
        }

        $this->redirect('auth', 'reports', ['note' => 'Nahlásenie bolo ignorované a užívatelia oboznámení.']);

    }

    public function ignoreReportedOffer()
    {
        if (!Auth::isAdmin()) {
            $this->redirect('home');
        }
        $offers = Offer::getAll();
        $id = $this->request()->getValue('parid') * 1;
        foreach ($offers as $o) {
            if ($o->getId() == $id) {
                $receiver = $o->getLoginfk();
                $messRec = new Message();
                $messRec->setSender('ADMIN');
                $messRec->setReceiver($receiver);
                $messRec->setMessage('Váš inzerát ' . $o->getTitle() . ' bol nahlásený ale neporušuje žiadne pravidlá.');
                $messRec->setDateOfMessage(date('d/m/Y'));
                $messRec->save();
                $o->setReported(0);
                $o->save();
            }
        }

        $this->redirect('auth', 'reports', ['note' => 'Nahlásenie bolo ignorované a užívateľ oboznámený.']);

    }

    public function getUsers()
    {
        $users = Login::getAll();
        return $this->json($users);
    }

    public function getReviews()
    {
        $reviews = Review::getAll();
        return $this->json($reviews);
    }

    public function addReview()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $review = new Review();
        $review->setSender(Auth::getName());

        $review->setReceiver($this->request()->getValue('receiver'));

        if (strlen($this->request()->getValue('text')) == 0 || strlen($this->request()->getValue('text')) > 500) {
            return $this->json("error");
        }

        if (strlen($this->request()->getValue('rating')) == null) {
            return $this->json("error");
        }
        $review->setReview($this->request()->getValue('text'));
        $review->setDateof(date('d/m/Y'));
        $review->setRating($this->request()->getValue('rating'));
        $review->save();
        return $this->json("ok");
    }


}