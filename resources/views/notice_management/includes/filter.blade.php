<form method="GET" action="{{ route('notice-management.index') }}" autocomplete="on">
    <div class="col-lg-2">
        <select name="search_notice_type" class="form-control">
            <option value="">Search notice type</option>
            @foreach (App\Models\NoticeManagement::NOTICE_TYPE_ARRAY as $key => $value)
            <option value="{{ $key }}" @if($key==old('search_notice_type', request()->get('search_notice_type'))) selected @endif>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2">
        <select name="search_notice_level" class="form-control">
            <option value="">Search notice level</option>
            @foreach (App\Models\NoticeManagement::NOTICE_LEVEL_ARRAY as $key => $value)
            <option value="{{ $key }}" @if($key==old('search_notice_level', request()->get('search_notice_level'))) selected @endif>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3">
        <input type="text" name="search_notice_user" value="{{ old('search_notice_user', request()->get('search_notice_user')) }}" class="form-control" placeholder="Input user name and search">
    </div>
    <div class="col-lg-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>