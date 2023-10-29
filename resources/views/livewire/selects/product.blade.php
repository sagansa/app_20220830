<div>
    <div class="mt-4 form-group row">
        <label for="provinces" class="col-md-4 col-form-label text-md-right">
            Province name
        </label>
        <div class="col-md-6">
            <x-virtual-select id="province" wire:model="city.province_id" options="provinces" multiple="false" />
            @error('city.province_id')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
