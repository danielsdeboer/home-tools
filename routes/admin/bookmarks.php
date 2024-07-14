<?php

use App\Http\Controllers\Bookmarks\BookmarkController;

Route::resource('bookmarks', BookmarkController::class)->except(['show']);
