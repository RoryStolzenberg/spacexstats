<?php
Route::post('/missioncontrol/payments/subscribe', 'Payment\PaymentController@subscribe')->middleware(['auth']);