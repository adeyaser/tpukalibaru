<?php

namespace App\Filters;

use App\Models\MenuModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AclFilter implements FilterInterface
{
    /**
     * Check if user has permission to access the route
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Get current URL path
        $uri = $request->getUri();
        $segments = $uri->getSegments();
        
        // Skip if no segments (home page)
        if (empty($segments)) {
            return;
        }

        // Get first segment as menu identifier
        $menuUrl = $segments[0];
        
        // Determine action based on HTTP method and URI pattern
        $method = $request->getMethod();
        $action = 'view'; // default

        if ($method === 'POST') {
            $action = 'create';
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            $action = 'update';
        } elseif ($method === 'DELETE') {
            $action = 'delete';
        } elseif (count($segments) >= 2) {
            $secondSegment = $segments[1];
            if (in_array($secondSegment, ['create', 'new', 'add'])) {
                $action = 'create';
            } elseif (in_array($secondSegment, ['edit', 'update'])) {
                $action = 'update';
            } elseif (in_array($secondSegment, ['delete', 'remove'])) {
                $action = 'delete';
            }
        }

        // Get user ID from session
        $userId = session()->get('userId');
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Check permission
        $menuModel = new MenuModel();
        if (!$menuModel->hasPermission($userId, $menuUrl, $action)) {
            // Check if this is an AJAX request
            if ($request->hasHeader('X-Requested-With') && $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return service('response')
                    ->setJSON(['error' => 'Akses ditolak'])
                    ->setStatusCode(403);
            }

            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
