@extends('layouts.basic')
@section('body')
  <main class="all-center">
    <article class="w-2/3 grid gap-4">
      <h1 class="text-center">Your Email Verification is Complete!</h1>
      <p class="text-2xl">
        @if ($name)
          Dear {{$name}}, <br>
        @endif
        We are thrilled to inform you that your email verification process has been successfully completed!
        On behalf of the entire team at Tripmaster, we warmly welcome you to our community of valued members. <br>
        By verifying your email address, you have taken an important step towards unlocking the full benefits and features of our platform.
        We believe this will be a significant milestone in your journey with us, and we are excited to have you on board.
      </p>
    </article>
  </main>
@endsection
