@extends('layouts.app')
@section('main')

<div class="container">

    <h1>Researcher Module</h1>

    <div class="overflow-auto border mt-4 mb-4" style="height: 80vh;">
        <table class="table">
            <thead>
                <th class="text-center">
                    User
                </th>
                <th class="text-center">
                    Unit
                </th>
                <th class="text-center">
                    Date
                </th>
                <th class="text-center">
                    Actions
                </th>
            </thead>

            <tbody>
                @forelse($tracking as $t)
                <tr>
                    <td class="text-center">
                        {{ $t->user->name }}
                    </td>
                    <td class="text-center">
                        {{ $t->exercise->section->unit->title }}
                    </td>
                    <td class="text-center">
                        {{ $t->created_at }}
                    </td>
                    <td class="text-center">
                        <a class="btn btn-success" href="{{ route('tracking.show', $t->id) }}">Details</a>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    
</div>

@endsection