<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\Log;
use App\User;
use Exception;

class APIBaseController extends Controller
{

    protected $_log;

    public function __construct()
    {
        $this->_log = new Log();
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    protected function apiValidator(Request $request, $object)
    {

        if (is_null($object)) {
            throw new Exception('null user');
        }

        if ($object instanceof User) {
            switch ($this->apiKeyValidator($request, $object)) {
                case 'wrong':
                    throw new Exception('wrong api key');
                    break;
                case 'empty':
                    throw new Exception('empty api key');
                    break;
            }
        }

        return ;
    }

    private function apiKeyValidator(Request $request, $object) {

        if (!$request->cookie('cookie_key') && !$request->header('Api-Key')) {
            return 'empty';
        }

        if ($request->cookie('cookie_key') != $object->api_key && $request->header('Api-Key') != $object->api_key ) {
            return 'wrong';
        }

        return false;
    }

}