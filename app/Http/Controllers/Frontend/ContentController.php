<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ContactStatus;
use App\Enums\ModerationStatus;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\NewsletterSubscriber;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContentController extends Controller
{
    public function gallery()
    {
        $albums = Album::active()->with('media')->orderBy('sort_order')->paginate(12);
        $videos = \App\Models\GalleryVideo::where('status', true)->orderBy('sort_order')->get();

        return view('frontend.content.gallery', compact('albums', 'videos'));
    }

    public function album(Album $album)
    {
        abort_unless($album->status, 404);
        $album->load('media');
        $videos = \App\Models\GalleryVideo::where('album_id', $album->id)->where('status', true)->get();

        return view('frontend.content.album', compact('album', 'videos'));
    }

    public function uploadGalleryMedia(Request $request)
    {
        $request->validate([
            'media_type' => ['required', 'in:photo,video'],
            'title' => ['required', 'string', 'max:255'],
            'photo' => ['required_if:media_type,photo', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'video_url' => ['required_if:media_type,video', 'nullable', 'string', 'max:500'],
        ]);

        $album = Album::firstOrCreate(
            ['slug' => 'traveler-submissions'],
            [
                'name' => ['en' => 'Traveler Submissions'],
                'description' => ['en' => 'Photos and videos submitted by travelers.'],
                'status' => true,
                'sort_order' => 99,
            ]
        );

        if ($request->media_type === 'photo' && $request->hasFile('photo')) {
            $album->addMediaFromRequest('photo')->toMediaCollection('images');
        } elseif ($request->media_type === 'video' && $request->filled('video_url')) {
            $url = $request->input('video_url');
            if (str_contains($url, 'watch?v=')) {
                $url = str_replace('watch?v=', 'embed/', $url);
            }
            \App\Models\GalleryVideo::create([
                'album_id' => $album->id,
                'title' => ['en' => $request->input('title')],
                'video_url' => $url,
                'status' => true,
            ]);
        }

        return back()->with('success', 'Thank you! Your media has been uploaded and added to the gallery.');
    }

    public function testimonials()
    {
        return view('frontend.content.testimonials', ['testimonials' => Testimonial::approved()->latest()->paginate(12)]);
    }

    public function faqs()
    {
        return view('frontend.content.faqs', ['faqs' => Faq::active()->get()]);
    }

    public function posts(Request $request)
    {
        $posts = Post::published()->with(['author', 'category', 'tags']);
        $posts->when($request->filled('q'), fn ($query) => $query->where('title->'.app()->getLocale(), 'like', '%'.$request->string('q').'%'));

        return view('frontend.content.posts', ['posts' => $posts->latest('published_at')->paginate(12)->withQueryString()]);
    }

    public function post(Post $post)
    {
        abort_unless($post->status->value === 'published' && $post->published_at?->isPast(), 404);

        return view('frontend.content.post', ['post' => $post->load(['author', 'category', 'tags', 'comments' => fn ($query) => $query->approved()->with('user')])]);
    }

    public function contact()
    {
        return view('frontend.content.contact');
    }

    public function storeContact(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'max:255'], 'phone' => ['nullable', 'string', 'max:30'], 'subject' => ['nullable', 'string', 'max:255'], 'message' => ['required', 'string', 'max:5000']]);
        ContactMessage::create([...$data, 'status' => ContactStatus::New]);

        return back()->with('success', 'Thank you. Your message has been received.');
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:255']]);
        NewsletterSubscriber::withTrashed()->updateOrCreate(['email' => $data['email']], ['is_active' => true, 'deleted_at' => null]);

        return back()->with('success', 'You are now subscribed to our newsletter.');
    }

    public function storeTestimonial(Request $request)
    {
        $data = $request->validate(['country' => ['nullable', 'string', 'max:100'], 'rating' => ['required', 'integer', 'between:1,5'], 'content' => ['required', 'string', 'max:2000']]);
        Testimonial::create([...$data, 'user_id' => $request->user()->id, 'name' => $request->user()->name, 'status' => ModerationStatus::Pending]);

        return back()->with('success', 'Thank you. Your review will appear after moderation.');
    }

    public function storeComment(Request $request, Post $post)
    {
        abort_unless($post->status->value === 'published', 404);
        $data = $request->validate(['body' => ['required', 'string', 'max:3000'], 'parent_id' => ['nullable', Rule::exists('comments', 'id')]]);
        Comment::create([...$data, 'post_id' => $post->id, 'user_id' => $request->user()->id, 'name' => $request->user()->name, 'email' => $request->user()->email, 'status' => ModerationStatus::Pending]);

        return back()->with('success', 'Your comment is awaiting moderation.');
    }
}
