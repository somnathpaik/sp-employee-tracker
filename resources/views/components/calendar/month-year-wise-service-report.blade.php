<div>
    @if(count($work_report) > 0)    
    <h1 class="page-header custom_header">Service Report</h1>
    <table class="table table-bordered table-responsive">
        <thead>
            <tr class="bg-primary">
                <th class="text-center" width="10%">Year</th>
                @for ($i = 1; $i <= 12; $i++)
                <th class="text-center" width="7.5%">{{ date("F", mktime(0, 0, 0, $i, 10)) }}</th>
                @endfor
            </tr>

        </thead>
        <tbody>
            @forelse ($work_report as $year => $month_report)                
            <tr>
                <td>{{ $year }}</td>
                @foreach ($month_report as $work_data)
                <td style="color: {{ $work_data['front_color'] }}; background-color: {{ $work_data['back_ground_color'] }}" data-toggle='tooltip' title='{{ $work_data["title"] }}'>{{ $work_data['work_hour'] }}</td>
                @endforeach
            </tr>
            @empty
                <tr><td width="100%">No data found.</td></tr>
            @endforelse
        </tbody>
    </table>
    @endif
</div>