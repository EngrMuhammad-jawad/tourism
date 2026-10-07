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
    <form method="POST" action="{{ $isEditing ? route('admin.'.$module.'.update', $record) : route('admin.'.$module.'.store') }}" class="max-w-4xl rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">@csrf @if($isEditing) @method('PUT') @endif
        <div class="grid gap-6 md:grid-cols-2">
        @foreach($fields as $field)
            @php
                $label = ucwords(str_replace('_', ' ', $field));
                $isRequired = in_array($field, $required, true) && !($isEditing && $field === 'password');
                $isBoolean = in_array($field, ['status', 'is_active', 'is_featured'], true);
                $isLong = in_array($field, ['description', 'summary', 'content', 'excerpt', 'body', 'message', 'customer_note', 'admin_note', 'reply_message', 'included_services', 'excluded_services', 'value'], true);
                $isDate = in_array($field, ['available_from', 'available_to', 'travel_date'], true);
                $isNumber = str_ends_with($field, '_id') || in_array($field, ['price', 'sale_price', 'unit_price', 'total_price', 'map_lat', 'map_lng', 'adults', 'children', 'capacity', 'quantity', 'duration_days', 'duration_nights', 'star_rating', 'rating', 'sort_order'], true);
                $value = old($field, in_array($field, $translatable, true) && $record->exists ? $record->getTranslation($field, 'en', false) : $record->getAttribute($field));
                if (is_array($value)) $value = json_encode($value);
                if ($value instanceof \DateTimeInterface) $value = $isDate ? $value->format('Y-m-d') : $value->format('Y-m-d\\TH:i');
            @endphp
            <div @class(['md:col-span-2' => $isLong || $isBoolean || in_array($field, $translatable, true)])>
                @if($isBoolean)
                    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 p-4 transition-all duration-200 hover:bg-slate-50 hover:border-slate-300">
                        <input type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $record->getAttribute($field))) class="h-5 w-5 rounded border-slate-300 text-gold focus:ring-gold/30 focus:ring-offset-0">
                        <span class="font-semibold text-slate-700">{{ $label }}</span>
                    </label>
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
        </div>
        <div class="mt-8 flex gap-3">
            <button type="submit" class="rounded-xl bg-deepblack px-6 py-3.5 text-sm font-bold text-white transition hover:bg-gold hover:text-deepblack hover:shadow-lg hover:shadow-gold/10">{{ $isEditing ? 'Save changes' : 'Create record' }}</button>
            <a href="{{ route('admin.'.$module.'.index') }}" class="rounded-xl border border-slate-200 px-6 py-3.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</a>
        </div>
    </form>
@endsection
