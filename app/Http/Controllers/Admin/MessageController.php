<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {

        return view('admin.messages.show', compact('message'));
    }

    // for delete message
    public function destroy(Message $message)
    {
        $message->delete();

        return back()->with(['info' => 'Správa bola vymazaná', 'type' => 'danger']);
    }
}
