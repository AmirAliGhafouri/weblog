<?php

namespace App\Exceptions;

use Exception;

class DatabaseOperationException extends Exception
{
     /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function render()
    {
        return redirect()
            ->back()
            ->with('message', $this->getMessage());
    }
}
