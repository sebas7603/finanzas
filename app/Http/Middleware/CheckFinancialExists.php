<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Financial;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CheckFinancialExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $id = $request->route('financial_id');
        $financial = Financial::find($id);
        if (!$financial) {
            return response()->json([
                'success' => false,
                'msg' => 'Las finanzas no existen',
            ], 404);
        }

        return $next($request);
    }
}
