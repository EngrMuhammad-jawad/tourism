@extends('layouts.admin')

@section('title', ($isEditing ? 'Edit ' : 'Create ').$title)
@section('page_heading', $isEditing ? 'Edit '.$title : 'Create '.$title)

@section('content')
    <div class="mb-8 flex items-end justify-between">
        <div>
            <h2 class="text-2xl font-bold text-deepblack">{{ $isEditing ? 'Edit' : 'Create' }} {{ $title }}</h2>
            <p class="mt-1 text-sm text-slate-500">Fields marked with an asterisk are required.</p>
        </div>
        <div class="flex items-center gap-4">
            @if($isEditing)
                <a href="{{ route('admin.'.$module.'.create') }}" class="rounded-lg bg-gold/10 px-4 py-2 text-sm font-bold text-yellow-800 hover:bg-gold hover:text-deepblack">Create new</a>
            @endif
            <a href="{{ route('admin.'.$module.'.index') }}" class="text-sm font-semibold text-slate-600 hover:text-gold">← Back to list</a>
        </div>
    </div>
    <form method="POST" action="{{ $isEditing ? route('admin.'.$module.'.update', $record) : route('admin.'.$module.'.store') }}" enctype="multipart/form-data" class="max-w-4xl rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">@csrf @if($isEditing) @method('PUT') @endif
        <div class="grid gap-6 md:grid-cols-2">
        @foreach($fields as $field)
            @php
                $label = ucwords(str_replace('_', ' ', $field));
                $isRequired = in_array($field, $required, true) && !($isEditing && $field === 'password');
                $isBoolean = in_array($field, ['status', 'is_active', 'is_featured'], true) && !($field === 'status' && ($record instanceof \App\Models\ServiceRequest || $record instanceof \App\Models\Booking));
                $isLong = in_array($field, ['description', 'summary', 'content', 'excerpt', 'body', 'message', 'customer_note', 'admin_note', 'admin_notes', 'notes', 'reply_message', 'included_services', 'excluded_services', 'value', 'details'], true);
                $isDate = in_array($field, ['available_from', 'available_to', 'travel_date', 'service_date', 'return_date'], true);
                $isNumber = str_ends_with($field, '_id') || in_array($field, ['price', 'sale_price', 'unit_price', 'total_price', 'budget', 'map_lat', 'map_lng', 'adults', 'children', 'guests_count', 'capacity', 'quantity', 'duration_days', 'duration_nights', 'star_rating', 'rating', 'sort_order'], true);
                $value = old($field, in_array($field, $translatable, true) && $record->exists ? $record->getTranslation($field, 'en', false) : $record->getAttribute($field));
                if (is_array($value)) $value = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                if ($value instanceof \DateTimeInterface) $value = $isDate ? $value->format('Y-m-d') : $value->format('Y-m-d\\TH:i');
            @endphp
            <div @class(['md:col-span-2' => $isLong || $isBoolean || in_array($field, $translatable, true)])>
                @if($isBoolean)
                    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 p-4 transition-all duration-200 hover:bg-slate-50 hover:border-slate-300">
                        <input type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $record->getAttribute($field))) class="h-5 w-5 rounded border-slate-300 text-gold focus:ring-gold/30 focus:ring-offset-0">
                        <span class="font-semibold text-slate-700">{{ $label }}</span>
                    </label>
                @elseif($field === 'status' && $record instanceof \App\Models\ServiceRequest)
                    <label for="{{ $field }}" class="mb-2 block text-sm font-semibold text-slate-700 tracking-wide">{{ $label }} @if($isRequired)<span class="text-red-600">*</span>@endif</label>
                    <select id="{{ $field }}" name="{{ $field }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-gold focus:bg-white focus:ring-4 focus:ring-gold/20 focus:outline-none transition-all">
                        @foreach(\App\Models\ServiceRequest::STATUSES as $stKey => $stLabel)
                            <option value="{{ $stKey }}" @selected(old($field, $value) == $stKey)>{{ $stLabel }}</option>
                        @endforeach
                    </select>
                @elseif($field === 'service_type' && $record instanceof \App\Models\ServiceRequest)
                    <label for="{{ $field }}" class="mb-2 block text-sm font-semibold text-slate-700 tracking-wide">{{ $label }} @if($isRequired)<span class="text-red-600">*</span>@endif</label>
                    <select id="{{ $field }}" name="{{ $field }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-gold focus:bg-white focus:ring-4 focus:ring-gold/20 focus:outline-none transition-all">
                        @foreach(\App\Models\ServiceRequest::SERVICE_TYPES as $sTypeKey => $sTypeLabel)
                            <option value="{{ $sTypeKey }}" @selected(old($field, $value) == $sTypeKey)>{{ $sTypeLabel }}</option>
                        @endforeach
                    </select>
                @elseif(in_array($field, $translatable, true))
                    <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-4 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200/60 pb-2">
                            <label class="text-sm font-bold text-slate-800 tracking-wide">{{ $label }} <span class="text-xs font-normal text-gold uppercase ms-1">(Multilingual)</span> @if($isRequired)<span class="text-red-600">*</span>@endif</label>
                        </div>
                        <div class="grid gap-3 md:grid-cols-3">
                            @foreach(config('localization.supported') as $loc => $meta)
                                @php
                                    $locVal = old("{$field}_{$loc}", $record->exists ? $record->getTranslation($field, $loc, false) : '');
                                @endphp
                                <div>
                                    <span class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $meta['native'] }} ({{ strtoupper($loc) }})</span>
                                    @if($isLong)
                                        <textarea id="{{ $field }}_{{ $loc }}" name="{{ $field }}_{{ $loc }}" rows="3" dir="{{ $meta['dir'] }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all" @if($loc === 'en' && $isRequired) required @endif>{{ $locVal }}</textarea>
                                    @else
                                        <input id="{{ $field }}_{{ $loc }}" name="{{ $field }}_{{ $loc }}" type="text" value="{{ $locVal }}" dir="{{ $meta['dir'] }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all" @if($loc === 'en' && $isRequired) required @endif>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <label for="{{ $field }}" class="mb-2 block text-sm font-semibold text-slate-700 tracking-wide">{{ $label }} @if($isRequired)<span class="text-red-600">*</span>@endif</label>
                    @if($isLong)
                        <textarea id="{{ $field }}" name="{{ $field }}" rows="{{ in_array($field, ['content', 'description', 'message'], true) ? 7 : 4 }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 shadow-sm focus:border-gold focus:bg-white focus:ring-4 focus:ring-gold/20 focus:outline-none transition-all duration-200" @required($isRequired)>{{ $value }}</textarea>
                    @else
                        <input id="{{ $field }}" name="{{ $field }}" type="{{ $field === 'password' ? 'password' : ($isDate ? 'date' : ($isNumber ? 'number' : ($field === 'email' ? 'email' : 'text'))) }}" value="{{ $field === 'password' ? '' : $value }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 shadow-sm focus:border-gold focus:bg-white focus:ring-4 focus:ring-gold/20 focus:outline-none transition-all duration-200" @required($isRequired) @if($isNumber) step="any" @endif>
                    @endif
                    @error($field)<p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                @endif
            </div>
        @endforeach

        @if($record instanceof \Spatie\MediaLibrary\HasMedia)
            <div class="md:col-span-2 border-t border-slate-100 pt-6 mt-2 space-y-6">
                <h3 class="text-base font-bold text-deepblack flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gold/15 text-gold text-xs">📷</span>
                    Media &amp; Visual Assets
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Featured Image Upload -->
                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-4 space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Featured Primary Image
                        </label>
                        @if($record->exists && $record->hasMedia('featured'))
                            <div class="relative w-full h-36 rounded-xl overflow-hidden bg-black/5 border border-slate-200">
                                <img src="{{ $record->getFirstMediaUrl('featured') }}" alt="Featured Image" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="featured_image" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gold/15 file:text-yellow-800 hover:file:bg-gold hover:file:text-deepblack transition-all">
                        <p class="text-[11px] text-slate-400">Recommended 1920x1080 (JPG, PNG, WebP). Automatically resized &amp; converted to WebP.</p>
                    </div>

                    <!-- Gallery Images Upload -->
                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-4 space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Gallery Photos (Multiple)
                        </label>
                        @if($record->exists && $record->hasMedia('gallery'))
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                @foreach($record->getMedia('gallery') as $mediaItem)
                                    <div class="relative h-16 w-16 shrink-0 rounded-lg overflow-hidden border border-slate-200">
                                        <img src="{{ $mediaItem->getUrl() }}" alt="Gallery Item" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" name="gallery_images[]" multiple accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gold/15 file:text-yellow-800 hover:file:bg-gold hover:file:text-deepblack transition-all">
                        <p class="text-[11px] text-slate-400">Select multiple photos to append to the gallery collection.</p>
                    </div>
                </div>
            </div>
        @endif
        </div>
        <div class="mt-8 flex gap-3">
            <button type="submit" class="rounded-xl bg-deepblack px-6 py-3.5 text-sm font-bold text-white transition hover:bg-gold hover:text-deepblack hover:shadow-lg hover:shadow-gold/10">{{ $isEditing ? 'Save changes' : 'Create record' }}</button>
            <a href="{{ route('admin.'.$module.'.index') }}" class="rounded-xl border border-slate-200 px-6 py-3.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</a>
        </div>
    </form>
@endsection
