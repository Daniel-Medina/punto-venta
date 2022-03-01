@include('common.modalhead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name"
            placeholder="Ej: Laravel" class="form-control">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Telefono</label>
            <input type="text" wire:model.lazy="phone"
            placeholder="Ej: 918391993" class="form-control" maxlength="10">
            @error('phone')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="email" wire:model.lazy="email"
            placeholder="Ej: danny_2003@ovi.com" class="form-control">
            @error('email')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" wire:model.lazy="password"
            class="form-control">
            @error('password')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estatus</label>

            <select wire:model.lazy="status" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                <option value="ACTIVE">Activo</option>
                <option value="LOCKED">Bloqueado</option>
            <select>

            @error('status')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Rol</label>

            <select wire:model.lazy="profile" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($roles as $rol)
                    <option value="{{$rol->name}}">{{$rol->name}}</option>
                @endforeach
            <select>

            @error('profile')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label>Imagen de perfil</label>
            <input type="file" wire:model="image" accept="image/x-png, image/jpeg, image/jpg" class="form-control">
            @error('image')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')