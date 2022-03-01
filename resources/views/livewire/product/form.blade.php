@include('common.modalHead')


    <div class="row">

        <div class="col-sm-12 col-md-8">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Coca-cola">
                @error('name')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>C. Barras</label>
                <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 3959593">
                @error('barcode')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Costo</label>
                <input type="number" data-type="currency" wire:model.lazy="cost" class="form-control" placeholder="ej: 12">
                @error('cost')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Precio</label>
                <input type="number" data-type="currency" wire:model.lazy="price" class="form-control" placeholder="ej: 15">
                @error('price')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Existencias</label>
                <input type="number" wire:model.lazy="stock" class="form-control" placeholder="ej: 30">
                @error('stock')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Inventario min.</label>
                <input type="number" data-type="currency" wire:model.lazy="alerts" class="form-control" placeholder="ej: 10">
                @error('alerts')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>Categoria</label>
                <select class="form-control" wire:model="category_id">
                    <option value="Elegir" disabled>Elegir</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-8">
            <div class="form-group custom-file">
                <input type="file" wire:model.lazy="image" class="custom-file-input form-control" placeholder="ej: 15" accept="image/x-png, image/gif, image/jpeg">
                <label class="custom-file-label">Imágen {{$image}}</label>
                @error('image')
                    <span class="text-danger er">{{$message}}</span>
                @enderror
            </div>
        </div>

    </div>


@include('common.modalFooter')