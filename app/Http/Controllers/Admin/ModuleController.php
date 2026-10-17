<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMenu;
use App\Models\Album;
use App\Models\AttractionTicket;
use App\Models\BlogCategory;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Hotel;
use App\Models\NewsletterSubscriber;
use App\Models\Post;
use App\Models\ServiceRequest;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ModuleController extends Controller
{
    private const MODULES = [
        'destinations' => ['title' => 'Destinations', 'model' => Destination::class, 'required' => ['slug', 'name', 'country'], 'columns' => ['name', 'country', 'city', 'status', 'created_at']],
        'packages' => ['title' => 'Tour Packages', 'model' => TourPackage::class, 'required' => ['destination_id', 'slug', 'name', 'price'], 'columns' => ['name', 'price', 'duration_days', 'status', 'created_at']],
        'tickets' => ['title' => 'Attraction Tickets', 'model' => AttractionTicket::class, 'required' => ['slug', 'title', 'counter_price', 'our_price'], 'columns' => ['title', 'city', 'category', 'counter_price', 'our_price', 'status', 'created_at']],
        'hotels' => ['title' => 'Hotels', 'model' => Hotel::class, 'required' => ['destination_id', 'slug', 'name'], 'columns' => ['name', 'star_rating', 'address', 'status', 'created_at']],
        'transports' => ['title' => 'Transport', 'model' => Transport::class, 'required' => ['type', 'slug', 'name', 'price'], 'columns' => ['name', 'type', 'capacity', 'price', 'status']],
        'bookings' => ['title' => 'Bookings', 'model' => Booking::class, 'required' => ['user_id', 'bookable_type', 'bookable_id', 'travel_date', 'adults', 'unit_price', 'total_price'], 'columns' => ['booking_number', 'travel_date', 'adults', 'total_price', 'payment_method', 'status']],
        'service-requests' => ['title' => 'Service Requests', 'model' => ServiceRequest::class, 'required' => ['service_type', 'name', 'email', 'phone'], 'columns' => ['reference_no', 'service_type', 'name', 'phone', 'service_date', 'status', 'created_at']],
        'albums' => ['title' => 'Gallery Albums', 'model' => Album::class, 'required' => ['slug', 'name'], 'columns' => ['name', 'slug', 'status', 'sort_order', 'created_at']],
        'testimonials' => ['title' => 'Testimonials', 'model' => Testimonial::class, 'required' => ['name', 'rating', 'content'], 'columns' => ['name', 'country', 'rating', 'status', 'created_at']],
        'blog-categories' => ['title' => 'Blog Categories', 'model' => BlogCategory::class, 'required' => ['slug', 'name'], 'columns' => ['name', 'slug', 'status', 'created_at']],
        'posts' => ['title' => 'Blog Posts', 'model' => Post::class, 'required' => ['user_id', 'blog_category_id', 'slug', 'title', 'content'], 'columns' => ['title', 'slug', 'status', 'published_at', 'created_at']],
        'tags' => ['title' => 'Tags', 'model' => Tag::class, 'required' => ['slug', 'name'], 'columns' => ['name', 'slug', 'created_at']],
        'comments' => ['title' => 'Comments', 'model' => Comment::class, 'required' => ['post_id', 'body'], 'columns' => ['name', 'email', 'body', 'status', 'created_at']],
        'faqs' => ['title' => 'FAQs', 'model' => Faq::class, 'required' => ['question', 'answer'], 'columns' => ['question', 'status', 'sort_order', 'created_at']],
        'contact-messages' => ['title' => 'Contact Messages', 'model' => ContactMessage::class, 'required' => ['name', 'email', 'message'], 'columns' => ['name', 'email', 'subject', 'status', 'created_at']],
        'newsletter' => ['title' => 'Newsletter Subscribers', 'model' => NewsletterSubscriber::class, 'required' => ['email'], 'columns' => ['email', 'is_active', 'created_at']],
        'users' => ['title' => 'Users', 'model' => User::class, 'required' => ['name', 'email', 'password'], 'columns' => ['name', 'email', 'phone', 'is_active', 'created_at']],
        'roles' => ['title' => 'Roles & Permissions', 'model' => Role::class, 'required' => ['name'], 'fields' => ['name', 'guard_name'], 'columns' => ['name', 'guard_name', 'created_at']],
        'menus' => ['title' => 'Sidebar Menu', 'model' => AdminMenu::class, 'required' => ['title'], 'columns' => ['title', 'route', 'permission_name', 'sort_order', 'status']],
        'settings' => ['title' => 'Settings', 'model' => Setting::class, 'required' => ['group', 'key'], 'columns' => ['group', 'key', 'value', 'updated_at']],
    ];

    public function index(Request $request, string $module)
    {
        if ($module === 'reports') {
            return view('admin.reports', ['adminMenu' => AdminMenu::sidebarFor($request->user())]);
        }

        $definition = $this->definition($module);
        $model = $definition['model'];

        return view('admin.module-index', [
            'adminMenu' => AdminMenu::sidebarFor($request->user()), 'module' => $module,
            'title' => $definition['title'], 'columns' => $definition['columns'],
            'records' => $model::query()->latest()->paginate(20)->withQueryString(),
        ]);
    }

    public function create(Request $request, string $module)
    {
        $this->ensureCan($request, $module, 'create');
        $definition = $this->definition($module);
        $class = $definition['model'];

        return $this->form($request, $module, $definition, new $class);
    }

    public function store(Request $request, string $module)
    {
        $this->ensureCan($request, $module, 'create');
        $definition = $this->definition($module);
        $class = $definition['model'];
        $record = new $class;
        $this->persist($request, $record, $definition);

        return redirect()->route("admin.{$module}.index")->with('success', "{$definition['title']} record created.");
    }

    public function edit(Request $request, string $record, string $module)
    {
        $this->ensureCan($request, $module, 'edit');
        $definition = $this->definition($module);

        return $this->form($request, $module, $definition, $this->record($definition, $record));
    }

    public function update(Request $request, string $record, string $module)
    {
        $this->ensureCan($request, $module, 'edit');
        $definition = $this->definition($module);
        $this->persist($request, $this->record($definition, $record), $definition, true);

        return redirect()->route("admin.{$module}.index")->with('success', "{$definition['title']} record updated.");
    }

    public function destroy(Request $request, string $record, string $module)
    {
        $this->ensureCan($request, $module, 'delete');
        $definition = $this->definition($module);
        $this->record($definition, $record)->delete();

        return redirect()->route("admin.{$module}.index")->with('success', "{$definition['title']} record deleted.");
    }

    private function form(Request $request, string $module, array $definition, Model $record)
    {
        return view('admin.module-form', [
            'adminMenu' => AdminMenu::sidebarFor($request->user()), 'module' => $module,
            'title' => $definition['title'], 'record' => $record, 'isEditing' => $record->exists,
            'fields' => $definition['fields'] ?? $record->getFillable(), 'required' => $definition['required'],
            'translatable' => method_exists($record, 'getTranslatableAttributes') ? $record->getTranslatableAttributes() : [],
        ]);
    }

    private function persist(Request $request, Model $record, array $definition, bool $updating = false): void
    {
        $fields = $definition['fields'] ?? $record->getFillable();
        $rules = [];
        $booleanFields = [];

        foreach ($fields as $field) {
            $required = in_array($field, $definition['required'], true) && ! ($updating && $field === 'password');
            $rules[$field] = [$required ? 'required' : 'nullable'];

            $isBoolean = in_array($field, ['is_active', 'is_featured'], true)
                || ($field === 'status' && ! ($record instanceof Post || $record instanceof Comment || $record instanceof Testimonial || $record instanceof ContactMessage || $record instanceof Booking || $record instanceof ServiceRequest));

            if ($field === 'email') {
                $rules[$field][] = 'email';
            } elseif ($isBoolean) {
                $rules[$field][] = 'boolean';
                $booleanFields[] = $field;
            } elseif ($field === 'status') {
                if ($record instanceof Post) {
                    $rules[$field][] = \Illuminate\Validation\Rule::enum(\App\Enums\PostStatus::class);
                } elseif ($record instanceof Comment || $record instanceof Testimonial) {
                    $rules[$field][] = \Illuminate\Validation\Rule::enum(\App\Enums\ModerationStatus::class);
                } elseif ($record instanceof ContactMessage) {
                    $rules[$field][] = \Illuminate\Validation\Rule::enum(\App\Enums\ContactStatus::class);
                } elseif ($record instanceof Booking) {
                    $rules[$field][] = \Illuminate\Validation\Rule::enum(\App\Enums\BookingStatus::class);
                } elseif ($record instanceof ServiceRequest) {
                    $rules[$field][] = \Illuminate\Validation\Rule::in(array_keys(\App\Models\ServiceRequest::STATUSES));
                } else {
                    $rules[$field][] = 'string';
                }
            } elseif ($field === 'payment_method' && $record instanceof Booking) {
                $rules[$field][] = \Illuminate\Validation\Rule::enum(\App\Enums\PaymentMethod::class);
            } elseif ($field === 'type' && $record instanceof Transport) {
                $rules[$field][] = \Illuminate\Validation\Rule::enum(\App\Enums\TransportType::class);
            } elseif ($field === 'service_type' && $record instanceof ServiceRequest) {
                $rules[$field][] = \Illuminate\Validation\Rule::in(array_keys(\App\Models\ServiceRequest::SERVICE_TYPES));
            } elseif (str_ends_with($field, '_id') || in_array($field, ['adults', 'children', 'capacity', 'quantity', 'duration_days', 'duration_nights', 'star_rating', 'rating', 'sort_order'])) {
                $rules[$field][] = 'integer';
            } elseif (str_contains($field, 'price') || in_array($field, ['map_lat', 'map_lng', 'budget'])) {
                $rules[$field][] = 'numeric';
            } elseif (in_array($field, ['available_from', 'available_to', 'travel_date', 'service_date', 'return_date'])) {
                $rules[$field][] = 'date';
            } else {
                $rules[$field][] = 'string';
            }
        }

        $data = $request->validate($rules);

        foreach ($booleanFields as $boolean) {
            $data[$boolean] = $request->boolean($boolean);
        }

        if ($updating && empty($data['password'])) {
            unset($data['password']);
        }
        foreach (method_exists($record, 'getTranslatableAttributes') ? $record->getTranslatableAttributes() : [] as $field) {
            $translations = [];
            foreach (array_keys(config('localization.supported')) as $locale) {
                $inputName = "{$field}_{$locale}";
                if ($request->has($inputName)) {
                    $translations[$locale] = $request->input($inputName);
                }
            }
            if (! empty($translations)) {
                $data[$field] = $translations;
            } elseif (array_key_exists($field, $data) && is_string($data[$field])) {
                $data[$field] = collect(config('localization.supported'))->keys()->mapWithKeys(fn ($locale) => [$locale => $data[$field]])->all();
            }
        }
        if (isset($data['value']) && is_string($data['value'])) {
            $data['value'] = json_decode($data['value'], true) ?? $data['value'];
        }
        $record->fill($data)->save();

        if ($record instanceof \Spatie\MediaLibrary\HasMedia) {
            if ($request->hasFile('featured_image')) {
                $record->clearMediaCollection('featured');
                $record->addMediaFromRequest('featured_image')->toMediaCollection('featured');
            }
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $record->addMedia($file)->toMediaCollection('gallery');
                }
            }
        }
    }

    private function record(array $definition, string $id): Model
    {
        $modelClass = $definition['model'];
        $model = new $modelClass;
        $routeKeyName = $model->getRouteKeyName();

        return $modelClass::query()
            ->where(function ($query) use ($model, $routeKeyName, $id) {
                $query->where($routeKeyName, $id);
                if ($routeKeyName !== $model->getKeyName() && is_numeric($id)) {
                    $query->orWhere($model->getKeyName(), $id);
                }
            })
            ->firstOrFail();
    }

    private function definition(string $module): array
    {
        abort_unless(array_key_exists($module, self::MODULES), 404);

        return self::MODULES[$module];
    }

    private function ensureCan(Request $request, string $module, string $action): void
    {
        $permission = match ($module) {
            'destinations', 'packages', 'tickets', 'hotels', 'transports', 'users' => ($module === 'tickets' ? 'packages' : $module).".{$action}",
            'bookings' => 'bookings.manage',
            'service-requests' => $action === 'delete' ? 'service-requests.delete' : 'service-requests.manage',
            'albums' => 'gallery.manage',
            'testimonials', 'comments' => "{$module}.moderate",
            'blog-categories', 'tags' => 'blog.'.($action === 'delete' ? 'delete' : ($action === 'create' ? 'create' : 'edit')),
            'posts' => "blog.{$action}",
            'faqs' => 'faqs.manage',
            'contact-messages' => $action === 'delete' ? 'contacts.delete' : 'contacts.reply',
            'newsletter' => 'newsletter.manage',
            'roles' => 'roles.manage',
            'menus' => 'menus.manage',
            'settings' => 'settings.manage',
            default => 'dashboard.view',
        };

        abort_unless($request->user()->can($permission), 403);
    }
}
