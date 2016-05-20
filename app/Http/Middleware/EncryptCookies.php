<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;
use Symfony\Component\HttpFoundation\Request;

class EncryptCookies extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    protected function decrypt(Request $request)
    {
        foreach ($request->cookies as $key => $c) {
            if ($this->isDisabled($key)) {
                continue;
            }

            try {
                $request->cookies->set($key, $this->decryptCookie($c));
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $request->cookies->set($key, null);
            } catch (\ErrorException $e) {
                $request->cookies->set($key, null);
            }
        }

        return $request;
    }
}
