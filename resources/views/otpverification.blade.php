<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP Verification</title>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mx-auto p-4">
    <div class="flex justify-center">
      <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <h2 class="text-center text-2xl mb-6">OTP Verification</h2>
          <p>check otp code at your email {{$email}}</p>
          <p>expired at {{$otp_expires_at}}</p>
          <form action="{{route('verifyOtp')}}" method="POST">
            @csrf
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="otp">
                otp
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="otp" type="number" name="otp" required>
            </div>
            <div class="flex items-center justify-between">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Send
              </button>
            </div>
          </form>
          <a href="{{route('resend_otp')}}">resend otp</a>
        </div>
      </div>
    </div>
  </div>
</body>
              
