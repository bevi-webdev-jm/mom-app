<div>
    <div class="card">
        <div class="card-header">
            <div class="col-lg-6 align-middle">
                <strong class="text-lg">{{__('adminlte::moms.mom_history')}}</strong>
            </div>
            <div class="col-lg-6 text-right">
                
            </div>
        </div>
        <div class="card-body p-1">

            @if(!empty($approvals))
                <div class="timeline timeline-inverse" style="max-height: 800px; overflow-y: auto;">

                    @foreach($approvals as $date => $data)
                        {{-- DATE LABEL --}}
                        <div class="time-label">
                            <span class="bg-primary text-uppercase">
                                {{date('M j Y', strtotime($date))}}
                            </span>
                        </div>

                        @foreach($data as $approval)
                            <!-- timeline item -->
                            <div>
                                <i class="fas fa-user bg-{{$status_arr[$approval->status]}}"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="far fa-clock"></i> {{$approval->created_at}}</span>

                                    <h3 class="timeline-header {{!empty($approval->remarks) ? '' : 'border-0'}}">
                                        <a href="#">{{$approval->user->name}}</a> <span class="mx-2 badge bg-{{$status_arr[$approval->status]}}">{{$approval->status}}</span> the {{__('adminlte::moms.mom')}}
                                    </h3>

                                    @if(!empty($approval->remarks))
                                        <div class="timeline-body">
                                            <label class="mb-0">REMARKS:</label>
                                            <pre class="mb-0 ml-2">{{$approval->remarks ? preg_replace('/[^\S\n]+/', ' ', $approval->remarks) : '-'}}</pre>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    @endforeach

                    <div>
                        <i class="far fa-clock bg-gray"></i>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        {{$approval_dates->links()}}
                    </div>
                </div>
            @else
                <div class="text-center">
                    - {{__('adminlte::moms.no_mom_history')}} -
                </div>
            @endif

        </div>
    </div>
            
</div>
