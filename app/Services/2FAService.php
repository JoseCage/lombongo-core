<?php

namespace Lombongo\Services;

use PragmaRX\Google2FALaravel\Facade as TwoFactor;
use Illuminate\Http\Request;

class 2FAService
{

  public function generate()
  {
    $key = TwoFactor::generateSecretKey();

    return [
      'key' => $key,
      'qr' => TwoFactor::getQRCodeInline(
          config('app.name'), // A name for the code in 2FA apps
          auth()->user()->email, // The user's email
          $key,
        ),
    ];
  }

/**
* Validate & configure two-factor authentication.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\RedirectResponse
*/
public function configure(Request $request)
{
  $request->validate([
    'key' => ['required', 'string'],
    'code' => ['required', 'string', function($attribute, $value, $fail) use($request){
      if (! TwoFactor::verify($request->input('key'),$value)) {
        $fail('The code you provided is not valid.')
      }
    }],
  ]);

  $request->user()->update([
    'twofactor' => $request->input('key'), // This contains the secret key we generated earlier
  ]);

  return response()->json([
    'message' => 'Two Factor Authentication has been successfuly configured.'
  ]);
}


}
