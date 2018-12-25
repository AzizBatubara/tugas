<?php
use App\Post;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/about');
});

Route::get('/about', function() {
     return 'Hi, This is about page';
});

Route::get('/blog', 'PostController@index');
// Route::get('/post/create', 'PostController@create');
// Route::post('/post/store', 'PostController@store');

// Route::get('/post/{id}', ['as' => 'post.detail', function($id) {
//    echo "Post $id";
//    echo "</br>";
//    echo "Body post in ID $id";
// }]);

Route::resource('post', 'PostController');


Route::get('/insert', function(){
    // DB::insert('insert into posts (title, body, user_id) values(?,?,?)', ['Belajar PHP dengan Laravel', 'Laravel the best framework', ' 1']);
    $data = [
        'title' => 'Disini ada title', 
        'body' => 'Isian body untuk table post',
        'user_id' => 2
    ];
    DB::table('posts')->insert($data);
    echo "Data berhasil ditambah";
});

Route::get('/read', function(){
    // $query = DB::select('select * from posts where id = ?', [1]);
    $query = DB::table('posts')->where('id', 1)->first();
    return var_dump($query);
});


Route::get('/update', function(){
    // $updated = DB::update('update posts set title = "Update field title" where id = ?', [1]);
    $data = [
        'title' => 'Isian Title',
        'body' => 'Isian body baru',
    ];
    $updated = DB::table('posts')->where('id', 1)->update($data);    
    return $updated;
});

Route::get('/delete', function(){
    // $delete = DB::delete('delete from posts where id = ?', [1]);
    $delete = DB::table('posts')->where('id',2)->delete();
    return $delete;
});

Route::get('/posts', function () {
    $posts = Post::all();
    return $posts;
});

Route::get('/find', function () {
    $post = Post::find(5);
    return $post;
});

Route::get('/findWhere', function () {
    $post = Post::where('user_id', 2)->orderBy('id', 'desc')->get();
    return $post;
});

Route::get('/create', function (){
    $post = new Post();
    $post->title = 'Isi judul Postingan';
    $post->body = 'Isian body dari postingan';
    $post->user_id = Auth::user()->id;

    $post->save();
});

Route::get('/createpost', function (){
    $post = Post::create([
            'title' => 'Create data dari method create', 
            'body' => 'Kita isi dengan isian post dari create method', 
            'user_id' => Auth::user()->id
        ]);
});

Route::get('/updatepost', function (){
    $post = Post::find(5);
    $post->update([
        'title' => 'update data dari method create', 
        'body' => 'Kita isi dengan isian post dari update method', 
        'user_id' => 5
    ]);
});

Route::get('/deletepost', function(){
    // $post = Post::find(4);
    // $post->delete();

    Post::destroy([13]);                          // Untuk menghapus id lebih dari 1
    $post = post::where('user_id', 3);              // Untuk menghapus berdasarkan id
    $post->delete();
});

Route::get('/softdelete', function(){
    Post::destroy(11,14,15);
});

Route::get('/trash', function(){
    //$posts = Post::withTrashed()->get();
    $posts = Post::onlyTrashed()->get();
    return $posts;
});

Route::get('/restore', function (){
    $posts = Post::onlyTrashed()->restore();
    return $posts;
});

Route::get('/forcedelete', function () {
    //$posts = Post::onlyTrashed()->where('id', 11)->forceDelete();
    //$posts = Post::onlyTrashed()->forceDelete();
    $posts = Post::find(17)->forceDelete();
    dd($posts);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', 'HomeController@user');
    
Route::get('/admin', function () {
    return 'Halaman Admin';
})->middleware(['role', 'auth']);


Route::get('/member', function (){
    return 'Halaman Member';    
});