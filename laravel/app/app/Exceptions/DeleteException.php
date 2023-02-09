<?php

namespace App\Exceptions;

use Exception;

class DeleteException extends Exception
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 405);
    }
}
