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
                    <li class="nav-item"><a class="nav-link" href="{{route('campaign.index')}}">Overview</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="{{route('campaign.report', $campaign->id)}}">Room capacity</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$campaign->name}}</h1>
                </div>
                <span class="h6">{{date('F d, Y', strtotime($campaign->date ))}}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Edit session</h2>
                </div>
            </div>

            <form class="needs-validation" novalidate action="{{{route('session.update', [$campaign->id, $session->id])}}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectType">Type</label>
                        <select class="form-control" id="selectType" name="type">
                            <option value="normal" {{$session->type == 'normal' ? 'selected' : ''}} {{old('place') == $session->type ? 'selected' : ''}}>Normal</option>
                            <option value="service" {{$session->type == 'service' ? 'selected' : ''}} {{old('place') == $session->type ? 'selected' : ''}}>Service</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputTitle">Title</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" class="form-control {{$errors->first('title') ? 'is-invalid': ''}}" id="inputTitle" name="title" placeholder="" value="{{old('title') ? old('title') : $session->title}}">
                        <div class="invalid-feedback">
                            {{$errors->first('title')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputParticipant">Participant</label>
                        <input type="text" class="form-control {{$errors->first('vaccinator') ? 'is-invalid': ''}}" id="inputParticipant" name="vaccinator" placeholder="" value="{{old('vaccinator') ? old('vaccinator') : $session->vaccinator}}">
                        <div class="invalid-feedback">
                            {{$errors->first('participant')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectRoom">Place</label>
                        <select class="form-control" id="selectRoom" name="place_id">
                            @foreach ($campaign->area as $area)
                            @foreach ($area->place as $place)
                            <option value="{{$place->id}}" {{$session->place->id == $place->id ? 'selected' : ''}} {{old('place') == $place->id ? 'selected' : ''}}>{{$place->name}} / {{$area->name}} </option>
                            @endforeach
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Place is required.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputCost">Cost</label>
                        <input type="number" class="form-control {{$errors->first('cost') ? 'is-invalid': ''}}" id="inputCost" name="cost" placeholder="" value="{{old('cost') ? old('cost') : $session->cost}}">
                        <div class="invalid-feedback">
                            {{$errors->first('cost')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="inputStart">Start</label>
                        <input type="text" class="form-control {{$errors->first('start') ? 'is-invalid': ''}}" id="inputStart" name="start" placeholder="yyyy-mm-dd HH:MM" value="{{old('start') ? old('start') : $session->start}}">
                        <div class="invalid-feedback">
                            {{$errors->first('start')}}
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="inputEnd">End</label>
                        <input type="text" class="form-control {{$errors->first('end') ? 'is-invalid': ''}}" id="inputEnd" name="end" placeholder="yyyy-mm-dd HH:MM" value="{{old('end') ? old('end') : $session->end}}">
                        <div class="invalid-feedback">
                            {{$errors->first('end')}}
                        </div>
                    </div>
                    <div class="invalid-feedback d-block ml-3">
                        {{$errors->first('time')}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="textareaDescription">Description</label>
                        <textarea class="form-control {{$errors->first('description') ? 'is-invalid': ''}}" id="textareaDescription" name="description" placeholder="" rows="5">{{old('description') ? old('description') : $session->description}}</textarea>
                        <div class="invalid-feedback">
                            {{$errors->first('description')}}
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit">Save session</button>
                <a href="campaigns/detail.html" class="btn btn-link">Cancel</a>
            </form>

        </main>
    </div>
</div>
@endsection