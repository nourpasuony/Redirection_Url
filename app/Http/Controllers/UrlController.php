<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UrlService;
use App\Helpers\UrlHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;



class UrlController extends Controller
{
    protected $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * Shorten a URL.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shorten(Request $request)
    {
        try {
            UrlHelper::validateUrl($request->all());

            $result = $this->urlService->shortenUrl($request->original_url);

            return response()->json($result, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('URL Shortening Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    /**
     * Redirect to the original URL.
     *
     * @param string $shortCode
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function redirect($shortCode)
    {
        try {
            $originalUrl = $this->urlService->redirectUrl($shortCode);

            if (!$originalUrl) {
                return response()->json([
                    'error' => 'URL not found',
                ], 404);
            }
            return Redirect::to($originalUrl);
        } catch (\Exception $e) {
            Log::error('URL Redirection Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while processing your request.',
            ], 500);
        }
    }
}