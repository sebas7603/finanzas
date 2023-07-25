<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ReturnHelper;
use App\Models\Financial;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CheckFinancialExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\JsonResponse)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $id = $request->route('financial_id');
        $financial = Financial::find($id);
        if (!$financial) {
            return ReturnHelper::returnNotFound('Las finanzas no existen');
        }

        return $next($request);
    }
}
