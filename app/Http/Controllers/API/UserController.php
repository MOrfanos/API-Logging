<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\User;

use Exception;

class UserController extends APIBaseController
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        try {
            $user = User::find($id);
            $this->apiValidator($request, $user);

            $logResponse = [
                "user_id" => $id,
                "request" => json_encode($request),
                "response"=> $user->toJson(),
                'url' => $request->getUri(),
            ];

            $this->_log->create($logResponse)->save();

            return $this->sendResponse($request, $user->toArray(), 'user retrieved successfully.');
        } catch(Exception $e) {

            $logResponse = [
                "user_id" => $id,
                "request" => json_encode($request),
                "response"=> $e->getMessage(),
                'url' => $request->getUri(),
            ];

            $this->_log->create($logResponse)->save();

            return $this->sendError($request, $e->getMessage());
        }
    }

}