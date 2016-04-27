<?php
Route::group(['prefix' => 'webhooks', 'namespace' => 'Webhooks'], function () {
	Route::post('/stripe', "StripeWebhookController@handleWebhook");
});
