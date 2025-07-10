<div>
    <div class="row">
        @foreach($data as $val)
            <div class="col-lg-3">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3>{{$val->total}}</h3>
                        <p>{{$val->derived_status}} Topics</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
