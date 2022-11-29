@extends('layouts.app')
@section('main')

<style>
    .clickable-table-row {
        cursor: pointer !important;
    }

    .clickable-table-row:hover {
        background-color: lightgray !important;
    }
</style>

<div class="container">
    <h3 class="mt-4">Tracking System</h3>
    <div class="overflow-auto border mt-4 mb-4" style="height: 70vh;">
        <table class="table">
            <thead>
                <th class="text-center">
                    Student ID
                </th>
                <th class="text-center">
                    Unit
                </th>
                <th class="text-center">
                    Group
                </th>
                <th class="text-center">
                    Exercise
                </th>
                <th class="text-center">
                    Date/Time
                </th>
                <th class="text-center"></th>
            </thead>

            <tbody>
                @forelse($tracking as $t)
                <tr class="clickable-table-row" onclick="navigateTo({{ json_encode(route('tracking.show', $t->id)) }})">
                        <td class="text-center">
                            {{ $t->user->user_id }}
                        </td>
                        <td class="text-center">
                            @if(isset($t->exercise->section->unit->title)) {{ $t->exercise->section->unit->title }} @else Not found @endif
                        </td>
                        <td class="text-center">
                            @if(isset($t->user->group->name)) {{ $t->user->group->name }} @else Not found @endif
                        </td>
                        <td class="text-center">
                            @if(isset($t->exercise)) {{ $t->exercise->exerciseType->name . " - " . $t->exercise->section->name }} @else Not found @endif
                        </td>
                        <td class="text-center">
                            {{ date('d/m/Y - h:i:s', strtotime($t->created_at)); }}
                        </td>
                        <td class="text-center">
                            <div class="btn rounded-cirlce btn-link">
                                <i class="mdi mdi-chevron-right"></i>
                            </div>
                        </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <br>
    <form action="{{ route('tracking.execute_filter') }}" method="POST">
		@csrf
		@method('POST')
		<div class="d-flex">
			<div class="ms-2 me-2 row">
				<p>Filter</p>
			</div>
			<div class="ms-2 me-2 row">
				<select name="group" id="" class="form-select form-select-sm">
					<option value="any">Any</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
				</select>
			</div>
			<div class="ms-2 me-2 row">
				<select name="student" id="" class="form-select form-select-sm">
					<option value="any">Any</option>
					@foreach($groups as $group)
                        <optgroup label="{{ $group->name }}">
                            @foreach($students as $student)
                                @if($student->group_id == $group->id)
                                    <option value="{{ $student->id }}">{{ $student->user_id }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    @endforeach
				</select>
			</div>
			<div class="ms-2 me-2 row">
				<button class="btn btn-success" type="submit">
					Filter
				</button>
			</div>
		</div>
	</form>
</div>

<script>
    function navigateTo(url) {
        window.location.href = url;
    }
</script>

@endsection