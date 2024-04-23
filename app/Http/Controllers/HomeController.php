<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index()
    {
        // Return all posts with their user
        return Post::all()->load('user');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'user_id' => 'required'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        // image field is in base64 format. Convert it to a file and store it in public/post_images. Then generate an url for the image
        if ($request->image) {
            $image = $request->image;
            $fileextension = explode('/', mime_content_type($image))[1];
            $image = str_replace('data:image/' . $fileextension . ';base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'post_' . time() . '.jpg';
            $fileimage = base64_decode($image);
            $manager = new ImageManager((new Driver()));
            $img = $manager->read($fileimage);
            // Resize the image for a social media post: do not distort the image
            // $img = $img->crop($img->width(), $img->width())->toJpeg(80);
            // $img = $img->resize(600, 600)->toJpeg(80); //->save(base_path('public/post_images/' . $imageName));
            $img = $img->toJpeg(70);
            Storage::disk('public')->put('post_images/' . $imageName, $img);
            $post->image = $imageName;
        }
        $post->save();
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return mixed
     */
    public function show(string $id)
    {
        return Post::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        // image field is in base64 format. Convert it to a file and store it in public/post_images
        if ($request->image) {
            $image = $request->image;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'post_' . time() . '.png';
            Storage::disk('public')->put('post_images/' . $imageName, base64_decode($image));
            $post->image = $imageName;
        }
        $post->save();
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Post::destroy($id);
    }

    /**
     * Display the comments of the specified resource.
     */
    public function comments(string $id)
    {
        $post = Post::find($id);
        return $post->comments->load('user');
    }
}
