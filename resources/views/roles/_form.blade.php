<div class="form-group">
    <x-form.input id="name" class="form-control-lg" :data-id="$role->id" name="name" label="Role Name" :value="$role->name" />
</div>

<div class="form-group">

    @foreach (config('abilities') as $ability => $label)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="abilities[]" value="{{ $ability }}" @if(in_array($ability, ($role->abilities ?? []) )) checked @endif>
        <label class="form-check-label" for="flexCheckDefault">
            {{ $label }}
        </label>
    </div>
    @endforeach

</div>

<div class="form-group">
    <button class="btn btn-primary">Save</button>
</div>