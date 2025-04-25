<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class GithubRateLimitException extends Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $this->message = $message;
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request)
    {
        $date = Carbon::createFromTimestampUTC($this->message);
        $minutes = (int) now()->diffInMinutes($date);
        return redirect()->back()->with('message', 'Limite de requisição atingido. Volte em ' . $minutes . ' minutos.');
    }
}
