@extends('layouts.app')

@section('subtitle')
{{ $song->name_new }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <form method="post" action="{{ route('songs.update', ['id' => $song]) }}" id="song_update_form">
                @csrf
                @method('PATCH')

                <!-- access_level -->
                {{ __('labels.parttitle_access_level') }}
                <div class="alert alert-light x-alert-small-padding x-alert-light-black">
                    @foreach ([0, 2, 3] as $lv)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level"
                               id="access_level_{{ $lv }}" value="{{ $lv }}"
                               @if ($lv === $song->access_level)
                               checked
                               @endif
                        >
                        <label class="form-check-label" for="access_level_{{ $lv }}"
                        >{{ __('texts.caption_access_level_'.$lv) }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="form-group row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
