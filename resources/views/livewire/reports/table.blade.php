<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <strong class="text-lg">Topic List</strong>
                </div>
            </div>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table-sm table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th class="align-middle p-0">User</th>
                        <th class="align-middle p-0">Topic</th>
                        <th class="align-middle p-0">Next Topic</th>
                        <th class="align-middle p-0">Target Date</th>
                        <th class="align-middle p-0">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topics as $topic)
                        <tr>
                            <td class="py-0 align-middle">
                                @if(!empty($topic->responsibles->count()))
                                    @foreach($topic->responsibles as $responsible)
                                        {{$responsible->name}}
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-0 align-middle">
                                <a href="{{route('mom.topic', encrypt($topic->id))}}">
                                    {{$topic->topic}}
                                </a>
                            </td>
                            <td class="py-0 align-middle">
                                {{$topic->next_step}}
                            </td>
                            <td class="py-0 align-middle">
                                {{$topic->target_date}}
                            </td>
                            <td class="py-0 align-middle">
                                <span class="badge badge-{{$status_arr[$topic->derived_status]}}">{{$topic->derived_status}}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="card-footer pb-0">
            {{$topics->links()}}
        </div>
    </div>
</div>
