<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __invoke(UserRepositoryInterface $userRepository)
    {
        $employees = $userRepository->employees();
        return response()->json(EmployeeResource::collection($employees));
    }
}
