<?php

use App\Models\Review;

require "Auth.php";
require "Models\Review.php";
use App\Core\Model;

function sendResponse($httpCode, $httpStatus, $body = "")
{
    header($_SERVER["SERVER_PROTOCOL"] . " {$httpCode} {$httpStatus}");
    echo $body;
}
try {
    switch (@$_GET['method']) {

        case 'get-reviews':
            $reviews = Review::getAll();
            echo json_encode($reviews);
            break;

        case 'post-review':
            if (!empty($_POST['review'])) {
                $review = new Review();
                $review->setSender(App\Auth::getName());
                $review->setReceiver($_POST['receiver']);

                $review->setReview($_POST['review']);
                $review->setDateof(date('d/m/Y'));
                $review->setRating($_POST['rating']);
                $review->save();
            } else {
                throw new Exception("Invalid API call", 400);
            }
            break;
    }


} catch (Exception $exception) {
    sendResponse(
        $exception->getCode(),
        $exception->getMessage(),
        json_encode([
            "error-code" => $exception->getCode(),
            "error-message" => $exception->getMessage()
        ])
    );
}
