@extends('layouts.dashboard')

@section('page-title')
    Settings
@endsection

@section('content')

    <x-flash-message />

    <form action="{{ route('config') }}" method="post">
        @csrf
        <div class="form-group">
            <x-form.input id="name" name="config[app.name]" label="App Name" :value="config('app.name')" />
        </div>
        <div class="form-group">
            <x-form.input id="locale" name="config[app.locale]" label="Locale" :value="config('app.locale')" />
        </div>
        <div class="form-group">
            <x-form.input id="currency" name="config[app.currency]" label="Currency" :value="config('app.currency')" />
        </div>
        <div class="form-group">
            <x-form.input id="timezone" name="config[app.timezone]" label="Timezone" :value="config('app.timezone')" />
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Save</button>
        </div>
    </form>

@endsection