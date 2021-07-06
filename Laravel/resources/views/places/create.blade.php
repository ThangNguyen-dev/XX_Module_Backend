@extends('layouts.app')

@extends('layouts.header')

@section('content')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="campaigns/index.html">Manage Campaigns</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{$campaign->name}}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{route('campaign.show',$campaign->id)}}">Overview</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="{{route('campaign.report', $campaign->id)}}">Place capacity</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$campaign->name}}</h1>
                </div>
                <span class="h6">{{date('F m, Y',strtotime($campaign->date))}}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Create new Place</h2>
                </div>
            </div>

            <form class="needs-validation" novalidate action="{{route('place.store', $campaign->id)}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputName">Name</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" class="form-control {{$errors->first('name')  ? 'is-invalid': ''}}" id="inputName" name="name" placeholder="" value="{{old('name') ? old('name') : ''}}">
                        <div class="invalid-feedback">
                            {{$errors->first('name')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectChannel">Area</label>
                        <select class="form-control" id="selectChannel" name="area">
                            @foreach ($campaign->area as $area)
                            <option value="{{$area->id}}" {{old('area') == $area->id ? 'selected' : ''}}>{{$area->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputCapacity">Capacity</label>
                        <input type="number" class="form-control {{$errors->first('capacity')  ? 'is-invalid': ''}}" id="inputCapacity" name="capacity" placeholder="" value="{{old('capacity') ? old('capacity') : '0'}}">
                        <div class="invalid-feedback">
                            {{$errors->first('capacity')}}
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit">Save place</button>
                <a href="{{route('campaign.show',$campaign->id)}}" class="btn btn-link">Cancel</a>
            </form>

        </main>
    </div>
</div>

@endsection