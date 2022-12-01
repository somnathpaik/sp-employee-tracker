<div>
    @if($interview_logs->count())
    <h1 class="page-header custom_header">Interview Logs</h1>
    <table class="table table-bordered table-responsive">
        <thead>
            <tr class="bg-primary">
                <th class="text-center">Sr. No.</th>
                <th class="text-center">Interview Date Time</th>
                <th class="text-center">Status</th>
                <th class="text-center">Update Datetime</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interview_logs as $interview_log)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ carbon_date_time($interview_log->date_time)->format(config('setting.date_time')) }}</td>
                <td class="text-center">{{ $interview_log->status_text }}</td>
                <td class="text-center">{{ $interview_log->updated_at->format(config('setting.date_time')) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center">No data found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif
</div>