<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{

    public function index()
    {
        $search = request('search');

        if ($search)
        {
            $events = Event::where([
                ['title', 'like', '%' . $search . '%']
            ])->get(); //get(): pegando os registros
        }
        else
        {
            $events = Event::all(); //chamando todos os eventos do banco
        }

        return view('welcome', ['events' => $events, 'search' => $search]); //[passando os 'events' e 'seach' para a view]
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request) //os dados do formulário vao vir do $request
    {
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items; //este dado vem em array e não em string
        //criado o casts no model ref. ao 'items'

        // Image Upload
        if ($request->hasFile('image') && $request->file('image')->isValid())
        //verificando se é um arquivo de imagem
        {
            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            //salvando imagem no servidor
            $request->image->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
        }

        //pegando usuário logado | fazendo inserção do usuário na tabela 'user_id'
        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save(); //salvando os dados no banco

        //redirecionando para a página home (index)
        return redirect('/')->with('msg', 'Evento criado com sucesso!');
        //with: flash message para o usuário

    }

    public function show($id) //$id vindo do front-end
    {
        //findOrFail(): faz a verificação no banco se existe um registro com id tal, se não retorna um erro
        $event = Event::findOrFail($id);

        $user = auth()->user(); //pegando usuário autenticado

        $hasUserJoined = false;

        //verificando se o usuário já está participando do evento para não ter duplicidade
        if ($user)
        {
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach ($userEvents as $userEvent)
            {
                if ($userEvent['id'] == $id) //$id: id do evento que vem do request | ['id']: id dos eventos que o usuário participa
                {
                    $hasUserJoined = true;
                }
            }
        }

        //sabendo quem é o dono do evento|first(): primeiro que ele encontrar|toArray(): transformando dado de objeto em array
        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);
        // [passando dados para a view]
    }

    public function dashboard()
    {
        //pegando usuário autenticado
        $user = auth()->user();

        //verificando eventos do usuário
        $events = $user->events; //events: é a função events na model User

        //eventos que o usuáio participa
        $eventAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsasparticipant' => $eventAsParticipant]);
        //[mandando os 'events' e 'eventsasparticipant' para a view]
    }

    public function destroy($id)
    {
        //findOrFail(): faz a verificação no banco se existe um registro com id tal, se não retorna um erro
        Event::findOrFail($id)->delete();

        //redirecionando para o dashboard
        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
        //with: flash message para o usuário
    }

    public function edit($id)
    {
        $user = auth()->user(); //pegando usuário autenticado

        //findOrFail(): faz a verificação no banco se existe um registro com id tal, se não retorna um erro
        $event = Event::findOrFail($id);

        //regra para usuário conseguir editar apenas evento que ele criou (evento dele)
        if ($user->id != $event->user_id)
        {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // Image Upload
        if ($request->hasFile('image') && $request->file('image')->isValid())
            //verificando se é um arquivo de imagem
        {
            $requestImage = $request->image;
        
            $extension = $requestImage->extension();
        
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
        
                //salvando imagem no servidor
            $request->image->move(public_path('img/events'), $imageName);
        
            $data['image'] = $imageName;
        }

        //findOrFail(): faz a verificação no banco se existe um registro com id tal, se não retorna um erro
        Event::findOrFail($request->id)->update($data);

        //redirecionando para o dashboard
        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
        //with: flash message para o usuário
    }

    //unindo um usuário à um evento, many to many (confirmar presença no evento)
    public function joinEvent($id)
    {
        $user = auth()->user(); //pegando usuário autenticado

        //salvando usuário ao evento
        $user->eventsAsParticipant()->attach($id);
        //attach(): insere o id do evento no id do usuário para o método e preenche a coluna na tabela

        //findOrFail(): faz a verificação no banco se existe um registro com id tal, se não retorna um erro
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $event->title);
    }

    //remover presença do evento
    public function leaveEvent($id)
    {
        $user = auth()->user(); //pegando usuário autenticado

        $user->eventsAsParticipant()->detach($id);
        //detach(): remove o id do evento no id do usuário para o método e remove o o dado na tabela

        //findOrFail(): faz a verificação no banco se existe registro com id tal, se não retorna um erro
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $event->title);

    }
    
}
