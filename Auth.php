<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Example: Check session or any auth mechanism
        if (!session()->get('isLoggedIn')) {
            return redirect()->route('login'); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
        // The after() method in a CodeIgniter 4 filter is optional and is usually 
        // used when you need to modify the response after the controller runs, or log or track actions. 
        // In your Auth filter case, it’s common for after() to do nothing, 
        // because authentication is typically handled before the request hits the controller.

        // When to Use ?
        // - Logging request/response data
        // - Injecting headers (e.g., CORS, cache control)
        // - Adding custom audit trail logic
        // - Redirecting users after controller execution (rare in filters)
    }
}
