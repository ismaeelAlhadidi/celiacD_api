<?php 

require_once __DIR__ . '/../vendor/autoload.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

define('IMAGE_MAX_SIZE_IN_BYTES', 65535);

function auth() {

    static $auth = null;

    if($auth == null) $auth = new App\Authentecation\Auth();

    return $auth;
}

function request() {

    static $request = null;

    if($request == null) $request = new App\Config\Request();

    return $request;
}

class BadPracticeResponse extends App\Config\Response {

    public static function toJson(array $data, $status, $msg, $code = 200, $only_data = false) {

        http_response_code($code);

        if($only_data) {

            echo json_encode($data);
            exit;
        }

        $response = [
            'error' => ! $status,
            'message' => $msg
        ];

        echo json_encode (
            array_merge($response, $data)
        );

        exit;
    }

    public static function toJsonWithSanitizeQuestions(array $questions, $status, $msg, $code = 200, $only_data = false) {

        $response_data = [];

        foreach($questions as $question) {

            $user = $question->user;
            if( ! $user ) continue;

            array_push($response_data, static::sanitizeQuestion($question, $user));
        }

        http_response_code($code);

        if($only_data) {

            echo json_encode($response_data);
            exit;
        }

        $response = [
            'error' => ! $status,
            'message' => $msg
        ];

        echo json_encode (
            array_merge($response, $response_data)
        );

        exit;
    }

    public static function sanitizeQuestion(App\Models\Question $question, App\Models\User $user) {

        $sanitize_data = [];

        $sanitize_data['qId'] = $question->QuestionsID;
        $sanitize_data['time'] = App\Helpers\TimeTransformer::beforeHowMuch($question->Time);
        $sanitize_data['content'] = $question->Content;

        $sanitize_data['userImage'] = $user->ProfilePic;
        $sanitize_data['FName'] = $user->FName;
        $sanitize_data['LName'] = $user->LName;


        $answers = $question->answers;
        $sanitize_data['countOfAnswers'] = ( ! is_array($answers) ? 0 : count( $answers ) );

        $favourites = $question->favourites;
        $sanitize_data['countOfFavourite'] = ( ! is_array($favourites) ? 0 : count( $favourites ) );

        $favourite = App\Models\Favourite::where('QuestionsID', $question->QuestionsID)->where('UserId', auth()->id())->first();

        $sanitize_data['addedTOFavourite'] = ( $favourite != false );

        return $sanitize_data;
    }

    public static function sanitizeAnswer(App\Models\Answer $answer) {

        $response_data = [];

        $response_data['commentId'] = $answer->AnswerId;

        $response_data['time'] = App\Helpers\TimeTransformer::beforeHowMuch($answer->Time);

        $response_data['qId'] = $answer->QuestionsID;

        $response_data['content'] = $answer->Content;

        $user = $answer->user;

        if($user) {

            $response_data['userImage'] = $user->ProfilePic;
            $response_data['FName'] = $user->FName;
            $response_data['LName'] = $user->LName;
        }

        return $response_data;
    }
}


new App\Middlewares\CheckApiSecretKey();