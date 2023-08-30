<div class="modal fade" id="selectGroupForDataExportModal" tabindex="-1" aria-labelledby="selectGroupForDataExportModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectGroupForDataExportModal">Select Group for Data Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tracking.export_data') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="ms-2 me-2 row">
                        <select name="group" class="form-select form-select-sm">
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generate file</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>