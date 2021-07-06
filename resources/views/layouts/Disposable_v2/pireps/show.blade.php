@extends('app')
@section('title', trans_choice('common.pirep', 1).' '.$pirep->airline->code.$pirep->ident)
@include('disposable_functions')
@section('content')
  <div class="row row-cols-2">
    <div class="col-8">

      <div class="card mb-2">
        <div class="card-header p-0">
          <div class="row row-cols-2">
            <div class="col text-left">
              <h5 class="card-title m-1 p-1">{{ $pirep->airline->iata ?? $pirep->airline->icao }} {{ $pirep->flight_number }}
                @if($pirep->route_code)
                  <span class="badge badge-warning ml-1">{{ Dispo_RouteCode($pirep->route_code) }}</span>
                @endif
                @if($pirep->route_leg)
                  <span class="badge badge-warning ml-1">@lang('disposable.leg') #{{$pirep->route_leg}}</span>
                @endif
              </h5>
            </div>
            <div class="col text-right">
              <h5 class="card-title m-1 p-1">
                @if(!$pirep->read_only && $pirep->user_id === Auth::id())
                  <form method="get" action="{{ route('frontend.pireps.edit', $pirep->id) }}" style="display: inline">
                    @csrf
                    <button class="btn btn-sm btn-info mr-1">@lang('common.edit')</button>
                  </form>
                  <form method="post" action="{{ route('frontend.pireps.submit', $pirep->id) }}" style="display: inline">
                    @csrf
                    <button class="btn btn-sm btn-success mr-1">@lang('common.submit')</button>
                  </form>
                @endif
              </h5>
            </div>
          </div>
        </div>
        <div class="card-body p-1">
          <div class="row row-cols-2 mb-1">
            <div class="col text-left">
              <h6 class="m-0 p-0">{{$pirep->dpt_airport->location}}</h6>
            </div>
            <div class="col text-right">
              <h6 class="m-0 p-0">{{$pirep->arr_airport->location}}</h6>
            </div>
          </div>
          <div class="row row-cols-2">
            <div class="col text-left">
              <p class="p-0 mb-1"><a href="{{route('frontend.airports.show', $pirep->dpt_airport_id)}}">{{  $pirep->dpt_airport->iata }} / {{ $pirep->dpt_airport->full_name }}</a></p>
              <p class="p-0 mb-1">@if($pirep->block_off_time) {{ $pirep->block_off_time->format('D d.M.Y H:i') }} UTC @endif</p>
            </div>
            <div class="col text-right">
              <p class="p-0 mb-1"><a href="{{route('frontend.airports.show', $pirep->arr_airport_id)}}">{{  $pirep->arr_airport->iata }} / {{ $pirep->arr_airport->full_name }}</a></p>
              <p class="p-0 mb-1">@if($pirep->block_on_time) {{ $pirep->block_on_time->format('D d.M.Y H:i') }} UTC @endif</p>
            </div>
          </div>
        </div>
        <div class="card-footer p-1">
          <div class="progress progress-bar bg-success" role="progressbar" style="width: @if($pirep->progress_percent > 100) 100% @else {{ $pirep->progress_percent }}% @endif;"
              aria-valuenow="{{ $pirep->progress_percent }}" aria-valuemin="0" aria-valuemax="100">{{ $pirep->progress_percent }}%
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header p-0">
          <nav>
            <h5 class="m-0 p-0">
              <i class="fas fa-paper-plane float-right mt-2 mr-1 p-1"></i>
              <div class="nav nav-tabs m-0 p-0 border-0" id="nav-tab" role="tablist">
                <a class="nav-link active m-1 p-1 border-0" id="nav-map-tab" data-toggle="tab" href="#nav-map" role="tab" aria-controls="nav-map" aria-selected="true">@lang('disposable.routemap')</a>
                @if(count($pirep->fields) > 0)
                  <a class="nav-link m-1 p-1 border-0" id="nav-fields-tab" data-toggle="tab" href="#nav-fields" role="tab" aria-controls="nav-fields" aria-selected="false">@lang('disposable.pirepdetails')</a>
                @endif
                @if(count($pirep->acars_logs) > 0)
                  <a class="nav-link m-1 p-1 border-0" id="nav-log-tab" data-toggle="tab" href="#nav-log" role="tab" aria-controls="nav-log" aria-selected="false">@lang('disposable.acarslog')</a>
                @endif
              </div>
            </h5>
          </nav>
        </div>
        <div class="card-body p-0">
          <div class="tab-content" id="nav-tabContent">
            {{-- Map Tab --}}
            <div class="tab-pane fade show active" id="nav-map" role="tabpanel" aria-labelledby="nav-map-tab">
              @include('pireps.map')
            </div>
            {{-- Pirep Details Tab --}}
            <div class="tab-pane fade" id="nav-fields" role="tabpanel" aria-labelledby="nav-fields-tab">
              @if(count($pirep->fields) > 0)
                <table class="table table-sm table-borderless table-striped mb-0">
                  @foreach($pirep->fields as $field)
                    <tr>
                      <th width="20%" nowrap="true">{{ $field->name }}</th>
                      <td>
                        {!! Dispo_PirepFields($field->slug, $field->value, $pirep->aircraft->icao) !!}
                        @if(Dispo_Modules('DisposableTech'))
                          {!! Dispo_CheckWeights($pirep->id,$field->slug) !!}
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </table>
              @endif
            </div>
            {{-- Acars Log Tab --}}
            <div class="tab-pane fade" id="nav-log" role="tabpanel" aria-labelledby="nav-log-tab">
              @if(count($pirep->acars_logs) > 0)
                <table class="table table-sm table-borderless table-striped mb-0">
                  @foreach($pirep->acars_logs->sortBy('created_at') as $log)
                    <tr>
                      <td width="20%" nowrap="true">{{ $log->created_at->format('d.M.Y H:i') }} UTC</td>
                      <td>@if(Dispo_Modules('DisposableTech')) {!! Dispo_Flaps($pirep->aircraft->icao, $log->log) !!} @else {{ $log->log }} @endif</td>
                    </tr>
                  @endforeach
                </table>
              @endif
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="col-4">
      <div class="card mb-2">
        <div class="card-header p-0">
          <nav>
            <h5 class="m-0 p-0">
              <i class="fab fa-avianex float-right mt-2 mr-1 p-1"></i>
              <div class="nav nav-tabs m-0 p-0 border-0" id="nav-tab" role="tablist">
                <a class="nav-link active m-1 p-1 border-0" id="nav-basic-tab" data-toggle="tab" href="#nav-basic" role="tab" aria-controls="nav-basic" aria-selected="true">@lang('disposable.pirepinfo')</a>
                @if(!empty($pirep->simbrief))
                  <a class="nav-link m-1 p-1 border-0" id="nav-ofp-tab" data-toggle="tab" href="#nav-ofp" role="tab" aria-controls="nav-ofp" aria-selected="false">@lang('disposable.sbofp')</a>
                  <a class="nav-link m-1 p-1 border-0" href="{{ url(route('frontend.simbrief.briefing', [$pirep->simbrief->id])) }}">@lang('disposable.sbfull')</a>
                @endif
              </div>
            </h5>
          </nav>
        </div>
        <div class="card-body p-0">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-basic" role="tabpanel" aria-labelledby="nav-basic-tab">
              <table class="table table-sm table-borderless table-striped mb-0">
                <tr>
                  <th width="30%">@lang('disposable.pilotincommand')</th>
                  <td><a href="{{ route('frontend.profile.show', [$pirep->user_id]) }}">{{ $pirep->user->name_private }}</a></td>
                <tr>
                  <th>@lang('common.state')</th>
                  <td>{!! Dispo_PirepBadge($pirep->state) !!}</td>
                </tr>
                @if ($pirep->state !== PirepState::DRAFT)
                  <tr>
                    <th>@lang('common.status')</th>
                    <td><span class="badge badge-info">{{ PirepStatus::label($pirep->status) }}</span></td>
                  </tr>
                @endif
                <tr>
                  <th>@lang('flights.flighttype')</th>
                  <td>{{ \App\Models\Enums\FlightType::label($pirep->flight_type) }}</td>
                </tr>
                <tr>
                  <th>@lang('pireps.filedroute')</th>
                  <td>{{ strtoupper($pirep->route) }}</td>
                </tr>
                @if($pirep->aircraft)
                  <tr>
                    <th>@lang('common.aircraft')</th>
                    <td>
                      @if(Dispo_Modules('DisposableAirlines'))
                        <a href="{{ route('DisposableAirlines.daircraft', [$pirep->aircraft->registration]) }}">{{ $pirep->aircraft->registration }} ({{ $pirep->aircraft->icao }})</a>
                      @else
                        {{ $pirep->aircraft->registration }} ({{ $pirep->aircraft->icao }})
                      @endif
                      @if($pirep->simbrief && $pirep->aircraft->registration != $pirep->simbrief->xml->aircraft->reg)
                        <i class="fas fa-exclamation-circle ml-2" title="Registration Not Matching OFP !" style="color:firebrick;"></i>
                      @endif
                    </td>
                  </tr>
                @endif
                @if($pirep->state != 0)
                  <tr>
                    <th>@lang('disposable.blocktime')</th>
                    <td>@if($pirep->flight_time)@minutestotime($pirep->flight_time)@endif</td>
                  </tr>
                  <tr>
                    <th>@lang('pireps.block_fuel')</th>
                    <td>{{ Dispo_Fuel($pirep->block_fuel) }}</td>
                  </tr>
                  <tr>
                    <th>@lang('pireps.fuel_used')</th>
                    <td>{{ Dispo_Fuel($pirep->fuel_used) }}</td>
                  </tr>
                  <tr>
                    <th>@lang('disposable.fuel_rem')</th>
                    <td>
                      @if($pirep->block_fuel && $pirep->fuel_used)
                        {{ Dispo_Fuel($pirep->block_fuel - $pirep->fuel_used) }}
                      @endif
                    </td>
                  </tr>
                @endif
                @if(filled($pirep->notes))
                  <tr>
                    <th>{{ trans_choice('common.note',2) }}</th>
                    <td>{{ $pirep->notes }}</td>
                  </tr>
                @endif
                <tr>
                  <th>@lang('disposable.landingrate')</th>
                  <td>{{ $pirep->landing_rate.' ft/min' ?? '--' }}</td>
                </tr>
                <tr>
                  <th>@lang('disposable.score')</th>
                  <td>{{ $pirep->score ?? '--' }}
                      @if($pirep->score && $pirep->score < 50)<i class="fas fa-thumbs-down ml-2" style="color:darkred;"></i>
                      @elseif($pirep->score && $pirep->score < 70)<i class="fas fa-thumbs-up ml-2" style="color:darkgoldenrod;"></i>
                      @elseif($pirep->score && $pirep->score < 90)<i class="fas fa-thumbs-up ml-2" style="color:darkblue;"></i>
                      @elseif($pirep->score && $pirep->score >= 90)<i class="fas fa-thumbs-up ml-2" style="color:darkgreen;"></i>
                      @endif
                  </td>
                </tr>
                <tr>
                  <th>@lang('pireps.source')</th>
                  <td>{{ PirepSource::label($pirep->source) }}</td>
                </tr>
                <tr>
                  <th>@lang('pireps.filedon')</th>
                  <td>{{ $pirep->created_at->format('D d.M.Y H:i').' UTC' ?? '--' }}</td>
                </tr>
                <tr>
                  <th>@lang('pireps.submitted')</th>
                  <td>{{ $pirep->submitted_at->format('D d.M.Y H:i').' UTC' ?? '--' }}</td>
                </tr>
              </table>
            </div>
            @if(!empty($pirep->simbrief))
              <div class="tab-pane fade" id="nav-ofp" role="tabpanel" aria-labelledby="nav-ofp-tab">
                <div class="overflow-auto pl-1 pt-1" style="min-height: 750px;">
                  @if($pirep->simbrief->xml->params->units == 'lbs' && setting('units.weight') === 'kg' || $pirep->simbrief->xml->params->units == 'kgs' && setting('units.weight') === 'lbs' )
                    <p class="small text-uppercase p-1 mb-1"><b>*** ALL WEIGHTS IN {{ $pirep->simbrief->xml->params->units }} ***</b></p>
                  @endif
                  {!! $pirep->simbrief->xml->text->plan_html !!}
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>

      @if(count($pirep->fares) > 0 || count($pirep->transactions) > 0)
        <div class="card mb-2">
          <div class="card-header p-0"></h5>
            <nav>
              <h5 class="m-0 p-0">
                <i class="fas fa-file-invoice float-right mt-2 mr-1 p-1"></i>
                <div class="nav nav-tabs m-0 p-0 border-0" id="nav-tab" role="tablist">
                  @if(count($pirep->fares) > 0)
                    <a class="nav-link m-1 p-1 border-0" id="nav-fares-tab" data-toggle="tab" href="#nav-fares" role="tab" aria-controls="nav-fares" aria-selected="true">@lang('disposable.loadinfo')</a>
                  @endif
                  @if(count($pirep->transactions) > 0)
                    <a class="nav-link active m-1 p-1 border-0" id="nav-finance-tab" data-toggle="tab" href="#nav-finance" role="tab" aria-controls="nav-finance" aria-selected="false">@lang('disposable.transactions')</a>
                  @endif
                </div>
              </h5>
            </nav>
          </div>
          <div class="card-body p-0">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade" id="nav-fares" role="tabpanel" aria-labelledby="nav-fares-tab">
                <table class="table table-sm table-borderless table-striped mb-0">
                  <th width="30%">@lang('pireps.class')</th>
                  <th>@lang('pireps.count')</th>
                  @foreach($pirep->fares as $fare)
                    <tr>
                      <td width="30%">{{ $fare->fare->name }} ({{ $fare->fare->code }})</td>
                      <td>{{ $fare->count }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
              <div class="tab-pane fade show active" id="nav-finance" role="tabpanel" aria-labelledby="nav-finance-tab">
                <table class="table table-sm table-borderless table-striped mb-0 text-right">
                  <tr>
                    <th class="text-left">@lang('disposable.items')</th>
                    <th>@lang('disposable.credit')</th>
                    <th>@lang('disposable.debit')</th>
                  </tr>
                  @foreach($pirep->transactions->where('journal_id', $pirep->airline->journal->id) as $entry)
                    <tr>
                      <td class="text-left">{{ $entry->memo }}</td>
                      <td>@if($entry->credit){{ money($entry->credit, setting('units.currency')) }}@endif</td>
                      <td>@if($entry->debit){{ money($entry->debit, setting('units.currency')) }}@endif</td>
                    </tr>
                  @endforeach
                  <tr>
                    <td>
                      @php
                        $p_credit = $pirep->transactions->where('journal_id', $pirep->airline->journal->id)->sum('credit');
                        $p_debit = $pirep->transactions->where('journal_id', $pirep->airline->journal->id)->sum('debit');
                        $p_balance = $p_credit - $p_debit;
                      @endphp
                    </td>
                    <th>{{ money($p_credit, setting('units.currency')) }}</th>
                    <th>{{ money($p_debit, setting('units.currency')) }}</th>
                  </tr>
                </table>
                <div class="card-footer p-1 text-right">
                  <span class="float-left"><b>@lang('disposable.balance')</b></span>
                  <span style="color: @if($p_balance > 0) darkgreen @else darkred @endif;"><b>{{ money($p_balance, setting('units.currency')) }}</b></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
