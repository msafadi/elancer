<div class="form-group">
    <x-form.input id="name" class="form-control-lg" :data-id="$category->id" name="name" label="Category Name" :value="$category->name" />
</div>
<div class="form-group">
    <x-form.input id="slug" name="slug" label="Category Slug" :value="$category->slug" />
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
    @error('description')
    <p class="text-danger">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <x-form.select id="parent_id" name="parent_id" label="Parent" :options="$parents->pluck('name', 'id')" :selected="$category->parent_id" />
</div>
<div class="form-group">
    <label for="art_file">Art File</label>
    <input type="file" id="art_file" name="art_file" class="form-control @error('art_file') is-invalid @enderror">
    @error('art_file')
    <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <button class="btn btn-primary">Save</button>
</div>