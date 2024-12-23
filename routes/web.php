<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('main.index');
});


Route::group(['namespace' => 'App\Http\Controllers\Post', 'prefix' => 'posts'], function () {
    Route::get('/page/{page?}', 'IndexController')->name('post.index');
    Route::get('/{post}', 'ShowController')->name('post.show');

    Route::group(['namespace' => 'Comment', 'prefix' => '{post}/comments'], function () {
        Route::post('/', 'StoreController')->name('post.comment.store');
    });

    Route::group(['namespace' => 'Like', 'prefix' => '{post}/likes'], function () {
        Route::post('/', 'StoreController')->name('post.like.store');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Category', 'prefix' => 'categories'], function () {
    Route::get('/', 'IndexController')->name('category.index');
    Route::group(['namespace' => 'Post', 'prefix' => '{category}/posts'], function () {
        Route::get('/', 'IndexController')->name('category.post.index');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Tag', 'prefix' => 'tags'], function () {
    Route::get('/', 'IndexController')->name('tag.index');
    Route::group(['namespace' => 'Post', 'prefix' => 'posts'], function () {
        Route::get('/', 'IndexController')->name('tag.post.index');
    });
});
Route::group(['namespace' => 'App\Http\Controllers\Volunteer', 'prefix' => 'volunteer', 'middleware' => ['auth', 'verified']], function () {

    Route::group(['namespace' => 'Main', 'prefix' => 'main'], function () {
        Route::get('/', 'IndexController')->name('volunteer.main.index');
    });

    Route::group(['namespace' => 'Post', 'prefix' => 'post'], function () {
        Route::get('/', 'IndexController')->name('volunteer.post.index');
        Route::get('/create', 'CreateController')->name('volunteer.post.create');
        Route::post('/', 'StoreController')->name('volunteer.post.store');
        Route::get('/{post}', 'ShowController')->name('volunteer.post.show');
        Route::get('/{post}/edit', 'EditController')->name('volunteer.post.edit');
        Route::patch('/{post}', 'UpdateController')->name('volunteer.post.update');
        Route::delete('/{post}', 'DeleteController')->name('volunteer.post.destroy');
    });

    Route::group(['namespace' => 'Map', 'prefix' => 'markers'], function () {
        Route::get('/', 'IndexController')->name('volunteer.marker.index');
        Route::get('/create', 'CreateController')->name('volunteer.marker.create');
        Route::post('/', 'StoreController')->name('volunteer.marker.store');
        Route::get('/{marker}/edit', 'EditController')->name('volunteer.marker.edit');
        Route::patch('/{marker}', 'UpdateController')->name('volunteer.marker.update');
        Route::delete('/{marker}', 'DeleteController')->name('volunteer.marker.destroy');
    });
});
Route::group(['namespace' => 'App\Http\Controllers\Personal', 'prefix' => 'personal', 'middleware' => ['auth', 'verified']], function () {
    Route::group(['namespace' => 'Main', 'prefix' => 'main'], function () {
        Route::get('/', 'IndexController')->name('personal.main.index');
    });
    Route::group(['namespace' => 'Liked', 'prefix' => 'liked'], function () {
        Route::get('/', 'IndexController')->name('personal.like.index');
        Route::delete('/{post}', 'DeleteController')->name('personal.liked.delete');

    });
    Route::group(['namespace' => 'Comment', 'prefix' => 'comments'], function () {
        Route::get('/', 'IndexController')->name('personal.comment.index');
        Route::get('/{comment}/edit', 'EditController')->name('personal.comment.edit');
        Route::patch('/{comment}', 'UpdateController')->name('personal.comment.update');
        Route::delete('/{comment}', 'DeleteController')->name('personal.comment.delete');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'admin', 'verified']], function () {
    Route::group(['namespace' => 'Main'], function () {
        Route::get('/', 'IndexController')->name('admin.main.index');
    });
    Route::group(['namespace' => 'Map', 'prefix' => 'markers'], function () {
        Route::get('/', 'IndexController')->name('admin.marker.index');
        Route::get('/create', 'CreateController')->name('admin.marker.create');
        Route::post('/', 'StoreController')->name('admin.marker.store');
        Route::get('/{marker}', 'ShowController')->name('admin.marker.show');
        Route::get('/{marker}/edit', 'EditController')->name('admin.marker.edit');
        Route::put('/{marker}', 'UpdateController')->name('admin.marker.update');
        Route::delete('/{marker}', 'DeleteController')->name('admin.marker.delete');

    });

    Route::group(['namespace' => 'Category', 'prefix' => 'categories'], function () {
        Route::get('/', 'IndexController')->name('admin.category.index');
        Route::get('/create', 'CreateController')->name('admin.category.create');
        Route::post('/', 'StoreController')->name('admin.category.store');
        Route::get('/{category}', 'ShowController')->name('admin.category.show');
        Route::get('/{category}/edit', 'EditController')->name('admin.category.edit');
        Route::patch('/{category}', 'UpdateController')->name('admin.category.update');
        Route::delete('/{category}', 'DeleteController')->name('admin.category.delete');
    });

    Route::group(['namespace' => 'Tag', 'prefix' => 'tags'], function () {
        Route::get('/', 'IndexController')->name('admin.tag.index');
        Route::get('/create', 'CreateController')->name('admin.tag.create');
        Route::post('/', 'StoreController')->name('admin.tag.store');
        Route::get('/{tag}', 'ShowController')->name('admin.tag.show');
        Route::get('/{tag}/edit', 'EditController')->name('admin.tag.edit');
        Route::patch('/{tag}', 'UpdateController')->name('admin.tag.update');
        Route::delete('/{tag}', 'DeleteController')->name('admin.tag.delete');
    });

    Route::group(['namespace' => 'Post', 'prefix' => 'posts'], function () {
        Route::get('/', 'IndexController')->name('admin.post.index');
        Route::get('/create', 'CreateController')->name('admin.post.create');
        Route::post('/', 'StoreController')->name('admin.post.store');
        Route::get('/{post}', 'ShowController')->name('admin.post.show');
        Route::get('/{post}/edit', 'EditController')->name('admin.post.edit');
        Route::patch('/{post}', 'UpdateController')->name('admin.post.update');
        Route::delete('/{post}', 'DeleteController')->name('admin.post.delete');
    });

    Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
        Route::get('/', 'IndexController')->name('admin.user.index');
        Route::get('/create', 'CreateController')->name('admin.user.create');
        Route::post('/', 'StoreController')->name('admin.user.store');
        Route::get('/{user}', 'ShowController')->name('admin.user.show');
        Route::get('/{user}/edit', 'EditController')->name('admin.user.edit');
        Route::patch('/{user}', 'UpdateController')->name('admin.user.update');
        Route::delete('/{user}', 'DeleteController')->name('admin.user.delete');
    });
});

Route::group(['namespace' => 'App\Http\Controllers', 'prefix' => 'messages', 'middleware' => ['auth']], function () {

    Route::get('/', [MessageController::class, 'index'])->name('messages.index');

    // Запросы на переписку
    Route::group(['prefix' => 'request'], function () {
        Route::post('/{receiver_id}', [MessageController::class, 'createMessageRequest'])->name('messages.request');
        Route::post('/{request_id}/accept', [MessageController::class, 'acceptRequest'])->name('messages.request.accept');
        Route::post('/{request_id}/reject', [MessageController::class, 'rejectRequest'])->name('messages.request.reject');
    });

    Route::group(['prefix' => 'conversation'], function () {
        Route::get('/{otherUserId}', [MessageController::class, 'showConversation'])->name('messages.conversation');
        Route::post('/send/{receiverId}', [MessageController::class, 'sendMessage'])->name('messages.send');
    });
    Route::get('/fetch/{otherUserId}', 'MessageController@fetchMessages')->name('messages.fetch');

});

Auth::routes(['verify' => true]);

