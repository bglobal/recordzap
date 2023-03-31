<?php

return [
    "payment_mode" => env('STRIPE_PAYMENT_MODE', 'live'),
    "stripe_key" => env('STRIPE_KEY', 'pk_test_51MOp2lFp7jn3ewVnWgjTvQGsZa4SHDtbyjfe4l64rSP5UQVM7Yt2gJgorUQ4ELVGvMSXwW478QUyzbtu10HzHgjM003p1Owb6Q'),
    "stripe_secret" => env('STRIPE_SECRET','sk_test_51MOp2lFp7jn3ewVnF53QOQKV2DnokoKpcKIhNWEGSksquNav90fxkKXQkhIgJKYkEr13i0v5xnHA0Gwpc7aRVzlU004aeqoPzG'),
    "url" => "https://dashboard.stripe.com/",
    "url_test" => "https://dashboard.stripe.com/test/",
];
