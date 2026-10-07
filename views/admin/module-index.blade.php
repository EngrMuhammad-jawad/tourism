@extends('layouts.admin')

@section('title', $title)
@section('page_heading', $title)

@section('content')
    <div class="mb-8 flex items-end justify-between gap-4">
        <div><h2 class="text-2xl font-bold text-deepblack">{{ $title }}</h2><p class="mt-1 text-sm text-slate-500">Review the records currently stored in this module.</p></div>
        <div class="flex items-center gap-3"><span class="rounded-lg bg-gold/15 px-3 py-2 text-sm font-semibold text-yellow-800">{{ number_format($records->total()) }} total</span><a href="{{ route('admin.'.$module.'.create') }}" class="rounded-lg bg-deepblack px-4 py-2 text-sm font-bold text-white hover:bg-gold hover:text-deepblack">Add new</a></div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto"><table class="min-w-full text-left text-sm"><thead class="bg-gray-50 text-xs uppercase tracking-wide text-slate-500"><tr>@foreach($columns as $column)<th class="px-6 py-3">{{ str_replace('_', ' ', $column) }}</th>@endforeach<th class="px-6 py-3">Actions</th></tr></thead><tbody class="divide-y divide-gray-100">@forelse($records as $record)<tr class="text-slate-600">@foreach($columns as $column)@php($value = data_get($record, $column))<td class="max-w-xs px-6 py-4">@if(is_bool($value))<span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $value ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $value ? 'Active' : 'Inactive' }}</span>@elseif($value instanceof \BackedEnum){{ $value->value }}@elseif($value instanceof \DateTimeInterface){{ $value->format('d M Y, H:i') }}@elseif(is_array($value)){{ \Illuminate\Support\Str::limit(json_encode($value), 90) }}@else {{ \Illuminate\Support\Str::limit((string) $value, 90) }}@endif</td>@endforeach<td class="whitespace-nowrap px-6 py-4"><a href="{{ route('admin.'.$module.'.edit', $record) }}" class="font-semibold text-gold hover:underline">Edit</a><form method="POST" action="{{ route('admin.'.$module.'.destroy', $record) }}" class="ms-3 inline" onsubmit="return confirm('Delete this record?')">@csrf @method('DELETE')<button class="font-semibold text-red-600 hover:underline">Delete</button></form></td></tr>@empty<tr><td colspan="{{ count($columns) + 1 }}" class="px-6 py-14 text-center text-slate-500">No records are available yet.</td></tr>@endforelse</tbody></table></div><div class="border-t border-gray-100 px-6 py-4">{{ $records->links() }}</div>
    </section>
@endsection
