@extends('layouts.main')

@section('title', 'Editando: ' . $event->title)

@section('content')

    <div id="event-create-container" class="col-md-6 offset-md-3">

        <h1>Editando: {{ $event->title }}</h1>

        <form action="/events/update/{{ $event->id }}" method="POST" enctype="multipart/form-data">
            <!-- enctype="multipart/form-data": necessário para enviar arquivos por um formulário html-->

            @csrf
            @method('PUT') <!-- forçando método 'PUT' -->

            <div class="form-group">
                <label for="image">Imagem do Evento:</label>
                <input type="file" id="image" name="image" class="form-control-file">
                <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-preview">
            </div>

            <br>

            <div class="form-group">
                <label for="title">Evento:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $event->title }}">
            </div>

            <br>

            <div class="form-group">
                <label for="date">Data do evento:</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $event->date->format('Y-m-d') }}">
            </div>

            <br>

            <div class="form-group">
                <label for="title">Cidade:</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $event->city }}">
            </div>

            <br>

            <div class="form-group">
                <label for="title">O evento é privado?</label>
                <select name="private" id="private" class="form-control">
                    <option value="0">Não</option>
                    <option value="1" {{ $event->private == 1 ? "selected='selected'" : "" }} >Sim</option>
                </select>
            </div>

            <br>

            <div class="form-group">
                <label for="title">Descrição:</label>
                <textarea name="description" id="description" class="form-control">{{ $event->description }}</textarea>
            </div>

            <br>

            <div class="form-group">

                <label for="title">Adicione itens de infraestrutura:</label>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras"> Cadeiras
                    <!-- []: necesário para envio de array de itens -->
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Palco"> Palco
                    <!-- []: necesário para envio de array de itens -->
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cerveja grátis"> Cerveja grátis
                    <!-- []: necesário para envio de array de itens -->
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Food"> Open Food
                    <!-- []: necesário para envio de array de itens -->
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Brindes"> Brindes
                    <!-- []: necesário para envio de array de itens -->
                </div>

            </div>

            <br>

            <input type="submit" class="btn btn-primary" value="Editar Evento">

        </form>

    </div>

@endsection