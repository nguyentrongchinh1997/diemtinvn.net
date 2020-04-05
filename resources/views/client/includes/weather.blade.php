<div class="hidden-xs weather-wrapper">
    <div class="row thm-margin">
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 weather-week thm-padding">
            <div class="list-group">
                <a href="#" class="list-group-item active">
                    <img class="weather-image-small" src="{{ asset("images/weather") }}/{{$weather[1]['weather']['icon']}}.png">
                    <div>{{ getWeekday($weather[1]['valid_date']) }}, {{ $weather[1]['min_temp'] }} °C</div>
                </a>
                <a href="#" class="list-group-item">
                    <img class="weather-image-small" src="{{ asset("images/weather") }}/{{$weather[2]['weather']['icon']}}.png">
                    <div>{{ getWeekday($weather[2]['valid_date']) }}, {{ $weather[2]['min_temp'] }} °C</div>
                </a>
                <a href="#" class="list-group-item">
                    <img class="weather-image-small" src="{{ asset("images/weather") }}/{{$weather[3]['weather']['icon']}}.png">
                    <div>{{ getWeekday($weather[3]['valid_date']) }}, {{ $weather[3]['min_temp'] }} °C</div>
                </a>
                <a href="#" class="list-group-item">
                    <img class="weather-image-small" src="{{ asset("images/weather") }}/{{$weather[4]['weather']['icon']}}.png">
                    <div>{{ getWeekday($weather[4]['valid_date']) }}, {{ $weather[4]['min_temp'] }} °C</div>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9 bhoechie-tab thm-padding">
            <!-- weather temperature -->
            <div class="weather-temp-wrap active">
                <div class="city-day">
                    <div class="city">Hà Nội</div>
                    <div class="day">{{ getWeekday($weather[0]['valid_date']) }}, {{ date('d/m/Y', strtotime($weather[0]['valid_date'])) }}</div>
                </div>
                <div class="weather-icon" style="padding-left: 0px">
                    {{-- <p>{{}}</p> --}}
                    <img class="weather-image" src="{{ asset("images/weather") }}/{{$weather[0]['weather']['icon']}}.png">
                    <div class="main-temp">{{ $weather[0]['min_temp'] }} °C</div>
                </div>
                <div class="break">
                    <div class="wind-condition"> Gió: {{ number_format($weather[0]['wind_gust_spd']) }} m/s</div>
                    <div class="humidity">Độ ẩm: {{$weather[0]['rh']}}%</div>
                </div>
            </div>
        </div>
    </div>
</div>