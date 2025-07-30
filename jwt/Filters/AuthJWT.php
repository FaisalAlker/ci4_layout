<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthJWT implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var \CodeIgniter\HTTP\IncomingRequest $request */
        
        $key = getenv('JWT_SECRET');
        $response = service('response');
        $token = $request->getCookie('auth_token') ?? null;
        $header = $request->getServer("HTTP_AUTHORIZATION");
        
        if(!$token){

            if(!$header){
                $response->setJSON([
                    'status' => false,
                    'message' => 'Access Denied', 
                ]);
                return $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }
           
        }
        

        try{   
             
            // $token = explode(' ', $token);
            $decode = JWT::decode($token, new Key($key, "HS256"));
            // return $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

        }catch(Exception $e){
            $response->setJSON([
                'status' => false,
                'message' => 'Invalid Token'.$e->getMessage(), 
            ]);
            return $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
